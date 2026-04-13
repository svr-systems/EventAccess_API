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
    $item->buyer_user_id = Input::toId(data_get($data, 'buyer_user_id'));
    $item->event_area_id = Input::toId(data_get($data, 'event_area_id'));
    $item->description = Input::toText(data_get($data, 'description'));

    $item->save();

    return $item;
  }

  public static function getShowItem(int $id, Request $request): ?array {
    $supplier_user = SupplierUser::getFirstByUser($request->user()->id);

    if (!$supplier_user) {
      return null;
    }

    $supplier_id = $supplier_user->supplier_id;
    $supplier_user_id = $supplier_user->id;

    $row = DB::table('buyer_offer_areas')
      ->select([
        'buyer_offer_areas.id',
        'buyer_offer_areas.buyer_id',
        'buyer_offer_areas.buyer_user_id',
        'buyer_offer_areas.event_area_id',
        'buyer_offer_areas.description',
      ])
      ->where('buyer_offer_areas.id', $id)
      ->where('buyer_offer_areas.is_active', true)
      ->whereExists(function ($query) use ($supplier_id, $supplier_user_id) {
        $query->selectRaw('1')
          ->from('supplier_event_areas')
          ->whereColumn('supplier_event_areas.event_area_id', 'buyer_offer_areas.event_area_id')
          ->where('supplier_event_areas.supplier_id', $supplier_id)
          ->where('supplier_event_areas.supplier_user_id', $supplier_user_id)
          ->where('supplier_event_areas.is_active', true);
      })
      ->first();

    if (!$row) {
      return null;
    }

    $buyer = Buyer::query()
      ->select([
        'id',
        'name',
        'logo_path',
      ])
      ->where('id', $row->buyer_id)
      ->where('is_active', true)
      ->first();

    if ($buyer) {
      $buyer->appendLogoBase64();
    }

    $buyer_user = BuyerUser::query()
      ->select([
        'buyer_users.id',
        'buyer_users.buyer_id',
        'buyer_users.user_id',
        'users.name',
        'users.paternal_surname',
        'users.maternal_surname',
        'users.email',
        'users.phone',
        'users.avatar_path',
      ])
      ->join('users', 'users.id', '=', 'buyer_users.user_id')
      ->where('buyer_users.id', $row->buyer_user_id)
      ->first();

    $buyer_offer_area = BuyerOfferArea::query()
      ->select([
        'id',
        'buyer_id',
        'buyer_user_id',
        'event_area_id',
        'description',
      ])
      ->where('id', $row->id)
      ->where('is_active', true)
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
      'buyer_id' => $row->buyer_id,
      'buyer' => $buyer,
      'buyer_user_id' => $row->buyer_user_id,
      'buyer_user' => $buyer_user,
      'buyer_offer_area_id' => $row->id,
      'buyer_offer_area' => $buyer_offer_area,
      'event_area_id' => $row->event_area_id,
      'event_area' => $event_area,
    ];
  }
}
