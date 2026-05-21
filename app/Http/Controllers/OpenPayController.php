<?php

namespace App\Http\Controllers;

use App\Models\BankType;
use App\Models\StandAllocation;
use App\Models\StandRequest;
use App\Models\Transaction;
use App\Models\User;
use App\Support\Input;
use DB;
use Openpay\Data\Openpay;
use Illuminate\Http\Request;
use Throwable;

class OpenPayController extends Controller {
  public function payment(Request $request) {
    try {

      $openpay = Openpay::getInstance(
        env('OPENPAY_MERCHANT_ID'),
        env('OPENPAY_CUSTOMER_ID'),
        'MX',
        '127.0.0.1'
      );

      $user = User::find($request->user()->id);
      $stand_request = StandRequest::find($request->stand_request_id);
      $stand_allocation = StandAllocation::where('stand_request_id', $stand_request->id)->
        where('is_active', true)->
        where('is_paid', true)->
        first();
      // $event_stand_config = EventStandConfig::find($stand_request->event_stand_config->id);

      // if (true) {
      if ($stand_request->is_approved && is_null($stand_allocation)) {
        $customer = array(
          'name' => $request->name,
          'last_name' => $request->last_name,
          'phone_number' => $user->phone,
          'email' => $user->email
        );

        $chargeData = array(
          'method' => 'card',
          'source_id' => $request->token_id,
          'amount' => $stand_request->price,
          'description' => 'SR-' . $stand_request->id,
          // 'order_id' => $consultation_id,
          'use_card_points' => $request->use_card_points,
          'device_session_id' => $request->device_session_id,
          'customer' => $customer,
        );

        $use_3d_secure = false;

        if (Input::toFloat(env('OPENPAY_3D_SECURE_AMOUNT'))) {
          if ($stand_request->price > Input::toFloat(env('OPENPAY_3D_SECURE_AMOUNT'))) {
            $chargeData['use_3d_secure'] = true;
            $chargeData['redirect_url'] = env('APP_FRONT_URL') . 'proveedor/pago_exitoso';
            $use_3d_secure = true;
          }
        }

        $charge = $openpay->charges->create($chargeData);

        $redirect_url = null;

        $stand_allocation_id = null;

        if (!$use_3d_secure) {
          $stand_allocation = $this->saveOpenpayTransaction($charge->id,false);
          $stand_allocation_id = $stand_allocation->id;
        } else {
          $redirect_url = $charge->payment_method->url;
        }

        return $this->apiRsp(
          200,
          'Registros creado correctamente',
          [
            'redirect_url' => $redirect_url,
            'stand_allocation_id' => $stand_allocation_id
          ]
        );
      }

      return $this->apiRsp(
        422,
        'Este registro ya hacido aprobado y pagado'
      );

    } catch (Throwable $e) {
      $error_code = null;
      $description = null;
      try {
        $error_code = $e->getErrorCode();
        $description = $e->getMessage();
      } catch (Throwable $err) {
        return $this->apiRsp(500, null, $e);
      }
      $http_code = 500;
      $message = 'Transacción fallida. Comuniquese con su banco e ingrese sus datos correctamente e inténtelo de nuevo.';

      if ($error_code === 3004) {
        $message = 'Tarjeta declinada.';
        $http_code = 422;
      } elseif ($error_code === 3005) {
        $message = 'Tarjeta declinada.';
        $http_code = 422;
      } else {
        return $this->apiRsp(500, null, $e);
      }
      return $this->apiRsp(
        $http_code,
        $message,
        null
      );

    }
  }

  public function saveOpenpayTransaction($openpay_id, $is_3ds = true) {
    DB::beginTransaction();
    try {
      $openpay = Openpay::getInstance(
        env('OPENPAY_MERCHANT_ID'),
        env('OPENPAY_CUSTOMER_ID'),
        'MX',
        '127.0.0.1'
      );

      $charge = $openpay->charges->get($openpay_id);

      $status = ($charge->status === "completed") ? true : false;

      $stand_request = StandRequest::find(explode('SR-', $charge->description)[1]);

      $stand_allocation = new StandAllocation;
      $stand_allocation->stand_request_id = $stand_request->id;
      $stand_allocation->event_id = $stand_request->event_id;
      $stand_allocation->supplier_id = $stand_request->supplier_id;
      $stand_allocation->event_stand_config_id = $stand_request->event_stand_config_id;
      $stand_allocation->is_paid = $status;
      $stand_allocation->save();

      $bank_type = BankType::getByCode($charge->card->bank_code);
      $payment_form_id = ($charge->card->type === 'debit') ? 18 : 4;
      $operation_date = date('Y-m-d H:i:s', strtotime($charge->operation_date));

      // $transaction_data = new \stdClass;
      $transaction_data = new Transaction();
      $transaction_data->status = $status;
      $transaction_data->card_number = str_replace('X', '*', $charge->card->card_number);
      $transaction_data->bank_type_id = $bank_type->id;
      $transaction_data->payment_form_id = $payment_form_id;
      $transaction_data->authorization_code = $charge->authorization;
      $transaction_data->reading_mode = null;
      $transaction_data->arqc = null;
      $transaction_data->aid = null;
      $transaction_data->financial_reference = null;
      $transaction_data->terminal_number = null;
      $transaction_data->transaction_sequence = null;
      $transaction_data->cardholder_name = $charge->card->holder_name;
      $transaction_data->error_message = $charge->error_message;
      $transaction_data->response_code = null;
      $transaction_data->is_points_used = false;
      $transaction_data->points_redeemed = null;
      $transaction_data->amount_redeemed = null;
      $transaction_data->previous_balance_amount = null;
      $transaction_data->previous_balance_points = null;
      $transaction_data->current_balance_amount = null;
      $transaction_data->current_balance_points = null;
      $transaction_data->operation_date = $operation_date;
      $transaction_data->charge_amount = $charge->amount;
      $transaction_data->external_id = $charge->id;
      $transaction_data->save();


      $stand_allocation->transaction_id = $transaction_data->id;
      $stand_allocation->save();

      if(!$is_3ds){
        DB::commit();
        return $stand_allocation;
      }

      $transaction = new Transaction();
      // $transaction = Transaction::saveItem($transaction, $transaction_data);

      DB::commit();
      return $this->apiRsp(
        200,
        'Transacción terminada correctamente',
        [
          'status' => $status,
          'stand_allocation_id' => $stand_allocation->id
        ]
      );
    } catch (Throwable $err) {
      DB::rollback();
      return $this->apiRsp(500, null, $err);
    }
  }
}
