<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasActiveToggle;
use App\Models\CompanyUser;
use App\Models\Event;
use App\Models\PresentationDate;
use DB;
use Illuminate\Http\Request;
use Throwable;

class EventController extends Controller {
  use HasActiveToggle;

  /**
   * ===========================================
   * CRUD
   * ===========================================
   */
  public function index(Request $request) {
    try {
      return $this->rsp(200, 'Registros retornados correctamente', [
        'items' => Event::getItems($request),
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function show(string $id, Request $request) {
    try {
      $item = Event::getItem($id, $request);

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

  public function destroy(string $id, Request $request) {
    return $this->setActive(Event::class, $id, $request, false);
  }

  public function activate(string $id, Request $request) {
    return $this->setActive(Event::class, $id, $request, true);
  }

  public function store(Request $request) {
    DB::beginTransaction();

    try {

      $valid = Event::validData($request->all());
      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }

      // $presentation_dates = json_encode($request->presentation_dates);
      // $presentation_dates_data = (array) json_decode($presentation_dates);
      $presentation_dates_data = (array) json_decode($request->presentation_dates);

      if (!is_array($presentation_dates_data) || count($presentation_dates_data) === 0) {
        DB::rollBack();
        return $this->rsp(422, 'Debes agregar al menos una fecha del evento');
      }

      foreach ($presentation_dates_data as $index => $presentation_date_data) {
        $presentation_date_data = json_decode(json_encode($presentation_date_data), true);
        $valid_date = PresentationDate::validData($presentation_date_data, false);

        if ($valid_date->fails()) {
          DB::rollBack();
          return $this->rsp(
            422,
            'Error en la fecha #' . ($index + 1) . ': ' . $valid_date->errors()->first(),
            null,
            $valid_date->errors()->toArray()
          );
        }
      }


      $item = new Event();

      $company_user = CompanyUser::getFirstByUser($request->user()->id);

      $payload = $request->all();
      $payload['company_id'] = $company_user->company_id;
      $payload['logo_doc'] = $request->file('logo_doc');
      $payload['flyer_doc'] = $request->file('flyer_doc');

      $item = Event::saveData($item, $payload);

      foreach ($presentation_dates_data as $presentation_date_data) {
        $presentation_date = new PresentationDate();

        $presentation_date_data->event_id = $item->id;

        $presentation_date = PresentationDate::saveData($presentation_date, (array) $presentation_date_data);

      }

      DB::commit();

      return $this->rsp(
        200,
        'Registro agregado correctamente',
        null
      );
    } catch (Throwable $err) {
      DB::rollBack();
      return $this->rsp(500, null, $err);
    }
  }

  public function setIamges($id, Request $request) {
    DB::beginTransaction();

    try {

      $valid = Event::validImages($request->all());

      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }

      $company_user = CompanyUser::getFirstByUser($request->user()->id);

      if (!$company_user) {
        DB::rollBack();
        return $this->rsp(403, 'El usuario no pertenece a una compañía');
      }

      $item = Event::where('id', (int) $id)
        ->where('company_id', $company_user->company_id)
        ->first();

      if (!$item) {
        DB::rollBack();
        return $this->rsp(404, 'Registro no encontrado');
      }

      $payload = [];
      $payload['logo_doc'] = $request->file('logo_doc');
      $payload['flyer_doc'] = $request->file('flyer_doc');

      $item = Event::saveImages($item, $payload);

      DB::commit();

      return $this->rsp(
        200,
        'Registro editato correctamente',
        null
      );
    } catch (Throwable $err) {
      DB::rollBack();
      return $this->rsp(500, null, $err);
    }
  }

  public function setGeneral($id, Request $request) {
    DB::beginTransaction();

    try {

      $valid = Event::validGeneral($request->all());

      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }

      $company_user = CompanyUser::getFirstByUser($request->user()->id);

      if (!$company_user) {
        DB::rollBack();
        return $this->rsp(403, 'El usuario no pertenece a una compañía');
      }

      $item = Event::where('id', (int) $id)
        ->where('company_id', $company_user->company_id)
        ->first();

      if (!$item) {
        DB::rollBack();
        return $this->rsp(404, 'Registro no encontrado');
      }

      $payload = $request->all();

      $item = Event::saveGeneral($item, $payload);

      DB::commit();

      return $this->rsp(
        200,
        'Registro editato correctamente',
        null
      );
    } catch (Throwable $err) {
      DB::rollBack();
      return $this->rsp(500, null, $err);
    }
  }

  public function setAddress($id, Request $request) {
    DB::beginTransaction();

    try {

      $valid = Event::validAddress($request->all());

      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }

      $company_user = CompanyUser::getFirstByUser($request->user()->id);

      if (!$company_user) {
        DB::rollBack();
        return $this->rsp(403, 'El usuario no pertenece a una compañía');
      }

      $item = Event::where('id', (int) $id)
        ->where('company_id', $company_user->company_id)
        ->first();

      if (!$item) {
        DB::rollBack();
        return $this->rsp(404, 'Registro no encontrado');
      }

      $payload = $request->all();

      $item = Event::saveAddress($item, $payload);

      DB::commit();

      return $this->rsp(
        200,
        'Registro editato correctamente',
        null
      );
    } catch (Throwable $err) {
      DB::rollBack();
      return $this->rsp(500, null, $err);
    }
  }

  public function standActivate(Request $request) {
    DB::beginTransaction();

    try {

      $company_user = CompanyUser::getFirstByUser($request->user()->id);

      if (!$company_user) {
        DB::rollBack();
        return $this->rsp(403, 'El usuario no pertenece a una compañía');
      }

      $item = Event::where('id', (int) $request->event_id)
        ->where('company_id', $company_user->company_id)
        ->first();

      if (!$item) {
        DB::rollBack();
        return $this->rsp(404, 'Registro no encontrado');
      }

      $item->has_stands = !$item->has_stands;
      $item->save();

      DB::commit();

      return $this->rsp(
        200,
        'Registro editato correctamente',
        ["has_stands" => $item->has_stands]
      );
    } catch (Throwable $err) {
      DB::rollBack();
      return $this->rsp(500, null, $err);
    }
  }

  public function getStandStatus(Request $request) {
    try {
      $item = Event::getStandStatus($request);

      if (is_null($item)) {
        return $this->rsp(404, 'Registro no encontrado');
      }

      return $this->rsp(200, 'Registro retornado correctamente', [
        'has_stands' => $item->has_stands,
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  /**
   * ===========================================
   * PUBLIC
   * ===========================================
   */
  public function publicIndex(Request $request) {
    try {
      return $this->rsp(200, 'Registros retornados correctamente', [
        'items' => Event::publicGetItems($request),
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }
  public function publicShow($id) {
    try {
      return $this->rsp(200, 'Registros retornados correctamente', [
        'item' => Event::getPublicItem($id),
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  /**
   * ===========================================
   * SUPPLIER
   * ===========================================
   */
  public function supplierShow($id) {
    try {
      return $this->rsp(200, 'Registros retornados correctamente', [
        'item' => Event::getSupplierItem($id),
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  /**
   * ===========================================
   * BUYER
   * ===========================================
   */
  public function buyerShow($id) {
    try {
      return $this->rsp(200, 'Registros retornados correctamente', [
        'item' => Event::getBuyerItem($id),
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }
}
