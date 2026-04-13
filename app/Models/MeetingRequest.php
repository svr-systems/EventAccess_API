<?php

namespace App\Models;

use App\Models\Traits\HasAuditFields;
use App\Support\DisplayId;
use App\Support\Input;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Validator;

class MeetingRequest extends Model {
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

  public function supplier_user(): BelongsTo {
    return $this->belongsTo(SupplierUser::class, 'supplier_user_id');
  }

  public function supplier(): BelongsTo {
    return $this->belongsTo(Supplier::class, 'supplier_id');
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
      'buyer_id' => ['required', 'integer', 'exists:buyers,id'],
      'buyer_user_id' => ['required', 'integer', 'exists:buyer_users,id'],
      'supplier_id' => ['required', 'integer', 'exists:suppliers,id'],
      'supplier_user_id' => ['required', 'integer', 'exists:supplier_users,id'],
      'meeting_id' => ['nullable', 'integer', 'exists:meetings,id'],
      'is_approved' => ['nullable', 'boolean'],
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

      'buyer_id.required' => 'El comprador es obligatorio.',
      'buyer_id.integer' => 'El comprador debe ser un identificador válido.',
      'buyer_id.exists' => 'El comprador seleccionado no es válido.',

      'buyer_user_id.required' => 'El usuario comprador es obligatorio.',
      'buyer_user_id.integer' => 'El usuario comprador debe ser un identificador válido.',
      'buyer_user_id.exists' => 'El usuario comprador seleccionado no es válido.',

      'supplier_id.required' => 'El proveedor es obligatorio.',
      'supplier_id.integer' => 'El proveedor debe ser un identificador válido.',
      'supplier_id.exists' => 'El proveedor seleccionado no es válido.',

      'supplier_user_id.required' => 'El usuario proveedor es obligatorio.',
      'supplier_user_id.integer' => 'El usuario proveedor debe ser un identificador válido.',
      'supplier_user_id.exists' => 'El usuario proveedor seleccionado no es válido.',

      'meeting_id.integer' => 'La reunión debe ser un identificador válido.',
      'meeting_id.exists' => 'La reunión seleccionada no es válida.',

      'is_approved.boolean' => 'La aprobación debe ser verdadero o falso.',
    ];

    $validator = Validator::make($data, $rules, $msgs);

    $validator->after(function ($validator) use ($data) {
      $id = Input::toId(data_get($data, 'id'));
      $event_id = Input::toId(data_get($data, 'event_id'));
      $presentation_date_id = Input::toId(data_get($data, 'presentation_date_id'));
      $event_area_id = Input::toId(data_get($data, 'event_area_id'));
      $buyer_id = Input::toId(data_get($data, 'buyer_id'));
      $buyer_user_id = Input::toId(data_get($data, 'buyer_user_id'));
      $supplier_id = Input::toId(data_get($data, 'supplier_id'));
      $supplier_user_id = Input::toId(data_get($data, 'supplier_user_id'));

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
            'El área del evento no pertenece al evento seleccionado.'
          );
        }
      }

      if (
        is_null($event_id) ||
        is_null($presentation_date_id) ||
        is_null($event_area_id) ||
        is_null($buyer_id) ||
        is_null($supplier_id)
      ) {
        return;
      }

      $query = self::query()
        ->where('event_id', $event_id)
        ->where('presentation_date_id', $presentation_date_id)
        ->where('event_area_id', $event_area_id)
        ->where('buyer_id', $buyer_id)
        ->where('supplier_id', $supplier_id)
        ->where('is_active', true);

      if (!is_null($id)) {
        $query->where('id', '<>', $id);
      }

      if ($query->exists()) {
        $validator->errors()->add(
          'supplier_id',
          'Ya existe una petición activa para este proveedor en ese evento, fecha y área.'
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
      'meeting_requests.id',
      'meeting_requests.is_active',
      'meeting_requests.stand_type_id',
      'meeting_requests.supplier_id',
      'meeting_requests.event_id',
      'meeting_requests.description',
    ]);

    $items->where('meeting_requests.is_active', (bool) ((int) $is_active))->
      where('meeting_requests.event_id', $request->event_id)->
      where('meeting_requests.supplier_id', $request->supplier_id);

    return $items->get();
  }

  public static function getItem($id, Request $request = null) {
    $item = self::query();

    $item->select(['meeting_requests.*']);

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
    $item->presentation_date_id = Input::toId(data_get($data, 'presentation_date_id'));
    $item->event_area_id = Input::toId(data_get($data, 'event_area_id'));

    $item->buyer_id = Input::toId(data_get($data, 'buyer_id'));
    $item->buyer_user_id = Input::toId(data_get($data, 'buyer_user_id'));

    $item->supplier_id = Input::toId(data_get($data, 'supplier_id'));
    $item->supplier_user_id = Input::toId(data_get($data, 'supplier_user_id'));

    $item->meeting_id = Input::toId(data_get($data, 'meeting_id'));

    $item->save();

    return $item;
  }

  /**
   * ===========================================
   * CONSULTAS
   * ===========================================
   */
  public static function getBuyerItems(Request $request) {
    $is_active = $request->query('is_active', 1);
    $buyer_user = BuyerUser::getFirstByUser($request->user()->id);

    if (!$buyer_user) {
      return collect();
    }

    $items = self::query();

    $items->select([
      'meeting_requests.id',
      'meeting_requests.is_active',
      'meeting_requests.event_id',
      'meeting_requests.presentation_date_id',
      'meeting_requests.event_area_id',
      'meeting_requests.buyer_id',
      'meeting_requests.buyer_user_id',
      'meeting_requests.supplier_id',
      'meeting_requests.supplier_user_id',
      'meeting_requests.meeting_id',
      'meeting_requests.is_approved',
      'meeting_requests.created_at',
    ]);

    $items->with([
      'supplier:id,name',
      'supplier_user:id,user_id',
      'supplier_user.user:id,name,paternal_surname,maternal_surname',
    ]);

    $items->where('meeting_requests.is_active', (bool) ((int) $is_active))
      ->where('meeting_requests.event_id', (int) $request->event_id)
      ->where('meeting_requests.buyer_id', $buyer_user->buyer_id)
      ->where('meeting_requests.buyer_user_id', $buyer_user->id)
      ->whereNull('meeting_requests.is_approved')
      ->orderByDesc('meeting_requests.id');

    return $items->get();
  }
}
