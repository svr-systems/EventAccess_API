<?php

namespace App\Models;

use App\Models\Traits\HasAuditFields;
use App\Support\DisplayId;
use App\Support\Input;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Validator;

class Offer extends Model {
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

  public function stand_type(): BelongsTo {
    return $this->belongsTo(StandType::class, 'stand_type_id');
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
      'stand_type_id' => ['required', 'integer', 'exists:stand_types,id'],
      'supplier_id' => ['required', 'integer', 'exists:suppliers,id'],
      'event_id' => ['required', 'integer', 'exists:events,id'],
      'description' => ['required', 'string', 'min:2'],
    ];

    $msgs = [
      'required' => 'El campo :attribute es obligatorio.',
      'integer' => 'El campo :attribute debe ser un número entero.',
      'exists' => 'El :attribute seleccionado no existe.',
      'string' => 'El campo :attribute debe ser un texto válido.',
      'min' => 'El campo :attribute debe tener al menos :min caracteres.',
    ];

    $attributes = [
      'stand_type_id' => 'tipo de stand',
      'supplier_id' => 'proveedor',
      'event_id' => 'evento',
      'description' => 'descripción',
    ];

    return Validator::make($data, $rules, $msgs, $attributes);
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
      'offers.id',
      'offers.is_active',
      'offers.stand_type_id',
      'offers.supplier_id',
      'offers.event_id',
      'offers.description',
    ]);

    $items->where('offers.is_active', (bool) ((int) $is_active))->
      where('offers.event_id', $request->event_id)->
      where('offers.supplier_id', $request->supplier_id);

    return $items->get();
  }

  public static function getItem($id, Request $request = null) {
    $item = self::query();

    $item->select(['offers.*']);

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

    $item->stand_type_id = Input::toId(data_get($data, 'stand_type_id'));
    $item->supplier_id = Input::toId(data_get($data, 'supplier_id'));
    $item->event_id = Input::toId(data_get($data, 'event_id'));
    $item->description = Input::toUpper(data_get($data, 'description'));

    $item->save();

    return $item;
  }
}
