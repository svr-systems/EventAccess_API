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

class EventArea extends Model {
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

  public function event() {
    return $this->belongsTo(Event::class);
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
      'event_id' => ['required', 'integer', 'exists:events,id'],
      'name' => ['required', 'string', 'min:2', 'max:100'],
    ];

    $msgs = [
      'event_id.required' => 'El evento es obligatorio.',
      'event_id.integer' => 'El evento debe ser un identificador válido.',
      'event_id.exists' => 'El evento seleccionado no es válido.',

      'name.required' => 'El área es obligatoria.',
      'name.string' => 'El área debe ser un texto válido.',
      'name.min' => 'El área debe tener al menos 2 caracteres.',
      'name.max' => 'El área no puede tener más de 100 caracteres.',
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
      'event_areas.id',
      'event_areas.event_id',
      'event_areas.name'
    ]);

    $items->where('event_areas.is_active', (bool) ((int) $is_active));
    $items->where('event_areas.event_id', $request->event_id);

    return $items->get();
  }

  public static function getItem($id, Request $request = null) {
    $item = self::query();

    $item->select(['event_areas.*']);

    $item->with([
      'created_by:id,email',
      'updated_by:id,email',
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

    $item->save();

    return $item;
  }
  /**
   * ===========================================
   * CONSULTAS SUPPLIER
   * ===========================================
   */
  public static function getSupplierItems(Request $request) {
    $supplier_user = SupplierUser::getFirstByUser($request->user()->id);

    if (!$supplier_user) {
      return collect();
    }

    $items = self::query();

    $items->select([
      'event_areas.id',
      'event_areas.is_active',
      'event_areas.event_id',
      'event_areas.name',
      DB::raw('CASE WHEN supplier_event_areas.id IS NULL THEN false ELSE true END as is_checked'),
    ]);

    $items->leftJoin('supplier_event_areas', function ($join) use ($supplier_user) {
      $join->on('supplier_event_areas.event_area_id', '=', 'event_areas.id')
        ->where('supplier_event_areas.supplier_id', '=', $supplier_user->supplier_id)
        ->where('supplier_event_areas.supplier_user_id', '=', $supplier_user->id)
        ->where('supplier_event_areas.is_active', '=', true);
    });

    $items->where('event_areas.is_active', true)
      ->where('event_areas.event_id', (int) $request->event_id);

    $items->distinct()
      ->orderBy('event_areas.name');

    return $items->get();
  }
  /**
   * ===========================================
   * CONSULTAS BUYER
   * ===========================================
   */
  public static function getBuyerItems(Request $request) {

    $items = self::query();

    $items->select([
      'event_areas.id',
      'event_areas.event_id',
      'event_areas.name'
    ]);

    $items->where('event_areas.is_active', 1);
    $items->where('event_areas.event_id', $request->event_id);

    return $items->get();
  }
}
