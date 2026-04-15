<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasActiveToggle;
use App\Models\Buyer;
use App\Models\BuyerUser;
use App\Models\MeetingRequest;
use App\Models\Supplier;
use App\Models\SupplierUser;
use App\Models\User;
use App\Services\EmailService;
use DB;
use Illuminate\Http\Request;
use Throwable;

class MeetingRequestController extends Controller {
  use HasActiveToggle;

  /**
   * ===========================================
   * CRUD
   * ===========================================
   */
  public function index(Request $request) {
    try {
      return $this->rsp(200, 'Registros retornados correctamente', [
        'items' => MeetingRequest::getItems($request),
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function show(string $id, Request $request) {
    try {
      $item = MeetingRequest::getItem($id, $request);

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
    return $this->setActive(MeetingRequest::class, $id, $request, false);
  }

  public function activate(string $id, Request $request) {
    return $this->setActive(MeetingRequest::class, $id, $request, true);
  }

  protected function storeUpdate(?string $id, Request $request) {
    DB::beginTransaction();

    try {
      $store_mode = is_null($id);

      $supplier_user = SupplierUser::getFirstByUser($request->user()->id);

      $payload = $request->all();
      $payload['supplier_user_id'] = $supplier_user?->id;
      $payload['supplier_id'] = $supplier_user?->supplier_id;

      $valid = MeetingRequest::validData($payload);
      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }


      if ($store_mode) {
        $item = new MeetingRequest();
      } else {
        $item = MeetingRequest::find((int) $id);

        if (is_null($item)) {
          DB::rollBack();
          return $this->rsp(404, 'Registro no encontrado');
        }
      }

      $item = MeetingRequest::saveData($item, $payload);

      //Envió de correo
      DB::afterCommit(function () use ($item) {
        $buyer_user = BuyerUser::find($item->buyer_user_id);
        $buyer_user = User::find($buyer_user->user_id);

        $supplier = Supplier::find($item->supplier_id);

        $supplier_user = SupplierUser::find($item->supplier_user_id);
        $supplier_user = User::find($supplier_user->user_id);
        
        EmailService::MeetingRequest(
          [$buyer_user->email],
          [
            'company_name' => $supplier->name,
            'supplier_user' => $supplier_user->full_name
          ]
        );
      });

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

  /**
   * ===========================================
   * CRUD BUYER
   * ===========================================
   */
  public function buyerIndex(Request $request) {
    try {
      return $this->rsp(200, 'Registros retornados correctamente', [
        'items' => MeetingRequest::getBuyerItems($request),
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function buyerShow(string $id, Request $request) {
    try {
      $item = MeetingRequest::getBuyerItem($id, $request);

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

  public function reject(Request $request) {
    DB::beginTransaction();

    try {
      
      $item = MeetingRequest::find($request->id);
      $item->is_approved = false;
      $item->save();

      //Envió de correo
      DB::afterCommit(function () use ($item) {
        $supplier_user = SupplierUser::find($item->supplier_user_id);
        $supplier_user = User::find($supplier_user->user_id);
        $buyer = Buyer::find($item->buyer_id);
        EmailService::MeetingRequestRejected(
          [$supplier_user->email],
          [
            'company_name' => $buyer->name
          ]
        );
      });

      DB::commit();

      return $this->rsp(
        200,
        'Registro rechazado correctamente',
        null
      );
    } catch (Throwable $err) {
      DB::rollBack();
      return $this->rsp(500, null, $err);
    }
  }
}
