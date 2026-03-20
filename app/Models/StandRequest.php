<?php

namespace App\Models;

use App\Models\Traits\HasAuditFields;
use App\Support\DisplayId;
use App\Support\Input;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Validator;

class StandRequest extends Model {
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
    return DisplayId::make('SR', $this->id, 4);
  }

  /**
   * ===========================================
   * VALIDACIONES
   * ===========================================
   */
  public static function validData(array $data) {
    $rules = [
      'event_id' => ['required', 'integer', 'exists:events,id'],

      'event_stand_config_id' => [
        'required',
        'integer',
        'exists:event_stand_configs,id',
        function ($attribute, $value, $fail) use ($data) {

          $exists = DB::table('event_stand_configs')
            ->join('stand_types','stand_types.id','event_stand_configs.stand_type_id')
            ->where('event_stand_configs.id', $value)
            ->where('event_id', $data['event_id'] ?? null)
            ->where('event_stand_configs.is_active', true)
            ->exists();

          if (!$exists) {
            $fail('La configuración del stand no pertenece al evento o no está activa.');
          }
        }
      ],

      'offer_id' => [
        'required',
        'integer',
        'exists:offers,id',
        function ($attribute, $value, $fail) use ($data) {

          $offer = DB::table('offers')
            ->where('id', $value)
            ->where('is_active', true)
            ->first();

          if (!$offer) {
            $fail('La oferta seleccionada no existe o no está activa.');
            return;
          }

          $valid = DB::table('stand_types')
            ->where('id', $offer->stand_type_id)
            ->where('event_id', $data['event_id'] ?? null)
            ->exists();

          if (!$valid) {
            $fail('La oferta no corresponde al evento seleccionado.');
          }
        }
      ],

      'supplier_id' => [
        'required',
        'integer',
        'exists:suppliers,id',
        function ($attribute, $value, $fail) use ($data) {

          $exists = DB::table('event_suppliers')
            ->where('supplier_id', $value)
            ->where('event_id', $data['event_id'] ?? null)
            ->where('is_active', true)
            ->exists();

          if (!$exists) {
            $fail('El proveedor no está registrado o activo en este evento.');
          }

          $offer = DB::table('offers')
            ->where('id', $data['offer_id'] ?? null)
            ->first();

          if ($offer && $offer->supplier_id != $value) {
            $fail('El proveedor no corresponde a la oferta seleccionada.');
          }
        }
      ],

      'notes' => ['nullable', 'string'],
    ];

    $msgs = [
      'event_id.required' => 'El evento es obligatorio.',
      'event_id.integer' => 'El evento debe ser un identificador válido.',
      'event_id.exists' => 'El evento seleccionado no existe.',

      'event_stand_config_id.required' => 'La configuración del stand es obligatoria.',
      'event_stand_config_id.integer' => 'La configuración del stand debe ser un identificador válido.',
      'event_stand_config_id.exists' => 'La configuración del stand no existe.',

      'offer_id.required' => 'La oferta es obligatoria.',
      'offer_id.integer' => 'La oferta debe ser un identificador válido.',
      'offer_id.exists' => 'La oferta seleccionada no existe.',

      'supplier_id.required' => 'El proveedor es obligatorio.',
      'supplier_id.integer' => 'El proveedor debe ser un identificador válido.',
      'supplier_id.exists' => 'El proveedor seleccionado no existe.',

      'notes.string' => 'Las notas deben ser un texto válido.',
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
      'stand_requests.id',
      'stand_requests.is_active',
      'stand_requests.event_id',
      'stand_requests.event_stand_config_id',
      'stand_requests.offer_id',
      'stand_requests.notes',
      'stand_requests.is_approved',
    ]);

    $items->where('stand_requests.is_active', (bool) ((int) $is_active))->
      where('stand_requests.event_id', $request->event_id)->
      where('stand_requests.supplier_id', $request->supplier_id);

    return $items->get();
  }

  public static function getItem($id, Request $request = null) {
    $item = self::query();

    $item->select(['stand_requests.*']);

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
    $item->event_stand_config_id = Input::toId(data_get($data, 'event_stand_config_id'));
    $item->offer_id = Input::toId(data_get($data, 'offer_id'));
    $item->supplier_id = Input::toId(data_get($data, 'supplier_id'));
    $item->notes = Input::toUpper(data_get($data, 'notes'));
    $item->is_approved = Input::toBool(data_get($data, 'is_approved'));

    $item->save();

    return $item;
  }
}
