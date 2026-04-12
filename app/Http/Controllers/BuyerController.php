<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasActiveToggle;
use App\Models\Buyer;
use DB;
use Illuminate\Http\Request;
use Throwable;

class BuyerController extends Controller {
  use HasActiveToggle;

  /**
   * ===========================================
   * CRUD
   * ===========================================
   */
  public function index(Request $request) {
    try {
      return $this->rsp(200, 'Registros retornados correctamente', [
        'items' => Buyer::getItems($request),
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function show(Request $request) {
    try {
      $item = Buyer::getItem($request);

      if (is_null($item)) {
        return $this->rsp(404, 'Registro no encontrado');
      }

      return $this->rsp(200, 'Registro retornado correctamente', [
        'item' => $item,
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function store(Request $request) {
    return $this->storeUpdate(null, $request);
  }

  public function update(string $id, Request $request) {
    return $this->storeUpdate($id, $request);
  }

  public function destroy(string $id, Request $request) {
    return $this->setActive(Buyer::class, $id, $request, false);
  }

  public function activate(string $id, Request $request) {
    return $this->setActive(Buyer::class, $id, $request, true);
  }

  protected function storeUpdate(?string $id, Request $request) {
    DB::beginTransaction();
    $buyer = Buyer::getItem($request);
    $id = $buyer->id;
    
    try {
      $store_mode = is_null($id);

      $valid = Buyer::validData($request->all());
      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }


      if ($store_mode) {
        $item = new Buyer();
        $item->created_by_id = $request->user()->id;
        $item->updated_by_id = $request->user()->id;
      } else {
        $item = Buyer::find((int) $id);

        if (is_null($item)) {
          DB::rollBack();
          return $this->rsp(404, 'Registro no encontrado');
        }

        $item->updated_by_id = $request->user()->id;
      }

      $payload = $request->all();
      $payload['logo_doc'] = $request->file('logo_doc');

      $item = Buyer::saveData($item, $payload);

      DB::commit();

      return $this->rsp(
        $store_mode ? 201 : 200,
        'Registro ' . ($store_mode ? 'agregado' : 'editado') . ' correctamente',
        $store_mode ? ['item' => ['id' => $item->id]] : null
      );
    } catch (Throwable $err) {
      DB::rollBack();
      return $this->rsp(500, null, $err);
    }
  }

  public function getMatchedSupplierAreas(Request $request) {
    try {
      return $this->rsp(200, 'Registros retornados correctamente', [
        'items' => Buyer::getMatchedSupplierAreas($request),
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }
}
