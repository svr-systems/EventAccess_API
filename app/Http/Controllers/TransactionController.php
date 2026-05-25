<?php

namespace App\Http\Controllers;

use App\Models\BankType;
use Illuminate\Http\Request;

class TransactionController extends Controller {
  public static function getTransactionObject($charge) {

    $status = ($charge->status === "completed") ? true : false;
    $bank_type = BankType::getByCode($charge->card->bank_code);
    $payment_form_id = ($charge->card->type === 'debit') ? 18 : 4;
    $operation_date = date('Y-m-d H:i:s', strtotime($charge->operation_date));

    $transaction_data = new \stdClass;
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

    return $transaction_data;
  }
}
