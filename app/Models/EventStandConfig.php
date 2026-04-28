<?php

namespace App\Models;

use App\Support\DisplayId;
use App\Support\Input;
use DB;
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
    'has_electricity' => 'boolean',
    'has_water' => 'boolean',
    'has_internet' => 'boolean',
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
    return DisplayId::make('ST', $this->id, 4);
  }

  /**
   * ===========================================
   * VALIDACIONES
   * ===========================================
   */
  public static function validData(array $data) {
    $rules = [
      'event_id' => ['required', 'integer', 'exists:events,id'],

      'name' => ['required', 'string', 'min:2', 'max:60'],

      'capacity' => ['required', 'integer', 'min:0'],
      'price' => ['required', 'numeric', 'min:0', 'max:999999999.99'],

      'size_length' => ['nullable', 'numeric', 'min:0', 'max:999.99'],
      'size_width' => ['nullable', 'numeric', 'min:0', 'max:999.99'],
      'size_height' => ['nullable', 'numeric', 'min:0', 'max:999.99'],

      'has_electricity' => ['nullable', 'boolean'],
      'has_water' => ['nullable', 'boolean'],
      'has_internet' => ['nullable', 'boolean'],
    ];

    $msgs = [
      'event_id.required' => 'El evento es obligatorio',
      'event_id.exists' => 'El evento seleccionado no existe',

      'name.required' => 'El nombre del stand es obligatorio',
      'name.max' => 'El nombre del stand no puede tener más de 60 caracteres',

      'capacity.required' => 'La capacidad es obligatoria',
      'capacity.integer' => 'La capacidad debe ser un número entero',
      'capacity.min' => 'La capacidad no puede ser negativa',

      'price.required' => 'El precio es obligatorio',
      'price.numeric' => 'El precio debe ser un número válido',
      'price.min' => 'El precio no puede ser negativo',

      'size_length.numeric' => 'El largo debe ser un número válido',
      'size_width.numeric' => 'El ancho debe ser un número válido',
      'size_height.numeric' => 'El alto debe ser un número válido',
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
      'event_stand_configs.event_id',
      'event_stand_configs.name',
      'event_stand_configs.capacity',
      'event_stand_configs.price',
      'event_stand_configs.size_length',
      'event_stand_configs.size_width',
      'event_stand_configs.size_height',
      'event_stand_configs.has_electricity',
      'event_stand_configs.has_water',
      'event_stand_configs.has_internet',
    ]);


    $items->where('event_stand_configs.is_active', (bool) ((int) $is_active))->
      where('event_stand_configs.event_id', $request->event_id);

    return $items->get();
  }

  public static function getItem($id, Request $request = null) {
    $item = self::query();

    $item->select(['event_stand_configs.*']);

    $item->with([
      'created_by:id,email,name,paternal_surname,maternal_surname',
      'updated_by:id,email,name,paternal_surname,maternal_surname',
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
    $item->name = Input::toUpper(data_get($data, 'name'));
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

  /**
   * ===========================================
   * CONSULTAS SUPPLIER
   * ===========================================
   */

  public static function getSuplierItems(Request $request) {
    $offer = Offer::find($request->offer_id);

    if (!$offer) {
      return null;
    }

    $occupiedSubquery = DB::table('stand_requests')
      ->select([
        'event_stand_config_id',
        DB::raw('COUNT(*) as occupied'),
      ])
      ->where('is_active', true)
      ->where(function ($q) {
        $q->whereNull('is_approved')
          ->orWhere('is_approved', true);
      })
      ->groupBy('event_stand_config_id');

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
      DB::raw('COALESCE(sr.occupied, 0) as occupied'),
      DB::raw('(event_stand_configs.capacity - COALESCE(sr.occupied, 0)) as available'),
    ]);

    $items->join('stand_types', 'stand_types.id', '=', 'event_stand_configs.stand_type_id');

    $items->leftJoinSub($occupiedSubquery, 'sr', function ($join) {
      $join->on('sr.event_stand_config_id', '=', 'event_stand_configs.id');
    });

    $items->where('event_stand_configs.is_active', true)
      ->where('event_stand_configs.stand_type_id', $offer->stand_type_id)
      ->whereRaw('event_stand_configs.capacity > COALESCE(sr.occupied, 0)');

    return $items->get();
  }
}
