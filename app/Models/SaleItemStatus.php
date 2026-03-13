<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SaleItemStatus extends Model
{
  /**
   * CATÁLOGO ESTÁTICO
   */
  public $timestamps = false;

  // CONSULTAS
  public static function getItems(Request $request) {
    $items = self::query();

    $items->select([
      'sale_item_statuses.id',
      'sale_item_statuses.name',
    ]);

    $items->orderBy('sale_item_statuses.name');

    return $items->get();
  }
}
