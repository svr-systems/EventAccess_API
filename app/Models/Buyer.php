<?php

namespace App\Models;

use App\Services\StorageMgrService;
use App\Support\DisplayId;
use App\Support\Input;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Validator;

class Buyer extends Model {
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

  public function municipality(): BelongsTo {
    return $this->belongsTo(Municipality::class, 'municipality_id');
  }

  public function supplier() {
    return $this->belongsTo(Supplier::class);
  }

  public function eventArea() {
    return $this->belongsTo(EventArea::class);
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
      'name' => ['required', 'string', 'min:2', 'max:60'],

      'phone' => ['nullable', 'regex:/^\d{10}$/'],
      'website_url' => ['nullable', 'url', 'max:150'],
      'description' => ['nullable', 'string'],

      'address' => ['nullable', 'string', 'max:150'],
      'municipality_id' => ['nullable', 'exists:municipalities,id'],
      'zip' => ['nullable', 'regex:/^\d{5}$/'],

    ];

    $msgs = [
      'name.required' => 'El nombre es obligatorio.',
      'name.string' => 'El nombre debe ser un texto válido.',
      'name.min' => 'El nombre debe tener al menos 2 caracteres.',
      'name.max' => 'El nombre no puede tener más de 100 caracteres.',

      'phone.regex' => 'El teléfono debe contener exactamente 10 dígitos.',

      'website_url.url' => 'El sitio web debe ser una URL válida.',
      'website_url.max' => 'El sitio web no puede exceder 150 caracteres.',

      'description.string' => 'La descripción debe ser un texto válido.',

      'address.string' => 'La dirección debe ser un texto válido.',
      'address.max' => 'La dirección no puede exceder 150 caracteres.',

      'municipality_id.exists' => 'El municipio seleccionado no es válido.',

      'zip.regex' => 'El código postal debe contener exactamente 5 dígitos.',
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
      'buyers.*',
    ]);

    $items->where('buyers.is_active', (bool) ((int) $is_active));


    // if ($request->user()->role_id === 3 || $request->user()->role_id === 4) {
    $items->join('buyer_users', 'buyer_users.buyer_id', 'buyers.id');
    $items->where('buyer_users.user_id', $request->user()->id);
    // }

    return $items->get();
  }

  public static function getItem(Request $request = null) {
    $item = self::query();

    $buyer_user = BuyerUser::getFirstByUser($request->user()->id);

    $item->select(['buyers.*']);

    $item->with([
      'created_by:id,email',
      'updated_by:id,email',
      'municipality:id,name,state_id',
      'municipality.state:id,name',
    ]);

    $item->whereKey($buyer_user->buyer_id);

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
    $logo_doc = data_get($data, 'logo_doc');

    $item->name = Input::toUpper(data_get($data, 'name'));

    $item->phone = Input::onlyDigitsOrNull(data_get($data, 'phone'), 10);
    $item->website_url = Input::trimOrNull(data_get($data, 'website_url'));
    $item->description = Input::toText(data_get($data, 'description'));
    $item->address = Input::toText(data_get($data, 'address'));

    $item->municipality_id = Input::toId(data_get($data, 'municipality_id'));
    $item->zip = Input::onlyDigitsOrNull(data_get($data, 'zip'), 5);

    $item->logo_path = StorageMgrService::syncPath(
      $item->logo_path,
      $logo_doc instanceof UploadedFile ? $logo_doc : null,
      'Buyer'
    );

    $item->save();

    return $item;
  }

  public static function getMatchedSupplierAreas(Request $request) {
    $buyer_user = BuyerUser::getFirstByUser($request->user()->id);

    if (!$buyer_user) {
      return collect();
    }

    $buyer_id = $buyer_user->buyer_id;
    $search = trim((string) $request->search);

    $items = DB::table('supplier_event_areas')
      ->select([
        'supplier_event_areas.id',
        'supplier_event_areas.supplier_id',
        'supplier_event_areas.event_area_id',
      ])
      ->join('suppliers', 'suppliers.id', '=', 'supplier_event_areas.supplier_id')
      ->join('event_areas', 'event_areas.id', '=', 'supplier_event_areas.event_area_id')
      ->where('supplier_event_areas.is_active', true)
      ->where('suppliers.is_active', true)
      ->where('event_areas.is_active', true)
      ->whereExists(function ($query) use ($buyer_id) {
        $query->selectRaw('1')
          ->from('buyer_offer_areas')
          ->whereColumn('buyer_offer_areas.event_area_id', 'supplier_event_areas.event_area_id')
          ->where('buyer_offer_areas.buyer_id', $buyer_id)
          ->where('buyer_offer_areas.is_active', true);
      });

    if ($search !== '') {
      $items->where(function ($query) use ($search) {
        $query->where('suppliers.name', 'like', '%' . $search . '%')
          ->orWhere('suppliers.description', 'like', '%' . $search . '%')
          ->orWhere('suppliers.website_url', 'like', '%' . $search . '%')
          ->orWhere('event_areas.name', 'like', '%' . $search . '%');
      });
    }

    $rows = $items
      ->distinct()
      ->orderBy('event_areas.name')
      ->orderBy('suppliers.name')
      ->get();

    if ($rows->isEmpty()) {
      return collect();
    }

    $supplier_ids = $rows->pluck('supplier_id')->unique()->values();
    $event_area_ids = $rows->pluck('event_area_id')->unique()->values();

    $suppliers = Supplier::query()
      ->select([
        'id',
        'name',
        'logo_path',
        'phone',
        'website_url',
        'description',
      ])
      ->whereIn('id', $supplier_ids)
      ->get()
      ->keyBy('id');

    $event_areas = EventArea::query()
      ->select([
        'id',
        'event_id',
        'name',
      ])
      ->whereIn('id', $event_area_ids)
      ->get()
      ->keyBy('id');

    return $rows->map(function ($row) use ($suppliers, $event_areas) {
      $supplier = $suppliers[$row->supplier_id] ?? null;

      $supplier->appendLogoBase64();

      return [
        'id' => $row->id,
        'supplier_id' => $row->supplier_id,
        'supplier' => $supplier,
        'event_area_id' => $row->event_area_id,
        'event_area' => $event_areas[$row->event_area_id] ?? null,
      ];
    })->values();
  }
}
