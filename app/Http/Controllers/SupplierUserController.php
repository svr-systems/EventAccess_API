<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasActiveToggle;
use App\Models\EventSupplier;
use App\Models\Supplier;
use App\Models\SupplierUser;
use App\Models\User;
use App\Services\EmailService;
use App\Support\Input;
use DB;
use Illuminate\Http\Request;
use Throwable;

class SupplierUserController extends Controller {
  use HasActiveToggle;

  /**
   * ===========================================
   * CRUD
   * ===========================================
   */
  public function index(Request $request) {
    try {
      return $this->rsp(200, 'Registros retornados correctamente', [
        'items' => SupplierUser::getItems($request),
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function show(string $id, Request $request) {
    try {
      $item = SupplierUser::getItem($id, $request);

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
    return $this->setActive(SupplierUser::class, $id, $request, false);
  }

  public function activate(string $id, Request $request) {
    return $this->setActive(SupplierUser::class, $id, $request, true);
  }

  protected function storeUpdate(?string $id, Request $request) {
    DB::beginTransaction();

    try {
      // $user = json_encode($request->user);
      // $user_data = json_decode($user);
      $user_data = json_decode($request->user);
      $user_data->role_id = 6;

      $email = Input::toLower($user_data->email);

      $valid = User::validEmail(['email' => $email], $user_data->id);
      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }

      $valid = User::validData((array) $user_data, '6');
      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }

      $store_mode = is_null($id);

      $valid = SupplierUser::validData($request->all());
      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }

      $email_current = null;

      if ($store_mode) {
        $item = new SupplierUser();

        $user = new User();
        $user->created_by_id = $request->user()->id;
        $user->updated_by_id = $request->user()->id;
      } else {
        $item = SupplierUser::find((int) $id);

        if (is_null($item)) {
          DB::rollBack();
          return $this->rsp(404, 'Registro no encontrado');
        }

        $user = User::find($item->user_id);
        $email_current = $user->email;
        $user->updated_by_id = $request->user()->id;
      }

      $payload = (array) $user_data;
      $payload['avatar_doc'] = $request->file('avatar_doc');

      $user = User::saveData($user, $payload);

      $payload = [];
      $payload['supplier_id'] = $request->supplier_id;
      $payload['user_id'] = $user->id;
      $item = SupplierUser::saveData($item, $payload);

      $must_confirm = $store_mode || (!is_null($email_current) && $email_current !== $item->email);

      if ($must_confirm) {
        $user->email_verified_at = null;
        $user->save();

        DB::afterCommit(function () use ($user) {
          EmailService::userAccountConfirmation(
            [$user->email],
            [
              'id' => $user->id,
              'full_name' => $user->full_name,
            ]
          );
        });
      }

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


  /////////////USER///////////


  public function publicStore(Request $request) {
    DB::beginTransaction();

    try {
      // $user = json_encode($request->user);
      // $user_data = json_decode($user);
      $user_data = json_decode($request->user);
      $user_data->role_id = 6;

      $email = Input::toLower($user_data->email);

      $valid = User::validEmail(['email' => $email], $user_data->id);
      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }

      $valid = User::validData((array) $user_data, '6');
      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }

      $valid = SupplierUser::validData($request->all());
      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }

      $item = new SupplierUser();

      $user = new User();
      $user->created_by_id = null;
      $user->updated_by_id = null;


      if (is_null($item)) {
        DB::rollBack();
        return $this->rsp(404, 'Registro no encontrado');
      }

      $payload = (array) $user_data;
      $payload['avatar_doc'] = $request->file('avatar_doc');

      $user = User::saveData($user, $payload);

      // $supplier = json_encode($request->supplier);
      // $supplier_data = (array) json_decode($supplier);
      $supplier_data = json_decode($request->supplier);
      $supplier_data = (array) json_decode($request->supplier);

      $supplier = new Supplier;
      $supplier->created_by_id = $user->id;
      $supplier->updated_by_id = $user->id;
      $supplier = Supplier::saveData($supplier, $supplier_data);

      $payload = [];
      $payload['supplier_id'] = $supplier->id;
      $payload['user_id'] = $user->id;
      $item = new SupplierUser;
      $item = SupplierUser::saveData($item, $payload);

      $payload = [];
      $payload['supplier_id'] = $supplier->id;
      $payload['event_id'] = $request->event_id;
      $event_supplier = new EventSupplier;
      $event_supplier->created_by_id = $user->id;
      $event_supplier->updated_by_id = $user->id;
      $event_supplier = EventSupplier::saveData($event_supplier, $payload);


      $user->email_verified_at = null;
      $user->save();

      DB::afterCommit(function () use ($user) {
        EmailService::userAccountConfirmation(
          [$user->email],
          [
            'id' => $user->id,
            'full_name' => $user->full_name,
          ]
        );
      });

      DB::commit();

      return $this->rsp(
        200,
        'Registro agregado correctamente',
        ['item' => ['id' => $item->id]]
      );
    } catch (Throwable $err) {
      DB::rollBack();
      return $this->rsp(500, null, $err);
    }
  }
}
