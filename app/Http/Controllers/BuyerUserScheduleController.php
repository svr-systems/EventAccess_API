<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasActiveToggle;
use App\Models\BuyerUser;
use App\Models\BuyerUserSchedule;
use DB;
use Illuminate\Http\Request;
use Throwable;

class BuyerUserScheduleController extends Controller {
  use HasActiveToggle;

  /**
   * ===========================================
   * CRUD
   * ===========================================
   */
  public function index(Request $request) {
    try {
      return $this->rsp(200, 'Registros retornados correctamente', [
        'items' => BuyerUserSchedule::getItems($request),
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function show(string $id, Request $request) {
    try {
      $item = BuyerUserSchedule::getItem($id, $request);

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
      $buyer_user = BuyerUser::getFirstByUser($request->user()->id);

      foreach ($request->buyer_user_schedules as $buyer_user_schedule) {

        $item = BuyerUserSchedule::find($buyer_user_schedule['id']);

        if(!$item){
          $item = new BuyerUserSchedule;
        }

        $buyer_user_schedule['buyer_id'] = $buyer_user->buyer_id;
        $buyer_user_schedule['buyer_user_id'] = $buyer_user->id;

        $item = BuyerUserSchedule::saveData($item, $buyer_user_schedule);
      }

      DB::commit();

      return $this->rsp(
        200,
        'Registros guardados correctamente',
        null
      );
    } catch (Throwable $err) {
      DB::rollBack();
      return $this->rsp(500, null, $err);
    }
  }
}
