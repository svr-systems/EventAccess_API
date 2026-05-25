<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasActiveToggle;
use App\Models\CfdiUsage;
use App\Models\Company;
use App\Models\FiscalRegime;
use App\Models\StandAllocation;
use App\Models\StandRequest;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Event;
use App\Services\OpenpayService;
use DB;
use Illuminate\Http\Request;
use Throwable;

class StandAllocationController extends Controller {
  use HasActiveToggle;

  /**
   * ===========================================
   * CRUD
   * ===========================================
   */
  public function index(Request $request) {
    try {
      return $this->rsp(200, 'Registros retornados correctamente', [
        'items' => StandAllocation::getItems($request),
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function show(string $id, Request $request) {
    try {
      $item = StandAllocation::getItem($id, $request);

      if (is_null($item)) {
        return $this->rsp(404, 'Registro no encontrado');
      }

      return $this->rsp(200, 'Registro retornado correctamente', [
        'item' => $item,
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function store(Request $request) {
    return $this->storeUpdate(null, $request);
  }

  public function update(string $id, Request $request) {
    return $this->storeUpdate($id, $request);
  }

  public function destroy(string $id, Request $request) {
    return $this->setActive(StandAllocation::class, $id, $request, false);
  }

  public function activate(string $id, Request $request) {
    return $this->setActive(StandAllocation::class, $id, $request, true);
  }

  protected function storeUpdate(?string $id, Request $request) {
    DB::beginTransaction();

    try {
      $store_mode = is_null($id);

      $valid = StandAllocation::validData($request->all());
      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }


      if ($store_mode) {
        $item = new StandAllocation();
      } else {
        $item = StandAllocation::find((int) $id);

        if (is_null($item)) {
          DB::rollBack();
          return $this->rsp(404, 'Registro no encontrado');
        }
      }

      $payload = $request->all();
      $payload['logo_doc'] = $request->file('logo_doc');

      $item = StandAllocation::saveData($item, $payload);

      DB::commit();

      return $this->rsp(
        $store_mode ? 201 : 200,
        'Registro ' . ($store_mode ? 'agregado' : 'editado') . ' correctamente',
        $store_mode ? ['item' => ['id' => $item->id]] : null
      );
    } catch (Throwable $err) {
      DB::rollBack();
      return $this->rsp(500, null, $err);
    }
  }

  public function payment(Request $request) {
    try {
      $validator = StandAllocation::validPaymentData(
        $request->all(),
        $request->user()->id
      );

      if ($validator->fails()) {
        return $this->rsp(422, 'Datos no válidos', $validator->errors());
      }

      $stand_request = StandRequest::find($request->stand_request_id);

      if (!$stand_request) {
        return $this->rsp(404, 'Solicitud de stand no encontrada');
      }

      if (!$stand_request->is_approved) {
        return $this->rsp(422, 'La solicitud de stand aún no ha sido aprobada');
      }

      $stand_allocation = StandAllocation::getStandAllocationValid($stand_request->id);

      if (!is_null($stand_allocation)) {
        return $this->rsp(422, 'Esta solicitud de stand ya tiene un pago registrado');
      }

      $user = User::find($request->user()->id);

      if (!$user) {
        return $this->rsp(404, 'Usuario no encontrado');
      }

      $customer = OpenpayService::getCustomer($user, $request);

      $payment_data = (object) [
        'token_id' => $request->token_id,
        'price' => $stand_request->price,
        'description' => 'SR-' . $stand_request->id,
        'use_card_points' => $request->use_card_points ?? false,
        'device_session_id' => $request->device_session_id,
      ];

      $charge_data = OpenpayService::getChargeData($customer, $payment_data);

      $openpay = OpenpayService::payment($charge_data);

      if (!$openpay['success']) {
        if (
          isset($openpay['is_openpay_error']) &&
          $openpay['is_openpay_error'] &&
          isset($openpay['charge']) &&
          $openpay['charge']
        ) {
          DB::beginTransaction();

          $transaction_payload = TransactionController::getTransactionObject($openpay['charge']);

          $transaction = new Transaction;
          Transaction::saveData($transaction, $transaction_payload);

          DB::commit();
        }

        return $this->rsp(
          $openpay['http_code'],
          $openpay['message']
        );
      }

      $charge = $openpay['charge'];

      if ($charge_data['use_3d_secure']) {
        $redirect_url = $charge->payment_method->url ?? null;

        return $this->rsp(
          200,
          'Pago pendiente de autenticación',
          [
            'redirect_url' => $redirect_url,
            'stand_allocation_id' => null,
          ]
        );
      }

      DB::beginTransaction();

      $item = $this->createStandAllocationPayment($stand_request, $charge);

      DB::commit();

      return $this->rsp(
        200,
        'Pago realizado correctamente',
        [
          'redirect_url' => null,
          'stand_allocation_id' => $item->id,
        ]
      );

    } catch (Throwable $err) {
      if (DB::transactionLevel() > 0) {
        DB::rollBack();
      }

      return $this->rsp(500, null, $err);
    }
  }

  public function payment3dSecure($openpay_id) {
    try {
      $charge = OpenpayService::getCharge($openpay_id);

      if (!$charge) {
        return $this->rsp(404, 'No se encontró el cargo de Openpay');
      }

      $stand_request_id = str_replace('SR-', '', $charge->description);

      $stand_request = StandRequest::find($stand_request_id);

      if (!$stand_request) {
        return $this->rsp(404, 'Solicitud de stand no encontrada');
      }

      if (!$stand_request->is_approved) {
        return $this->rsp(422, 'La solicitud de stand aún no ha sido aprobada');
      }

      $stand_allocation = StandAllocation::getStandAllocationValid($stand_request->id);

      if (!is_null($stand_allocation)) {
        return $this->rsp(422, 'Esta solicitud de stand ya tiene un pago registrado');
      }

      DB::beginTransaction();

      $item = $this->createStandAllocationPayment($stand_request, $charge);

      DB::commit();

      return $this->rsp(
        200,
        'Pago realizado correctamente',
        [
          'redirect_url' => null,
          'stand_allocation_id' => $item->id,
        ]
      );

    } catch (Throwable $err) {
      if (DB::transactionLevel() > 0) {
        DB::rollBack();
      }

      return $this->rsp(500, null, $err);
    }
  }

  private function createStandAllocationPayment(StandRequest $stand_request, $charge): StandAllocation {
    $status = $charge->status === 'completed';

    $item = new StandAllocation;
    $item = StandAllocation::saveData(
      $item,
      $stand_request->toArray(),
      $status
    );

    $transaction_payload = TransactionController::getTransactionObject($charge);

    $transaction = new Transaction;
    $transaction = Transaction::saveData($transaction, $transaction_payload);

    $item->transaction_id = $transaction->id;
    $item->save();

    return $item;
  }

  public function stamp(Request $request) {
    try {
      $stand_allocation = StandAllocation::find($request->stand_allocation_id);

      if (is_null($stand_allocation)) {
        return $this->rsp(404, 'Registro no encontrado');
      }

      if (
        !is_null($stand_allocation->nexora_invoice_id) &&
        !is_null($stand_allocation->organization_invoice_id)
      ) {
        return $this->rsp(422, 'Estas facturas ya han sido emitidas');
      }

      $stand_request = StandRequest::find($stand_allocation->stand_request_id);

      if (is_null($stand_request)) {
        return $this->rsp(404, 'Solicitud de stand no encontrada');
      }

      $event = Event::find($stand_allocation->event_id);
      $supplier = Supplier::find($stand_allocation->supplier_id);

      if (!$supplier->fiscal_code) {
        return $this->rsp(422, 'Tu información fiscal no ha sido cargada');
      }

      $fiscal_regime = FiscalRegime::find($supplier->fiscal_regime_id);
      $cfdi_usage = CfdiUsage::find($supplier->cfdi_usage_id);

      if (is_null($event->commission_percentage)) {
        return $this->rsp(422, 'El porcentaje de comisión del evento no está configurado');
      }

      $nexora_invoice_id = $stand_allocation->nexora_invoice_id;
      $organization_invoice_id = $stand_allocation->organization_invoice_id;

      if (is_null($nexora_invoice_id)) {
        $facturapi = FacturapiController::getFacturapiInstance();

        $price = $stand_request->price * ($event->commission_percentage / 100);

        $response = $this->stampStandAllocationInvoice(
          $facturapi,
          $supplier,
          $fiscal_regime,
          $cfdi_usage,
          'COMISIÓN POR SERVICIO',
          $price
        );

        if (!$response->status) {
          return $this->rsp(422, $response->message);
        }

        $stand_allocation->nexora_invoice_id = $response->invoice_id;
        $stand_allocation->save();

        $nexora_invoice_id = $response->invoice_id;
      }

      if (is_null($organization_invoice_id)) {
        $company = Company::find($event->company_id);

        if (is_null($company)) {
          return $this->rsp(404, 'Compañía no encontrada');
        }

        $facturapi = FacturapiController::getFacturapiOrganizationInstance($company);

        $price = $stand_request->price * (1 - ($event->commission_percentage / 100));

        $response = $this->stampStandAllocationInvoice(
          $facturapi,
          $supplier,
          $fiscal_regime,
          $cfdi_usage,
          'TARIFA POR SERVICIO',
          $price
        );

        if (!$response->status) {
          return $this->rsp(422, $response->message);
        }

        $stand_allocation->organization_invoice_id = $response->invoice_id;
        $stand_allocation->save();

        $organization_invoice_id = $response->invoice_id;
      }

      return $this->rsp(
        200,
        'Se han emitido las facturas correctamente',
        [
          'nexora_invoice_id' => $nexora_invoice_id,
          'organization_invoice_id' => $organization_invoice_id,
        ]
      );

    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  private function stampStandAllocationInvoice($facturapi, $supplier, $fiscal_regime, $cfdi_usage, $description, $price) {
    $customer_valid = FacturapiController::getCustomer(
      $facturapi,
      $supplier,
      $fiscal_regime
    );

    if (!$customer_valid->status) {
      return (object) [
        'status' => false,
        'message' => $customer_valid->message,
        'invoice_id' => null,
      ];
    }

    $product = $this->getStandAllocationInvoiceProduct(
      $description,
      $price
    );

    return FacturapiController::stampInvoice(
      $facturapi,
      $product,
      $customer_valid->customer,
      $cfdi_usage
    );
  }


  private function getStandAllocationInvoiceProduct($description, $price) {
    return [
      'description' => $description,
      'product_key' => '85121600',
      'unit_key' => 'E48',
      'price' => $price,
      'tax_included' => true,
      'taxes' => [
        [
          'type' => 'IVA',
          'rate' => 0.16,
        ],
      ],
    ];
  }

  /**
   * ===========================================
   * CRUD COMPANY
   * ===========================================
   */
  public function companyIndex(Request $request) {
    try {
      return $this->rsp(200, 'Registros retornados correctamente', [
        'items' => StandAllocation::getCompanyItems($request),
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function companyShow(string $id, Request $request) {
    try {
      $item = StandAllocation::getCompanyItem($id, $request);

      if (is_null($item)) {
        return $this->rsp(404, 'Registro no encontrado');
      }

      return $this->rsp(200, 'Registro retornado correctamente', [
        'item' => $item,
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }
}
