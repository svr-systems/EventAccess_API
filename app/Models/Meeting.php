<?php

namespace App\Models;

use App\Models\Traits\HasAuditFields;
use App\Support\DisplayId;
use App\Support\Input;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Validator;

class Meeting extends Model {
  use HasAuditFields;

  /**
   * ===========================================
   * CONVERSIONES DE TIPO
   * ===========================================
   */
  protected $casts = [
    'is_active' => 'boolean',
    'created_at' => 'datetime:Y-m-d H:i:s',
    'updated_at' => 'datetime:Y-m-d H:i:s',
  ];

  /**
   * ===========================================
   * ACCESSORES ATRIBUTOS
   * ===========================================
   */
  protected $appends = [
    'display_id',
  ];

  public function created_by(): BelongsTo {
    return $this->belongsTo(User::class, 'created_by_id');
  }

  public function updated_by(): BelongsTo {
    return $this->belongsTo(User::class, 'updated_by_id');
  }

  /**
   * ===========================================
   * ACCESSORES
   * ===========================================
   */
  public function getDisplayIdAttribute(): string {
    return DisplayId::make('E', $this->id, 4);
  }

  /**
   * ===========================================
   * VALIDACIONES
   * ===========================================
   */
  public static function validData(array $data) {
    $rules = [
      'id' => ['nullable', 'integer'],
      'event_id' => ['required', 'integer', 'exists:events,id'],
      'presentation_date_id' => ['required', 'integer', 'exists:presentation_dates,id'],
      'event_area_id' => ['required', 'integer', 'exists:event_areas,id'],
      'supplier_id' => ['required', 'integer', 'exists:suppliers,id'],
      'supplier_user_id' => ['required', 'integer', 'exists:supplier_users,id'],
      'start_time' => ['required', 'date_format:H:i:s'],
      'is_confirmed' => ['nullable', 'boolean'],
    ];

    $msgs = [
      'id.integer' => 'El identificador debe ser válido.',

      'event_id.required' => 'El evento es obligatorio.',
      'event_id.integer' => 'El evento debe ser un identificador válido.',
      'event_id.exists' => 'El evento seleccionado no es válido.',

      'presentation_date_id.required' => 'La fecha de presentación es obligatoria.',
      'presentation_date_id.integer' => 'La fecha de presentación debe ser un identificador válido.',
      'presentation_date_id.exists' => 'La fecha de presentación seleccionada no es válida.',

      'event_area_id.required' => 'El área del evento es obligatoria.',
      'event_area_id.integer' => 'El área del evento debe ser un identificador válido.',
      'event_area_id.exists' => 'El área del evento seleccionada no es válida.',

      'supplier_id.required' => 'El proveedor es obligatorio.',
      'supplier_id.integer' => 'El proveedor debe ser un identificador válido.',
      'supplier_id.exists' => 'El proveedor seleccionado no es válido.',

      'supplier_user_id.required' => 'El usuario proveedor es obligatorio.',
      'supplier_user_id.integer' => 'El usuario proveedor debe ser un identificador válido.',
      'supplier_user_id.exists' => 'El usuario proveedor seleccionado no es válido.',

      'start_time.required' => 'La hora de inicio es obligatoria.',
      'start_time.date_format' => 'La hora de inicio debe tener formato HH:MM:SS.',

      'is_confirmed.boolean' => 'El valor de confirmación debe ser verdadero o falso.',
    ];

    $validator = Validator::make($data, $rules, $msgs);

    $validator->after(function ($validator) use ($data) {
      $id = Input::toId(data_get($data, 'id'));
      $event_id = Input::toId(data_get($data, 'event_id'));
      $presentation_date_id = Input::toId(data_get($data, 'presentation_date_id'));
      $event_area_id = Input::toId(data_get($data, 'event_area_id'));
      $supplier_id = Input::toId(data_get($data, 'supplier_id'));
      $supplier_user_id = Input::toId(data_get($data, 'supplier_user_id'));
      $start_time = Input::trimOrNull(data_get($data, 'start_time'));
      $end_time = Input::trimOrNull(data_get($data, 'end_time'));
      $buyer_id = Input::toId(data_get($data, 'buyer_id'));
      $buyer_user_id = Input::toId(data_get($data, 'buyer_user_id'));

      if (!is_null($presentation_date_id) && !is_null($event_id)) {
        $exists = \App\Models\PresentationDate::query()
          ->whereKey($presentation_date_id)
          ->where('event_id', $event_id)
          ->exists();

        if (!$exists) {
          $validator->errors()->add(
            'presentation_date_id',
            'La fecha de presentación no pertenece al evento seleccionado.'
          );
        }
      }

      if (!is_null($event_area_id) && !is_null($event_id)) {
        $exists = \App\Models\EventArea::query()
          ->whereKey($event_area_id)
          ->where('event_id', $event_id)
          ->exists();

        if (!$exists) {
          $validator->errors()->add(
            'event_area_id',
            'El área no pertenece al evento seleccionado.'
          );
        }
      }

      if (!is_null($supplier_user_id) && !is_null($supplier_id)) {
        $exists = \App\Models\SupplierUser::query()
          ->whereKey($supplier_user_id)
          ->where('supplier_id', $supplier_id)
          ->where('is_active', true)
          ->exists();

        if (!$exists) {
          $validator->errors()->add(
            'supplier_user_id',
            'El usuario proveedor no pertenece al proveedor seleccionado.'
          );
        }
      }

      if (!is_null($buyer_user_id) && !is_null($buyer_id)) {
        $exists = \App\Models\BuyerUser::query()
          ->whereKey($buyer_user_id)
          ->where('buyer_id', $buyer_id)
          ->where('is_active', true)
          ->exists();

        if (!$exists) {
          $validator->errors()->add(
            'buyer_user_id',
            'El usuario comprador no pertenece al comprador seleccionado.'
          );
        }
      }

      if (
        is_null($event_id) ||
        is_null($presentation_date_id) ||
        is_null($event_area_id) ||
        is_null($supplier_id) ||
        is_null($supplier_user_id) ||
        is_null($buyer_id) ||
        is_null($buyer_user_id) ||
        is_null($start_time) ||
        is_null($end_time)
      ) {
        return;
      }

      $buyerOverlap = self::query()
        ->where('event_id', $event_id)
        ->where('presentation_date_id', $presentation_date_id)
        ->where('buyer_user_id', $buyer_user_id)
        ->where('is_active', true)
        ->where(function ($q) use ($start_time, $end_time) {
          $q->where('start_time', '<', $end_time)
            ->where('end_time', '>', $start_time);
        });

      if (!is_null($id)) {
        $buyerOverlap->where('id', '<>', $id);
      }

      if ($buyerOverlap->exists()) {
        $validator->errors()->add(
          'start_time',
          'El comprador ya tiene una reunión en ese horario.'
        );
      }

      $supplierOverlap = self::query()
        ->where('event_id', $event_id)
        ->where('presentation_date_id', $presentation_date_id)
        ->where('supplier_user_id', $supplier_user_id)
        ->where('is_active', true)
        ->where(function ($q) use ($start_time, $end_time) {
          $q->where('start_time', '<', $end_time)
            ->where('end_time', '>', $start_time);
        });

      if (!is_null($id)) {
        $supplierOverlap->where('id', '<>', $id);
      }

      if ($supplierOverlap->exists()) {
        $validator->errors()->add(
          'start_time',
          'El proveedor ya tiene una reunión en ese horario.'
        );
      }
    });

    return $validator;
  }

  /**
   * ===========================================
   * CONSULTAS
   * ===========================================
   */
  public static function getItems(Request $request) {
    $is_active = $request->query('is_active', 1);

    $items = self::query();

    $items->select([
      'meetingd.*'
    ]);

    $items->where('meetingd.is_active', (bool) ((int) $is_active));

    return $items->get();
  }

  public static function getItem($id, Request $request = null) {
    $item = self::query();

    $item->select(['meetingd.*']);

    $item->with([
      'created_by:id,email,name,paternal_surname,maternal_surname',
      'updated_by:id,email,name,paternal_surname,maternal_surname',
      'stand_type:id,name'
    ]);

    $item->whereKey((int) $id);

    $item = $item->first();

    if (is_null($item)) {
      return null;
    }

    return $item;
  }

  /**
   * ===========================================
   * GUARDADO DE DATOS
   * ===========================================
   */
  public static function saveData(self $item, array $data): self {
    $item->event_id = Input::toId(data_get($data, 'event_id'));
    $item->presentation_date_id = Input::toId(data_get($data, 'presentation_date_id'));
    $item->event_area_id = Input::toId(data_get($data, 'event_area_id'));

    $item->buyer_id = Input::toId(data_get($data, 'buyer_id'));
    $item->buyer_user_id = Input::toId(data_get($data, 'buyer_user_id'));

    $item->supplier_id = Input::toId(data_get($data, 'supplier_id'));
    $item->supplier_user_id = Input::toId(data_get($data, 'supplier_user_id'));

    $item->start_time = Input::trimOrNull(data_get($data, 'start_time'));

    $meeting_time = Input::toInt(data_get($data, 'meeting_time'));
    $item->end_time = self::calcEndTime($item->start_time, $meeting_time);

    $item->is_confirmed = Input::toBool(data_get($data, 'is_confirmed'), true);

    $item->save();

    return $item;
  }

  private static function calcEndTime(?string $start_time, int $minutes): ?string {
    if (is_null($start_time) || $minutes <= 0) {
      return null;
    }

    return \Carbon\Carbon::createFromFormat('H:i', $start_time)
      ->addMinutes($minutes)
      ->format('H:i:s');
  }
}
