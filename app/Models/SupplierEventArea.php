<?php

namespace App\Models;

use App\Support\DisplayId;
use App\Support\Input;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Validator;

class SupplierEventArea extends Model {
  public $timestamps = false;

  /**
   * ===========================================
   * CONVERSIONES DE TIPO
   * ===========================================
   */
  protected $casts = [
    'is_active' => 'boolean'
  ];

  /**
   * ===========================================
   * ACCESSORES ATRIBUTOS
   * ===========================================
   */
  protected $appends = [
    'display_id',
  ];

  public function event_area(): BelongsTo {
    return $this->belongsTo(EventArea::class, 'event_area_id');
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
      'supplier_id' => ['required', 'integer', 'exists:suppliers,id'],
      'event_area_id' => ['required', 'integer', 'exists:event_areas,id'],
    ];

    $msgs = [
      'id.integer' => 'El identificador debe ser válido.',

      'supplier_id.required' => 'El proveedor es obligatorio.',
      'supplier_id.integer' => 'El proveedor debe ser un identificador válido.',
      'supplier_id.exists' => 'El proveedor seleccionado no es válido.',

      'event_area_id.required' => 'El área del evento es obligatoria.',
      'event_area_id.integer' => 'El área del evento debe ser un identificador válido.',
      'event_area_id.exists' => 'El área del evento seleccionada no es válida.',
    ];

    $validator = Validator::make($data, $rules, $msgs);

    $validator->after(function ($validator) use ($data) {
      $id = Input::toId(data_get($data, 'id'));
      $supplier_id = Input::toId(data_get($data, 'supplier_id'));
      $event_area_id = Input::toId(data_get($data, 'event_area_id'));

      if (is_null($supplier_id) || is_null($event_area_id)) {
        return;
      }

      $query = self::query()
        ->where('supplier_id', $supplier_id)
        ->where('event_area_id', $event_area_id)
        ->where('is_active', true);

      if (!is_null($id)) {
        $query->where('id', '<>', $id);
      }

      if ($query->exists()) {
        $validator->errors()->add(
          'event_area_id',
          'El proveedor ya tiene asignada esta área del evento.'
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
      'supplier_event_areas.id',
      'supplier_event_areas.is_active',
      'supplier_event_areas.supplier_id',
      'supplier_event_areas.event_area_id'
    ]);

    $items->where('supplier_event_areas.is_active', (bool) ((int) $is_active))->
      where('supplier_event_areas.supplier_id', $request->supplier_id);

    return $items->get();
  }

  public static function getItem($id, Request $request = null) {
    $item = self::query();

    $item->select(['supplier_event_areas.*']);

    $item->with([
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
    $item->supplier_id = Input::toId(data_get($data, 'supplier_id'));
    $item->event_area_id = Input::toId(data_get($data, 'event_area_id'));

    $item->save();

    return $item;
  }
}
