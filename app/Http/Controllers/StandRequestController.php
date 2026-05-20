<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasActiveToggle;
use App\Models\EventStandConfig;
use App\Models\StandRequest;
use App\Models\SupplierUser;
use DB;
use Illuminate\Http\Request;
use Throwable;

class StandRequestController extends Controller {
  use HasActiveToggle;

  /**
   * ===========================================
   * CRUD
   * ===========================================
   */
  public function index(Request $request) {
    try {
      return $this->rsp(200, 'Registros retornados correctamente', [
        'items' => StandRequest::getItems($request),
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function show(string $id, Request $request) {
    try {
      $item = StandRequest::getItem($id, $request);

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
    return $this->setActive(StandRequest::class, $id, $request, false);
  }

  public function activate(string $id, Request $request) {
    return $this->setActive(StandRequest::class, $id, $request, true);
  }

  protected function storeUpdate(?string $id, Request $request) {
    DB::beginTransaction();

    try {
      $store_mode = is_null($id);


      $supplier_user = SupplierUser::getFirstByUser($request->user()->id);
      $payload = $request->all();
      $payload['supplier_id'] = $supplier_user->supplier_id;

      $valid = StandRequest::validData($payload);
      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }

      if ($store_mode) {
        $item = new StandRequest();
      } else {
        $item = StandRequest::find((int) $id);

        if (is_null($item)) {
          DB::rollBack();
          return $this->rsp(404, 'Registro no encontrado');
        }
      }

      $event_stand_config = EventStandConfig::find($request->event_stand_config_id);
      $payload['price'] = $event_stand_config->price;


      // Solo validar cupo cuando se crea
      // o cuando en edición cambia la configuración del stand
      $must_validate_capacity =
        $store_mode ||
        (
          isset($payload['event_stand_config_id']) &&
          (int) $payload['event_stand_config_id'] !== (int) $item->event_stand_config_id
        );

      if ($must_validate_capacity) {
        $config = EventStandConfig::where('id', (int) $payload['event_stand_config_id'])
          ->lockForUpdate()
          ->first();

        if (is_null($config)) {
          DB::rollBack();
          return $this->rsp(404, 'Configuración de stand no encontrada');
        }

        $occupied_query = StandRequest::where('event_stand_config_id', $config->id)
          ->where('is_active', true)
          ->where(function ($q) {
            $q->whereNull('is_approved')
              ->orWhere('is_approved', true);
          });

        // Si es edición, ignorar el mismo registro
        if (!$store_mode) {
          $occupied_query->where('id', '!=', (int) $item->id);
        }

        $occupied = $occupied_query
          ->lockForUpdate()
          ->count();

        if ($occupied >= $config->capacity) {
          DB::rollBack();
          return $this->rsp(
            422,
            'Ya no hay lugares disponibles para esta configuración de stand.',
            null,
            ['event_stand_config_id' => ['Ya no hay lugares disponibles para esta configuración de stand.']]
          );
        }
      }

      $item = StandRequest::saveData($item, $payload);

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
   * CRUD COMPANY
   * ===========================================
   */
  public function companyIndex(Request $request) {
    try {
      return $this->rsp(200, 'Registros retornados correctamente', [
        'items' => StandRequest::getCompanyItems($request),
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function setApproved(?string $id, Request $request) {
    DB::beginTransaction();
    try {
      $valid = StandRequest::validDataApproved($request->all());
      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }

      $item = StandRequest::find((int) $id);

      $payload = $request->all();

      $item = StandRequest::setApproved($item, $payload);

      DB::commit();

      return $this->rsp(
        200,
        'Registro actualizado correctamente',
        null
      );
    } catch (Throwable $err) {
      DB::rollBack();
      return $this->rsp(500, null, $err);
    }
  }
}
