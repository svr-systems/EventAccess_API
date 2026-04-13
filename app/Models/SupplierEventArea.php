<?php

namespace App\Models;

use App\Services\StorageMgrService;
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

  public function appendLogoBase64() {
    $this->logo_b64 = StorageMgrService::getBase64($this->logo_path, 'Supplier');

    return $this;
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

  /**
   * ===========================================
   * CONSULTAS BUYERS
   * ===========================================
   */
  public static function publicGetByIdForBuyer(int $id, int $buyer_id): ?array {
    $row = self::query()
      ->select([
        'supplier_event_areas.id',
        'supplier_event_areas.supplier_id',
        'supplier_event_areas.supplier_user_id',
        'supplier_event_areas.event_area_id',
      ])
      ->where('supplier_event_areas.id', $id)
      ->where('supplier_event_areas.is_active', true)
      ->whereExists(function ($query) use ($buyer_id) {
        $query->selectRaw('1')
          ->from('buyer_offer_areas')
          ->whereColumn('buyer_offer_areas.event_area_id', 'supplier_event_areas.event_area_id')
          ->where('buyer_offer_areas.buyer_id', $buyer_id)
          ->where('buyer_offer_areas.is_active', true);
      })
      ->first();

    if (!$row) {
      return null;
    }

    $supplier = Supplier::query()
      ->select([
        'id',
        'name',
        'logo_path',
        'phone',
        'website_url',
        'description',
      ])
      ->where('id', $row->supplier_id)
      ->where('is_active', true)
      ->first();

    if ($supplier) {
      $supplier->appendLogoBase64();
      $supplier->display_id = 'U-' . str_pad($supplier->id, 4, '0', STR_PAD_LEFT);
    }

    $supplier_user = SupplierUser::query()
      ->select([
        'supplier_users.id',
        'supplier_users.supplier_id',
        'supplier_users.user_id',
        'users.name',
        'users.paternal_surname',
        'users.maternal_surname',
        'users.phone',
        'users.avatar_path',
        'users.email',
      ])
      ->join('users', 'users.id', '=', 'supplier_users.user_id')
      ->where('supplier_users.id', $row->supplier_user_id)
      ->first();

    $event_area = EventArea::query()
      ->select([
        'id',
        'event_id',
        'name',
      ])
      ->where('id', $row->event_area_id)
      ->where('is_active', true)
      ->first();

    return [
      'id' => $row->id,
      'supplier_id' => $row->supplier_id,
      'supplier' => $supplier,
      'supplier_user_id' => $row->supplier_user_id,
      'supplier_user' => $supplier_user,
      'event_area_id' => $row->event_area_id,
      'event_area' => $event_area,
    ];
  }
}
