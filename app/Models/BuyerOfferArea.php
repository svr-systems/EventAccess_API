<?php

namespace App\Models;

use App\Models\Traits\HasAuditFields;
use App\Support\DisplayId;
use App\Support\Input;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Validator;

class BuyerOfferArea extends Model {
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

  public function event_area(): BelongsTo {
    return $this->belongsTo(EventArea::class, 'event_area_id');
  }

  /**
   * ===========================================
   * ACCESSORES
   * ===========================================
   */
  public function getDisplayIdAttribute(): string {
    return DisplayId::make('U', $this->id, 4);
  }

  /**
   * ===========================================
   * VALIDACIONES
   * ===========================================
   */
  public static function validData(array $data) {
    $rules = [
      'id' => ['nullable', 'integer'],
      'event_area_id' => ['required', 'integer', 'exists:event_areas,id'],
      'description' => ['required', 'string', 'min:2'],
    ];

    $msgs = [
      'id.integer' => 'El identificador debe ser válido.',

      'event_area_id.required' => 'El área del evento es obligatoria.',
      'event_area_id.integer' => 'El área del evento debe ser un identificador válido.',
      'event_area_id.exists' => 'El área del evento seleccionada no es válida.',

      'description.required' => 'La descripción es obligatoria.',
      'description.string' => 'La descripción debe ser un texto válido.',
      'description.min' => 'La descripción debe tener al menos 2 caracteres.',
    ];

    $validator = Validator::make($data, $rules, $msgs);

    $validator->after(function ($validator) use ($data) {
      $id = Input::toId(data_get($data, 'id'));
      $buyer_id = Input::toId(data_get($data, 'buyer_id'));
      $event_area_id = Input::toId(data_get($data, 'event_area_id'));

      if (is_null($buyer_id) || is_null($event_area_id)) {
        return;
      }

      $query = self::query()
        ->where('buyer_id', $buyer_id)
        ->where('event_area_id', $event_area_id);

      if (!is_null($id)) {
        $query->where('id', '<>', $id);
      }

      if ($query->exists()) {
        $validator->errors()->add(
          'event_area_id',
          'Ya existe una oferta para este comprador en esa área del evento.'
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
      'buyer_offer_areas.id',
      'buyer_offer_areas.is_active',
      'buyer_offer_areas.buyer_id',
      'buyer_offer_areas.event_area_id',
      'buyer_offer_areas.description',
    ]);

    $items->with([
      'event_area:id,name'
    ]);

    $items->where('buyer_offer_areas.is_active', (bool) ((int) $is_active));
    
    return $items->get();
  }

  public static function getItem($id, Request $request = null) {
    $item = self::query();

    $item->select(['buyer_offer_areas.*']);

    $item->with([
      'created_by:id,email',
      'updated_by:id,email',
      'event_area:id,name'
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
    $item->buyer_id = Input::toId(data_get($data, 'buyer_id'));
    $item->event_area_id = Input::toId(data_get($data, 'event_area_id'));
    $item->description = Input::toText(data_get($data, 'description'));

    $item->save();

    return $item;
  }
}
