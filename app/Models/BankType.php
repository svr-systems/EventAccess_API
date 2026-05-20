<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankType extends Model {
  use HasFactory;
  public $timestamps = false;

  static public function getItems($req) {
    $items = BankType::
      orderBy('name')->
      where('is_active', true)->
      get();

    return $items;
  }

  static public function getByCode($bank_code) {
    $item = BankType::
      where('code', 'LIKE', '%' . $bank_code)->
      first(['id','name']);

    if(!$item){
      $item = new \stdClass;
      $item->id = null;
      $item->name = "SIN COINSIDENCIA BANCARIA";
    }

    return $item;
  }
}
