<?php

namespace App\Http\Controllers;

use App\Models\AttendeeUser;
use App\Models\CfdiUsage;
use App\Models\Company;
use App\Models\FiscalRegime;
use App\Models\PresentationTicket;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Event;
use App\Services\EmailService;
use App\Services\OpenpayService;
use App\Support\Input;
use DB;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class SaleController extends Controller {

  public function payment(Request $request) {
    DB::beginTransaction();
    try {
      $item = new Sale();

      $item->user_id = Input::toId($request->user()->id);
      $item->event_id = Input::toId($request->event_id);
      $item->save();

      $amount = 0;
      $files = [];

      foreach ($request->presentation_tickets as $presentation_ticket) {
        $presentation_ticket_id = Input::toId(data_get($presentation_ticket, 'id'));


        $presentation_ticket_item = PresentationTicket::where('id', $presentation_ticket_id)
          ->lockForUpdate()
          ->first();

        if (!$presentation_ticket_item) {
          return $this->rsp(422, null, 'Tipo de boleto no encontrado');
        }

        if (!is_null($presentation_ticket_item->capacity) && $presentation_ticket_item->sold >= $presentation_ticket_item->capacity) {
          return $this->rsp(422, null, 'Boletos agotados');
        }

        for ($i = 0; $i < (int) $presentation_ticket['total']; $i++) {
          $sale_item = new SaleItem;
          $sale_item->sale_id = $item->id;
          $sale_item->presentation_ticket_id = $presentation_ticket_item->id;
          $sale_item->sale_item_status_id = 1;
          $sale_item->purchase_price = $presentation_ticket_item->price;

          $sale_item->save();

          $sale_item->ticket_code = 'TCK-' . str_pad($sale_item->id, 8, '0', STR_PAD_LEFT);
          $sale_item->save();

          $presentation_ticket_item->increment('sold');

          $amount += $presentation_ticket_item->price;
          $pdf = new PdfController;
          $pdf_name = $pdf->ticket($sale_item->id);

          // $file = [
          //   'path' => $pdf_name,
          //   'name' => $sale_item->ticket_code . '.pdf',
          //   'mime' => 'application/pdf'
          // ];

          // array_push($files, $file);
        }
      }

      $item->amount = $amount;

      $item->save();

      if (!$item->is_paid && $item->amount === "0.00") {
        DB::commit();
        return $this->rsp(
          200,
          'Compra registrada correctamente',
          ['item' => ['id' => $item->id]]
        );
      }

      $payment = $this->savePayment($item,$request);

      if(!$payment->status){
        return $this->rsp($payment->http_code, null, $payment->message);
      }



      // $user = User::find($request->user_id);

      // DB::afterCommit(function () use ($user, $files) {
      //   EmailService::tickets_purchased(
      //     [$user->email],
      //     [],
      //     $files
      //   );
      // });

      DB::commit();

      return $this->rsp(
        200,
        'Compra registrada correctamente',
        $payment->data
      );
    } catch (Throwable $err) {
      DB::rollBack();
      return $this->rsp(500, null, $err);
    }
  }

  public function savePayment($sale, Request $request) {
    $response = new \stdClass;
    $response->status = false;
    $response->http_code = 422;
    try {

      $user = User::find($request->user()->id);

      $customer = OpenpayService::getCustomer($user, $request);

      $payment_data = (object) [
        'token_id' => $request->token_id,
        'price' => $sale->amount,
        'description' => 'TS-' . $sale->id,
        'use_card_points' => $request->use_card_points ?? false,
        'device_session_id' => $request->device_session_id,
      ];

      $charge_data = OpenpayService::getChargeData($customer, $payment_data, 'boletos');

      $openpay = OpenpayService::payment($charge_data);

      if (!$openpay['success']) {
        if (
          isset($openpay['is_openpay_error']) &&
          $openpay['is_openpay_error'] &&
          isset($openpay['charge']) &&
          $openpay['charge']
        ) {

          $transaction_payload = TransactionController::getTransactionObject($openpay['charge']);

          $transaction = new Transaction();
          Transaction::saveData($transaction, $transaction_payload);
        }

        $response->http_code = $openpay['http_code'];
        $response->message = $openpay['message'];

        return $response;
      }

      $charge = $openpay['charge'];

      if ($charge_data['use_3d_secure']) {
        $redirect_url = $charge->payment_method->url ?? null;

        $response->status = true;

        $response->data = [
          'redirect_url' => $redirect_url,
          'sale_id' => null,
        ];
      }

      $sale = $this->createTransaction($sale, $charge);

      $response->status = true;

      $response->data = [
        'redirect_url' => null,
        'sale_id' => $sale->id,
      ];

      return $response;

    } catch (Throwable $err) {
      $response->message = $err;
      return $response;
    }
  }

  public function payment3dSecure($openpay_id) {
    try {
      $charge = OpenpayService::getCharge($openpay_id);

      if (!$charge) {
        return $this->rsp(404, 'No se encontró el cargo de Openpay');
      }

      $sale_id = str_replace('TS-', '', $charge->description);

      $sale = Sale::find($sale_id);

      if (!$sale) {
        return $this->rsp(404, 'Venta no encontrada');
      }

      if ($sale->is_paid) {
        return $this->rsp(422, 'La venta ya fue realizada');
      }

      DB::beginTransaction();

      $item = $this->createTransaction($sale, $charge);

      DB::commit();

      return $this->rsp(
        200,
        'Pago realizado correctamente',
        [
          'redirect_url' => null,
          'sale_id' => $item->id,
        ]
      );

    } catch (Throwable $err) {
      if (DB::transactionLevel() > 0) {
        DB::rollBack();
      }

      return $this->rsp(500, null, $err);
    }
  }


  private function createTransaction($sale, $charge) {
    $status = $charge->status === 'completed';

    $sale->is_paid = $status;

    $transaction_payload = TransactionController::getTransactionObject($charge);

    $transaction = new Transaction;
    $transaction = Transaction::saveData($transaction, $transaction_payload);

    $sale->transaction_id = $transaction->id;
    $sale->save();

    return $sale;
  }

  public function stamp(Request $request) {
    try {
      $sale = Sale::find($request->sale_id);

      if (is_null($sale)) {
        return $this->rsp(404, 'Registro no encontrado');
      }

      if (
        !is_null($sale->nexora_invoice_id) &&
        !is_null($sale->organization_invoice_id)
      ) {
        return $this->rsp(422, 'Estas facturas ya han sido emitidas');
      }

      $event = Event::find($sale->event_id);
      $attendee = AttendeeUser::where('user_id', $request->user()->id)->first();

      if (!$attendee->fiscal_code) {
        return $this->rsp(422, 'Tu información fiscal no ha sido cargada');
      }

      $fiscal_regime = FiscalRegime::find($attendee->fiscal_regime_id);
      $cfdi_usage = CfdiUsage::find($attendee->cfdi_usage_id);

      if (is_null($event->commission_percentage)) {
        return $this->rsp(422, 'El porcentaje de comisión del evento no está configurado');
      }

      $nexora_invoice_id = $sale->nexora_invoice_id;
      $organization_invoice_id = $sale->organization_invoice_id;

      if (is_null($nexora_invoice_id)) {
        $facturapi = FacturapiController::getFacturapiInstance();

        $price = $sale->amount * ($event->commission_percentage / 100);

        $response = $this->stampStandAllocationInvoice(
          $facturapi,
          $attendee,
          $fiscal_regime,
          $cfdi_usage,
          'COMISIÓN POR SERVICIO',
          $price
        );

        if (!$response->status) {
          return $this->rsp(422, $response->message);
        }

        $sale->nexora_invoice_id = $response->invoice_id;
        $sale->save();

        $nexora_invoice_id = $response->invoice_id;
      }

      if (is_null($organization_invoice_id)) {
        $company = Company::find($event->company_id);

        if (is_null($company)) {
          return $this->rsp(404, 'Compañía no encontrada');
        }

        $facturapi = FacturapiController::getFacturapiOrganizationInstance($company);

        $price = $sale->amount * (1 - ($event->commission_percentage / 100));

        $response = $this->stampStandAllocationInvoice(
          $facturapi,
          $attendee,
          $fiscal_regime,
          $cfdi_usage,
          'TARIFA POR SERVICIO',
          $price
        );

        if (!$response->status) {
          return $this->rsp(422, $response->message);
        }

        $sale->organization_invoice_id = $response->invoice_id;
        $sale->save();

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

  private function stampStandAllocationInvoice($facturapi, $attendee, $fiscal_regime, $cfdi_usage, $description, $price) {
    $customer_valid = FacturapiController::getCustomer(
      $facturapi,
      $attendee,
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
}
