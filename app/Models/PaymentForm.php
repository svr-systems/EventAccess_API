<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentForm extends Model
{
  use HasFactory;
  public $timestamps = false;

  static public function getItems($req) {
    $items = PaymentForm::
      orderBy('name')->
      where('is_active', true)->
      get();

    return $items;
  }

  static public function getByCode($code) {
    $item = PaymentForm::
      where('code',$code)->
      first(['id','name']);

    if(!$item){
      $item = new \stdClass;
      $item->id = null;
      $item->name = "SIN COINSIDENCIA";
    }

    return $item;
  }
}
