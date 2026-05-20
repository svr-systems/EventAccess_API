<?php

namespace App\Http\Controllers;

use App\Models\CfdiUsage;
use App\Models\Company;
use App\Models\Event;
use App\Models\FiscalRegime;
use App\Models\StandAllocation;
use App\Models\StandRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Facturapi\Facturapi;
use Illuminate\Support\Carbon;
use stdClass;
use Storage;
use Throwable;

class FacturapiController extends Controller {
  public static function errMsg($err) {
    $err_str = $err->getMessage();
    $err_str = (array) json_decode(substr($err_str, strpos($err_str, '{'), strpos($err_str, '}')), true);

    switch ($err_str['message']) {
      case 'Este RFC del receptor no existe en la lista de RFC inscritos no cancelados del SAT':
        $err_str = 'FISCAL: RFC incorrecto';
        break;
      case 'La clave del campo RegimenFiscalReceptor debe corresponder con el tipo de persona (física o moral).':
        $err_str = 'FISCAL: Régimen incorrecto';
        break;
      case "El nombre o razón social del receptor no coincide con el RFC registrado en el SAT; recuerda que con CFDI 4.0, debe ingresarse en mayúsculas y sin acentos, además ya no debes incluir el régimen societario (ej. \"S.A. de C.V.\")":
        $err_str = "FISCAL: Nombre | Razón social incorrecto, ingresar sin acentos y no incluir el régimen societario (ej. \"S.A. de C.V.\")";
        break;
      case 'El campo DomicilioFiscalReceptor del receptor, debe pertenecer al nombre asociado al RFC registrado en el campo Rfc del Receptor.':
        $err_str = 'FISCAL: CP incorrecto';
        break;
      // default:
      //   $err_str = $err_str['message'];
    }

    return $err_str;
  }

  public static function createCustomer($data) {
    $fiscal_regime = FiscalRegime::find($data->fiscal_regime_id);

    return [
      'tax_id' => $data->fiscal_code,
      'legal_name' => $data->fiscal_name,
      'address' => ['zip' => $data->fiscal_zip],
      'tax_system' => $fiscal_regime->code
    ];
  }

  public static function validCustomer($data) {
    $fapi = new Facturapi(env('FACTURAPI_KEY'));
    $rsp = new stdClass;
    $rsp->msg = null;
    $rsp->err = null;

    $customer = FacturapiController::createCustomer($data);

    try {
      $customer = $fapi->Customers->create($customer);
      try {
        $fapi->Customers->delete($customer->id);
      } catch (Throwable $err) {

      }

      return $rsp;
    } catch (Throwable $err) {
      $rsp->msg = $err->getMessage();
      $rsp->err = $err->getMessage();

      return $rsp;
    }
  }


  public static function storeOrganization(Request $request) {
    try {
      $fapi = new Facturapi(env('FACTURAPI_USER_KEY'));
      $rsp = new stdClass;
      $rsp->status = false;
      $rsp->msg = null;
      $rsp->err = null;

      $fiscal_organization_id = $request->fiscal_organization_id;

      if (!$fiscal_organization_id) {
        try {
          $organization = $fapi->Organizations->create(array(
            'name' => $request->name
          ));

          $fiscal_organization_id = $organization->id;

          $organization = $fapi->Organizations->updateCustomization(
            $fiscal_organization_id,
            [
              'pdf_extra' => [
                'round_unit_price' => true,
                "tax_breakdown" => false,
                "ieps_breakdown" => false
              ]
            ],
          );
          $fiscal_organization_id = $organization->id;
        } catch (Throwable $err) {
          $rsp->msg = "Ocurrió un error al general la organización";
          $rsp->err = $err;
          return $rsp;
        }
      }

      $fiscal_regime = FiscalRegime::find($request->fiscal_regime_id, ['code']);
      try {
        $organization = $fapi->Organizations->updateLegal(
          $fiscal_organization_id, [
            'name' => $request->name,
            'legal_name' => $request->fiscal_name,
            'tax_system' => $fiscal_regime->code,
            'address' => [
              'zip' => $request->fiscal_zip,
              'street' => '-',
              'exterior' => '-',
            ]
          ]
        );
      } catch (Throwable $err) {
        $rsp->msg = "Ocurrió un error al actualizar la organización";
        $rsp->err = $err;
        return $rsp;
      }

      $rsp->status = true;
      $rsp->fiscal_organization_id = $fiscal_organization_id;

      return $rsp;

    } catch (Throwable $err) {
      return $err;
    }
  }

  public static function storeCertificationOrganization(Request $request, $fiscal_organization_id) {
    try {
      $fapi = new Facturapi(env('FACTURAPI_USER_KEY'));
      $rsp = new stdClass;
      $rsp->status = false;
      $rsp->msg = null;
      $rsp->err = null;

      try {
        $organization = $fapi->Organizations->uploadCertificate(
          $fiscal_organization_id,
          [
            'cerFile' => $request->cer_doc,
            'keyFile' => $request->key_doc,
            'password' => $request->password,
          ],
        );
      } catch (Throwable $err) {
        $rsp->msg = "Ocurrió un error al cargar los archivos de la organización";
        $rsp->err = $err;
        return $rsp;
      }

      $rsp->status = true;
      $rsp->fiscal_certificate_updated_at = Carbon::parse($organization->certificate->updated_at)->format('Y-m-d H:i:s');
      $rsp->fiscal_certificate_expires_at = Carbon::parse($organization->certificate->expires_at)->format('Y-m-d H:i:s');
      $rsp->fiscal_certificate_serial_number = $organization->certificate->serial_number;

      $rsp->status = true;

      return $rsp;

    } catch (Throwable $err) {
      return $err;
    }
  }

  public static function stampNexoraInvoice($stand_allocation_id) {
    try {
      $response = new \stdClass;
      $response->status = false;
      $facturapi = new Facturapi(env('FACTURAPI_KEY'));

      $stand_allocation = StandAllocation::find($stand_allocation_id);
      $stand_request = StandRequest::find($stand_allocation->stand_request_id);
      $event = Event::find($stand_allocation->event_id);
      $supplier = Supplier::find($stand_allocation->supplier_id);
      if (!$supplier->fiscal_code) {
        $response->message = "La información fiscal no ha sido cargada";
        return $response;
      }
      $fiscal_regimes = FiscalRegime::find($supplier->fiscal_regime_id);
      $cfdi_usege = CfdiUsage::find($supplier->cfdi_usage_id);

      $customer = [
        "legal_name" => $supplier->fiscal_name,
        "tax_id" => $supplier->fiscal_code,
        "tax_system" => $fiscal_regimes->code,
        "address" => [
          "zip" => $supplier->fiscal_zip,
          "country" => "MEX"
        ]
      ];

      try {
        $customer = $facturapi->Customers->create($customer);
      } catch (Throwable $err) {
        $response->message = "La información fiscal no coincide con los registros del SAT";
        return $response;
      }

      
      // dd($customer);

      // $price = $consultation->charge_amount / 1.16;
      $taxes = [
        [
          "type" => "IVA",
          "rate" => 0.16
        ]
      ];

      $price = $stand_request->price * ($event->commission_percentage / 100);

      $item = [
        [
          "quantity" => 1,
          "discount" => 0,
          "product" => [
            "description" => "COMISION POR SERVICIO",
            "product_key" => "85121600",
            "unit_key" => "E48",
            "price" => $price,
            "tax_included" => true,
            "taxes" => $taxes
          ]
        ]
      ];

      $invoice = $facturapi->Invoices->create([
        "customer" => $customer->id,
        "items" => $item,
        "payment_form" => '04',
        "payment_method" => 'PUE',
        "use" => $cfdi_usege->code
      ]);

      $pdf = $facturapi->Invoices->download_pdf($invoice->id);
      $xml = $facturapi->Invoices->download_xml($invoice->id);
      $response->pdf = base64_encode($pdf);
      $response->xml = base64_encode($xml);

      $file_path_xml = public_path('..') . "/storage/app/private/temp/" . time() . ".xml";
      $file_path_pdf = public_path('..') . "/storage/app/private/temp/" . time() . ".pdf";
      file_put_contents($file_path_xml, $xml);
      file_put_contents($file_path_pdf, $pdf);

      // EmailController::sendInvoiceFiles(null, null, $file_path_xml, $file_path_pdf);
      Storage::delete($file_path_xml);
      Storage::delete($file_path_pdf);

      $stand_allocation->nexora_invoice_id = $invoice->id;
      $stand_allocation->save();

      $response->status = true;
      return $response;
    } catch (Throwable $err) {
      $response = new \stdClass;
      $response->status= false;
      $response->message = $err;
      return $response;
    }
  }

  public static function stampOrganizationInvoice($stand_allocation_id) {
    try {
      $response = new \stdClass;

      $stand_allocation = StandAllocation::find($stand_allocation_id);
      $stand_request = StandRequest::find($stand_allocation->stand_request_id);
      $event = Event::find($stand_allocation->event_id);
      $company = Company::find($event->company_id);
      $supplier = Supplier::find($stand_allocation->supplier_id);
      if (!$supplier->fiscal_code) {
        $response->message = "La información fiscal no ha sido cargada";
        return $response;
      }
      $fiscal_regimes = FiscalRegime::find($supplier->fiscal_regime_id);
      $cfdi_usege = CfdiUsage::find($supplier->cfdi_usage_id);


      $facturapi = new Facturapi(env('FACTURAPI_USER_KEY'));
      $organization_key = $facturapi->Organizations->getTestApiKey(
        $company->fiscal_organization_id
      );
      $facturapi = new Facturapi($organization_key);

      $customer = [
        "legal_name" => $supplier->fiscal_name,
        "tax_id" => $supplier->fiscal_code,
        "tax_system" => $fiscal_regimes->code,
        "address" => [
          "zip" => $supplier->fiscal_zip,
          "country" => "MEX"
        ]
      ];

      try {
        $customer = $facturapi->Customers->create($customer);
      } catch (Throwable $err) {
        $response->message = "La información fiscal no coincide con los registros del SAT";
        return $response;
      }

      // $price = $consultation->charge_amount / 1.16;
      $taxes = [
        [
          "type" => "IVA",
          "rate" => 0.16
        ]
      ];

      $price = $stand_request->price * (1 - ($event->commission_percentage / 100));

      $item = [
        [
          "quantity" => 1,
          "discount" => 0,
          "product" => [
            "description" => "TARIFA POR SERVICIO",
            "product_key" => "85121600",
            "unit_key" => "E48",
            "price" => $price,
            "tax_included" => true,
            "taxes" => $taxes
          ]
        ]
      ];

      $invoice = $facturapi->Invoices->create([
        "customer" => $customer->id,
        "items" => $item,
        "payment_form" => '04',
        "payment_method" => 'PUE',
        "use" => $cfdi_usege->code
      ]);

      $pdf = $facturapi->Invoices->download_pdf($invoice->id);
      $xml = $facturapi->Invoices->download_xml($invoice->id);
      $response->pdf = base64_encode($pdf);
      $response->xml = base64_encode($xml);

      $file_path_xml = public_path('..') . "/storage/app/private/temp/" . time() . ".xml";
      $file_path_pdf = public_path('..') . "/storage/app/private/temp/" . time() . ".pdf";
      file_put_contents($file_path_xml, $xml);
      file_put_contents($file_path_pdf, $pdf);

      // EmailController::sendInvoiceFiles(null, null, $file_path_xml, $file_path_pdf);
      Storage::delete($file_path_xml);
      Storage::delete($file_path_pdf);

      $stand_allocation->organization_invoice_id = $invoice->id;
      $stand_allocation->save();

      $response->status = true;
      return $response;
    } catch (Throwable $err) {
      return $err;
    }
  }

  public function getInvoiceFile(Request $request) {
    try {
      $facturapi = new Facturapi(env('FACTURAPI_KEY'));

      $file = null;
      if ($request->file_extention === 'pdf') {
        $file = $facturapi->Invoices->download_pdf($request->invoice_id);
      } else {
        $file = $facturapi->Invoices->download_xml($request->invoice_id);
      }

      $file = base64_encode($file);

      return $this->apiRsp(
        200,
        'Factura creada correctamente',
        ['file' => $file]
      );
    } catch (Throwable $err) {
      return $this->apiRsp(500, null, $err);
    }
  }
}
