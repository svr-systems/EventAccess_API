<?php

namespace App\Models;

use App\Models\Traits\HasAuditFields;
use App\Services\StorageMgrService;
use App\Support\DisplayId;
use App\Support\Input;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Validator;

class EventSupplier extends Model {
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

  public function events(): BelongsTo {
    return $this->belongsTo(Event::class, 'event_id');
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
      'event_id' => ['required', 'integer', 'exists:events,id'],
      'supplier_id' => ['required', 'integer', 'exists:suppliers,id'],
    ];

    $msgs = [];

    return Validator::make($data, $rules, $msgs);
  }

  /**
   * ===========================================
   * CONSULTAS
   * ===========================================
   */
  public static function getItems(Request $request) {
    $is_active = $request->query('is_active', 1);

    $supplier_user = SupplierUser::getFirstByUser($request->user()->id);

    $items = self::query();

    $items->select([
      'event_suppliers.id',
      'event_suppliers.is_active',
      'event_suppliers.event_id',
      'event_suppliers.supplier_id',
    ]);

    $items->with([
      'created_by:id,email,name,paternal_surname,maternal_surname',
      'updated_by:id,email,name,paternal_surname,maternal_surname',
      'events:id,name,description,logo_path'
    ]);

    $items->where('event_suppliers.is_active', (bool) ((int) $is_active))->
      where('supplier_id', $supplier_user->supplier_id);

    $items = $items->get();

    foreach ($items as $item) {
      $item->events->logo_b64 = $item->events?->logo_path
        ? StorageMgrService::getBase64($item->events->logo_path, 'Event')
        : null;

      $item->events->logo_doc = null;
    }

    return $items;
  }

  public static function getItem($id, Request $request = null) {
    $item = self::query();

    $item->select(['event_suppliers.*']);

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
    $item->supplier_id = Input::toId(data_get($data, 'supplier_id'));

    $item->save();

    return $item;
  }
}
