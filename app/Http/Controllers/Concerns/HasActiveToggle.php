<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

trait HasActiveToggle
{
  protected function setActive(string $model_class, string $id, Request $request, bool $is_active)
  {
    DB::beginTransaction();

    try {
      $item = $model_class::query()->find((int) $id);

      if (is_null($item)) {
        DB::rollBack();
        return $this->rsp(404, 'Registro no encontrado');
      }

      if ((bool) $item->is_active === $is_active) {
        DB::rollBack();
        return $this->rsp(
          200,
          $is_active ? 'El registro ya está activo' : 'El registro ya está inactivo'
        );
      }

      $item->is_active = $is_active;
      if($item->updated_by_id){
        $item->updated_by_id = $request->user()->id;
      }
      $item->save();

      DB::commit();

      return $this->rsp(
        200,
        $is_active ? 'Registro activado correctamente' : 'Registro inactivado correctamente'
      );
    } catch (Throwable $err) {
      DB::rollBack();
      return $this->rsp(500, null, $err);
    }
  }
}