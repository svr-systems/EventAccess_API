<?php

namespace App\Http\Controllers;

use App\Models\AttendeeUser;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Throwable;

class AttendeeUserController extends Controller {
  public function syncAttendeeUsers() {
    DB::beginTransaction();

    try {
      $users = User::query()
        ->select([
          'users.id',
        ])
        ->where('users.role_id', 5)
        ->whereNotExists(function ($query) {
          $query->select(DB::raw(1))
            ->from('attendee_users')
            ->whereColumn('attendee_users.user_id', 'users.id');
        })
        ->get();

      foreach ($users as $user) {
        $item = new AttendeeUser();
        $item->user_id = $user->id;
        $item->save();
      }

      DB::commit();

      return $this->rsp(
        200,
        'Usuarios asistentes sincronizados correctamente',
        [
          'created' => $users->count(),
        ]
      );
    } catch (Throwable $err) {
      DB::rollBack();
      return $this->rsp(500, null, $err);
    }
  }

  public function show(Request $request) {
    try {
      $item = AttendeeUser::getItem($request);

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
    DB::beginTransaction();

    try {
      $store_mode = false;

      $valid = AttendeeUser::validData($request->all());
      if ($valid->fails()) {
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }

      $valid = FacturapiController::validCustomer($request);
      if ($valid->msg !== null) {
        return $this->apiRsp(422, $valid->msg);
      }

      $item = AttendeeUser::where('user_id', $request->user()->id)->first();

      $payload = $request->all();

      $item = AttendeeUser::saveData($item, $payload);

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
}
