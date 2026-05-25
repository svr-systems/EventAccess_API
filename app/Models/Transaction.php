<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Validator;

class Transaction extends Model {
  use HasFactory;
  protected function serializeDate(DateTimeInterface $date) {
    return Carbon::instance($date)->toISOString(true);
  }
  protected $casts = [
    'created_at' => 'datetime:Y-m-d H:i:s',
    'updated_at' => 'datetime:Y-m-d H:i:s',
  ];

  public static function valid($data) {
    $rules = [
    ];

    $msgs = [];

    return Validator::make($data, $rules, $msgs);
  }

  static public function getUiid($id) {
    return 'T-' . str_pad($id, 4, '0', STR_PAD_LEFT);
  }

  static public function getItems($req) {
    $items = Transaction::
      where('is_active', boolval($req->is_active))->
      where('consultation_id',$req->consultation_id);

    $items = $items->
      get();

    foreach ($items as $key => $item) {
      $item->key = $key;
      $item->uiid = Transaction::getUiid($item->id);
    }

    return $items;
  }

  static public function getItem($req, $id) {
    $item = Transaction::find($id);

    $item->uiid = Transaction::getUiid($item->id);

    return $item;
  }

  static public function saveData(self $item, $data) {
    $item->status = $data->status;
    $item->card_number = $data->card_number;
    $item->bank_type_id = $data->bank_type_id;
    $item->payment_form_id = $data->payment_form_id;
    $item->authorization_code = $data->authorization_code;
    $item->reading_mode = $data->reading_mode;
    $item->arqc = $data->arqc;
    $item->aid = $data->aid;
    $item->financial_reference = $data->financial_reference;
    $item->terminal_number = $data->terminal_number;
    $item->transaction_sequence = $data->transaction_sequence;
    $item->cardholder_name = $data->cardholder_name;
    $item->error_message = $data->error_message;
    $item->response_code = $data->response_code;
    $item->is_points_used = $data->is_points_used;
    $item->points_redeemed = $data->points_redeemed;
    $item->amount_redeemed = $data->amount_redeemed;
    $item->previous_balance_amount = $data->previous_balance_amount;
    $item->previous_balance_points = $data->previous_balance_points;
    $item->current_balance_amount = $data->current_balance_amount;
    $item->current_balance_points = $data->current_balance_points;
    $item->operation_date = $data->operation_date;
    $item->charge_amount = $data->charge_amount;
    $item->external_id = $data->external_id;
    $item->save();

    return $item;
  }
}
