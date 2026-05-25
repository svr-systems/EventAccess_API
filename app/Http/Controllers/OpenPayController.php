<?php

namespace App\Http\Controllers;

use App\Catalogs\OpenpayErrorCatalog;
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

public function payment($charge_data) {
  try {
    $openpay = Openpay::getInstance(
      env('OPENPAY_MERCHANT_ID'),
      env('OPENPAY_CUSTOMER_ID'),
      'MX',
      '127.0.0.1'
    );

    return $openpay->charges->create($charge_data);

  } catch (Throwable $e) {
    try {
      $error_code = method_exists($e, 'getErrorCode')
        ? (int) $e->getErrorCode()
        : null;

      $error = OpenpayErrorCatalog::get($error_code);

      if (!$error) {
        return $this->apiRsp(500, null, $e);
      }

      return $this->apiRsp(
        $error['http_code'],
        $error['message'],
        null
      );

    } catch (Throwable $err) {
      return $this->apiRsp(500, null, $e);
    }
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

      if (!$is_3ds) {
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

  public static function getCustomer($user, $request) {
    return array(
      'name' => $request->name,
      'last_name' => $request->last_name,
      'phone_number' => $user->phone,
      'email' => $user->email
    );
  }

  public static function getChargeData($customer, $data) {
    $charge_data = array(
      'method' => 'card',
      'source_id' => $data->token_id,
      'amount' => $data->price,
      'description' => $data->description,
      'use_card_points' => $data->use_card_points,
      'device_session_id' => $data->device_session_id,
      'customer' => $customer,
      'use_3d_secure' => false,
    );

    if (Input::toFloat(env('OPENPAY_3D_SECURE_AMOUNT'))) {
      if ($data->price > Input::toFloat(env('OPENPAY_3D_SECURE_AMOUNT'))) {
        $charge_data['use_3d_secure'] = true;
        $charge_data['redirect_url'] = env('APP_FRONT_URL') . 'proveedor/pago_exitoso';
      }
    }
    return $charge_data;
  }
}
