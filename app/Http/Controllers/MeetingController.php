<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasActiveToggle;
use App\Models\Buyer;
use App\Models\BuyerUser;
use App\Models\Event;
use App\Models\Meeting;
use App\Models\MeetingRequest;
use App\Models\PresentationDate;
use App\Models\Supplier;
use App\Models\SupplierUser;
use App\Models\User;
use App\Services\EmailService;
use DB;
use Illuminate\Http\Request;
use Throwable;

class MeetingController extends Controller {
  use HasActiveToggle;

  /**
   * ===========================================
   * CRUD
   * ===========================================
   */
  public function index(Request $request) {
    try {
      return $this->rsp(200, 'Registros retornados correctamente', [
        'items' => Meeting::getItems($request),
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function show(string $id, Request $request) {
    try {
      $item = Meeting::getItem($id, $request);

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
    return $this->setActive(Meeting::class, $id, $request, false);
  }

  public function activate(string $id, Request $request) {
    return $this->setActive(Meeting::class, $id, $request, true);
  }

  protected function storeUpdate(?string $id, Request $request) {
    DB::beginTransaction();

    try {
      $store_mode = is_null($id);

      $buyer_user = BuyerUser::getFirstByUser($request->user()->id);

      $payload = $request->all();
      $payload['buyer_user_id'] = $buyer_user?->id;
      $payload['buyer_id'] = $buyer_user?->buyer_id;


      $event = Event::getItem($payload['event_id'], null);
      $payload['meeting_time'] = $event->meeting_time;

      $payload['end_time'] = Meeting::calcEndTime(
        $payload['start_time'],
        $payload['meeting_time']
      );

      $valid = Meeting::validData($payload);
      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }


      if ($store_mode) {
        $item = new Meeting();
      } else {
        $item = Meeting::find((int) $id);

        if (is_null($item)) {
          DB::rollBack();
          return $this->rsp(404, 'Registro no encontrado');
        }
      }

      $event = Event::getItem($payload['event_id'], null);

      $payload['meeting_time'] = $event->meeting_time;

      $item = Meeting::saveData($item, $payload);

      if ($request->meeting_request_id) {
        $meeting_request = MeetingRequest::find($request->meeting_request_id);
        $meeting_request->is_approved = true;
        $meeting_request->meeting_id = $item->id;
        $meeting_request->save();
      }

      $item->is_meeting_request = !empty($request->meeting_request_id);

      //Envió de correo
      DB::afterCommit(function () use ($item) {
        $supplier_user = SupplierUser::find($item->supplier_user_id);
        $supplier_user = User::find($supplier_user->user_id);

        $presentation_date = PresentationDate::find($item->presentation_date_id);

        $buyer = Buyer::find($item->buyer_id);
        $buyer_user = BuyerUser::find($item->buyer_user_id);
        $buyer_user = User::find($buyer_user->user_id);

        EmailService::MeetingConfirmed(
          [$supplier_user->email],
          [
            'date' => $presentation_date->date,
            'start_time' => $item->start_time,
            'end_time' => $item->end_time,
            'company_name' => $buyer->name,
            'buyer_user' => $buyer_user->full_name,
            'is_meeting_request' => $item->is_meeting_request
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
  public function getAvailableSlots(Request $request) {
    try {
      return $this->rsp(200, 'Registros retornados correctamente', [
        'items' => Meeting::getAvailableSlots($request),
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function reject(Request $request) {
    DB::beginTransaction();

    try {

      $item = Meeting::find($request->id);
      $item->is_confirmed = false;
      $item->save();

      //Envió de correo
      DB::afterCommit(function () use ($item) {
        $supplier_user = SupplierUser::find($item->supplier_user_id);
        $supplier_user = User::find($supplier_user->user_id);
        $presentation_date = PresentationDate::find($item->presentation_date_id);
        $buyer = Buyer::find($item->buyer_id);
        EmailService::MeetingRejected(
          [$supplier_user->email],
          [
            'date' => $presentation_date->date,
            'start_time' => $item->start_time,
            'end_time' => $item->end_time,
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

  /**
   * ===========================================
   * CRUD Supplier
   * ===========================================
   */
  public function supplierIndex(Request $request) {
    try {
      return $this->rsp(200, 'Registros retornados correctamente', [
        'items' => Meeting::getSupplierItems($request),
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function supplierConfirm(Request $request) {
    DB::beginTransaction();

    try {

      $item = Meeting::find($request->id);
      $item->is_confirmed = $request->is_confirmed;
      $item->save();


      //Envió de correo
      if (!$item->is_confirmed) {
        DB::afterCommit(function () use ($item) {
          $buyer_user = BuyerUser::find($item->buyer_user_id);
          $buyer_user = User::find($buyer_user->user_id);

          $presentation_date = PresentationDate::find($item->presentation_date_id);

          $supplier = Supplier::find($item->supplier_id);

          $supplier_user = SupplierUser::find($item->supplier_user_id);
          $supplier_user = User::find($supplier_user->user_id);

          EmailService::MeetingSupplierRejected(
            [$buyer_user->email],
            [
              'date' => $presentation_date->date,
              'start_time' => $item->start_time,
              'end_time' => $item->end_time,
              'company_name' => $supplier->name,
              'supplier_user' => $supplier_user->full_name
            ]
          );
        });
      }

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
