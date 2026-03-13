<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Role extends Model {
  /**
   * CATÁLOGO ESTÁTICO
   */
  public $timestamps = false;

  // CONSULTAS
  public static function getItems(Request $request) {
    $items = self::query();

    $items->select([
      'roles.id',
      'roles.name',
    ]);

    $items->whereIn('roles.id', [1, 2, 3]);

    $items->orderBy('roles.name');

    return $items->get();
  }

  // CONSULTAS COMPAÑIAS
  public static function companyGetItems(Request $request) {
    $items = self::query();

    $items->select([
      'roles.id',
      'roles.name',
    ]);

    $items->whereIn('roles.id', [3, 4]);

    $items->orderBy('roles.name');

    return $items->get();
  }
}
