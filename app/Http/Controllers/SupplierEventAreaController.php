<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasActiveToggle;
use App\Models\BuyerUser;
use App\Models\EventArea;
use App\Models\SupplierEventArea;
use App\Models\SupplierUser;
use DB;
use Illuminate\Http\Request;
use Throwable;

class SupplierEventAreaController extends Controller {
  use HasActiveToggle;

  /**
   * ===========================================
   * CRUD
   * ===========================================
   */
  public function index(Request $request) {
    try {
      return $this->rsp(200, 'Registros retornados correctamente', [
        'items' => SupplierEventArea::getItems($request),
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function show(string $id, Request $request) {
    try {
      $item = SupplierEventArea::getItem($id, $request);

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
    return $this->setActive(SupplierEventArea::class, $id, $request, false);
  }

  public function activate(string $id, Request $request) {
    return $this->setActive(SupplierEventArea::class, $id, $request, true);
  }

  protected function storeUpdate(?string $id, Request $request) {
    DB::beginTransaction();

    try {
      $is_active = true;
      $supplier_user = SupplierEventArea::getItemByEvenArea($request->event_area_id, $request);

      if ($supplier_user) {
        $id = $supplier_user->id;
        $is_active = !$supplier_user->is_active;
      }

      $store_mode = is_null($id);

      $event_area_id = $request->event_area_id;
      if($event_area_id === null){
        $event_area = new EventArea;
        $event_area->name = $request->event_area['name'];
        $event_area->event_id = $request->event_area['event_id'];
        $event_area->save();
        $event_area_id = $event_area->id;
      }

      $supplier_user = SupplierUser::getFirstByUser($request->user()->id);
      // $payload = $request->all();
      $payload['event_area_id'] = $event_area_id;
      $payload['supplier_id'] = $supplier_user->supplier_id;
      $payload['supplier_user_id'] = $supplier_user->id;
      $payload['is_active'] = $is_active;

      $valid = SupplierEventArea::validData($payload);
      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }

      if ($store_mode) {
        $item = new SupplierEventArea();
      } else {
        $item = SupplierEventArea::find((int) $id);

        if (is_null($item)) {
          DB::rollBack();
          return $this->rsp(404, 'Registro no encontrado');
        }
      }

      $item = SupplierEventArea::saveData($item, $payload);

      DB::commit();

      return $this->rsp(
        $store_mode ? 201 : 200,
        'Registro ' . ($store_mode ? 'agregado' : 'editado') . ' correctamente',
        ['item' => $item]
      );
    } catch (Throwable $err) {
      DB::rollBack();
      return $this->rsp(500, null, $err);
    }
  }

  /**
   * ===========================================
   * BUYERS
   * ===========================================
   */

  public function buyerShow(Request $request, $id) {
    try {
      $buyer_user = BuyerUser::getFirstByUser($request->user()->id);
      $buyer_id = $buyer_user->buyer_id;

      $item = SupplierEventArea::publicGetByIdForBuyer($id, $buyer_id);

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
}
