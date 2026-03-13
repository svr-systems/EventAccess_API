<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Throwable;

class CatalogController extends Controller
{
  public function index(string $catalog, Request $request)
  {
    try {
      $catalog = strtolower(trim($catalog));

      $model = match ($catalog) {
        'roles' => \App\Models\Role::class,
        default => null,
      };

      if (!$model) {
        return $this->rsp(404, 'Catálogo no encontrado');
      }

      return $this->rsp(200, 'Registros retornados correctamente', [
        'items' => $model::getItems($request),
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }
  public function CompanyIndex(string $catalog, Request $request)
  {
    try {
      $catalog = strtolower(trim($catalog));

      $model = match ($catalog) {
        'roles' => \App\Models\Role::class,
        default => null,
      };

      if (!$model) {
        return $this->rsp(404, 'Catálogo no encontrado');
      }

      if($catalog === 'roles'){
          return $this->rsp(200, 'Registros retornados correctamente', [
          'items' => $model::companyGetItems($request),
        ]);
      }

      return $this->rsp(200, 'Registros retornados correctamente', [
        'items' => $model::getItems($request),
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function publicIndex(string $catalog, Request $request)
  {
    try {
      $catalog = strtolower(trim($catalog));

      $model = match ($catalog) {
        'fiscal_regimes' => \App\Models\FiscalRegime::class,
        default => null,
      };

      if (!$model) {
        return $this->rsp(404, 'Catálogo no encontrado');
      }

      return $this->rsp(200, 'Registros retornados correctamente', [
        'items' => $model::getItems($request),
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }
}