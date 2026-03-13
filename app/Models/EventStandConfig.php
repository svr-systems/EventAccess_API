<?php

namespace App\Models;

use App\Support\DisplayId;
use App\Support\Input;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Validator;

class EventStandConfig extends Model {

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
    return $this->belongsTo(StandType::class, 'id');
  }

  /**
   * ===========================================
   * ACCESSORES
   * ===========================================
   */
  public function getDisplayIdAttribute(): string {
    return DisplayId::make('ST', $this->id, 4);
  }

  /**
   * ===========================================
   * VALIDACIONES
   * ===========================================
   */
  public static function validData(array $data) {
    $rules = [
      'stand_type_id' => ['required', 'integer', 'exists:stand_types,id'],

      'capacity' => ['required', 'integer', 'min:1'],

      'reserved' => ['nullable', 'integer', 'min:0'],

      'price' => ['required', 'numeric', 'min:0'],

      'size_length' => ['nullable', 'numeric', 'min:0'],

      'size_width' => ['nullable', 'numeric', 'min:0'],

      'size_height' => ['nullable', 'numeric', 'min:0'],

      'has_electricity' => ['required', 'boolean'],
      'has_water' => ['required', 'boolean'],
      'has_internet' => ['required', 'boolean']
    ];

    $msgs = [

      'stand_type_id.required' => 'Debe seleccionar un tipo de stand.',
      'stand_type_id.integer' => 'El tipo de stand no es válido.',
      'stand_type_id.exists' => 'El tipo de stand seleccionado no existe.',

      'capacity.required' => 'Debe indicar la cantidad de stands disponibles.',
      'capacity.integer' => 'La cantidad de stands debe ser un número entero.',
      'capacity.min' => 'La cantidad de stands debe ser al menos 1.',

      'reserved.integer' => 'El número de stands reservados debe ser un número entero.',
      'reserved.min' => 'El número de stands reservados no puede ser negativo.',

      'price.required' => 'Debe indicar el precio del stand.',
      'price.numeric' => 'El precio del stand debe ser un valor numérico.',
      'price.min' => 'El precio del stand no puede ser negativo.',

      'size_length.numeric' => 'El largo del stand debe ser un valor numérico.',
      'size_length.min' => 'El largo del stand no puede ser negativo.',

      'size_width.numeric' => 'El ancho del stand debe ser un valor numérico.',
      'size_width.min' => 'El ancho del stand no puede ser negativo.',

      'size_height.numeric' => 'El alto del stand debe ser un valor numérico.',
      'size_height.min' => 'El alto del stand no puede ser negativo.',

      'has_electricity.required' => 'Debe indicar si el stand cuenta con electricidad.',
      'has_electricity.boolean' => 'El valor de electricidad no es válido.',

      'has_water.required' => 'Debe indicar si el stand cuenta con agua.',
      'has_water.boolean' => 'El valor de agua no es válido.',

      'has_internet.required' => 'Debe indicar si el stand cuenta con internet.',
      'has_internet.boolean' => 'El valor de internet no es válido.'
    ];

    return Validator::make($data, $rules, $msgs);
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
      'event_stand_configs.id',
      'event_stand_configs.is_active',
      'event_stand_configs.stand_type_id',
      'event_stand_configs.capacity',
      'event_stand_configs.price',
      'event_stand_configs.size_length',
      'event_stand_configs.size_width',
      'event_stand_configs.size_height',
      'event_stand_configs.has_electricity',
      'event_stand_configs.has_water',
      'event_stand_configs.has_internet',
    ]);

     $items->join('stand_types', 'stand_types.id', '=', 'event_stand_configs.stand_type_id');

    $items->where('event_stand_configs.is_active', (bool) ((int) $is_active))->
      where('stand_types.event_id', $request->event_id);

    return $items->get();
  }

  public static function getItem($id, Request $request = null) {
    $item = self::query();

    $item->select(['event_stand_configs.*']);

    $item->with([
      'created_by:id,email,name,paternal_surname,maternal_surname',
      'updated_by:id,email,name,paternal_surname,maternal_surname',
      'stand_type:id,name',
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
    $item->capacity = Input::toInt(data_get($data, 'capacity'));
    $item->price = Input::toFloat(data_get($data, 'price'));
    $item->size_length = Input::toFloat(data_get($data, 'size_length'));
    $item->size_width = Input::toFloat(data_get($data, 'size_width'));
    $item->size_height = Input::toFloat(data_get($data, 'size_height'));
    $item->has_electricity = Input::toBool(data_get($data, 'has_electricity'));
    $item->has_water = Input::toBool(data_get($data, 'has_water'));
    $item->has_internet = Input::toBool(data_get($data, 'has_internet'));

    $item->save();

    return $item;
  }
}
