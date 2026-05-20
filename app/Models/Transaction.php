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
}
