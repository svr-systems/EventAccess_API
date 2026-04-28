<?php

namespace App\Models;

use App\Models\Traits\HasAuditFields;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use App\Services\StorageMgrService;
use App\Support\DisplayId;
use App\Support\Input;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\HasApiTokens;

class Event extends Model {
  use HasApiTokens, HasFactory, Notifiable, HasAuditFields;

  /**
   * ===========================================
   * CONVERSIONES DE TIPO
   * ===========================================
   */
  protected $casts = [
    'is_active' => 'boolean',
    'created_at' => 'datetime:Y-m-d H:i:s',
    'updated_at' => 'datetime:Y-m-d H:i:s',
    'sale_start_at' => 'datetime:Y-m-d',
    'sale_end_at' => 'datetime:Y-m-d',
    'is_public' => 'boolean',
    'has_stands' => 'boolean',
    'has_buyers' => 'boolean',
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

  public function company_users() {
    return $this->hasMany(CompanyUser::class);
  }

  public function company(): BelongsTo {
    return $this->belongsTo(Company::class);
  }

  public function presentation_dates(): HasMany {
    return $this->hasMany(PresentationDate::class, 'event_id');
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
      'name' => ['required', 'string', 'min:2', 'max:255'],
      'description' => ['nullable', 'string', 'min:2'],

      'place_name' => ['required', 'string', 'min:2', 'max:60'],
      'address' => ['required', 'string', 'min:2', 'max:60'],
      'municipality_id' => ['required', 'integer', 'exists:municipalities,id'],
      'address_reference' => ['required', 'string', 'min:2', 'max:150'],

      'logo_doc' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
      'flyer_doc' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],

      // 'presentation_dates' => ['required', 'json'],
    ];

    $msgs = [
      'name.required' => 'El nombre del evento es obligatorio',
      'place_name.required' => 'El nombre del lugar es obligatorio',
      'address.required' => 'La dirección es obligatoria',
      'municipality_id.required' => 'La ciudad es obligatoria',
      'municipality_id.exists' => 'La ciudad seleccionada no existe',
      'address_reference.required' => 'La referencia adicional es obligatoria',

      'logo_doc.image' => 'El logo debe ser una imagen',
      'flyer_doc.image' => 'El flyer debe ser una imagen',
    ];

    return Validator::make($data, $rules, $msgs);
  }
  public static function validImages(array $data) {
    $rules = [
      'logo_doc' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
      'flyer_doc' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
    ];

    $msgs = [
      'logo_doc.image' => 'El logo debe ser una imagen',
      'flyer_doc.image' => 'El flyer debe ser una imagen',
    ];

    $validator = Validator::make($data, $rules, $msgs);

    // Validación extra: al menos uno debe venir
    $validator->after(function ($validator) use ($data) {
      $logo = data_get($data, 'logo_doc');
      $flyer = data_get($data, 'flyer_doc');

      if (!$logo && !$flyer) {
        $validator->errors()->add('logo_doc', 'No se ha cargado ninguna imagen.');
      }
    });

    return $validator;
  }
  public static function validGeneral(array $data) {
    $rules = [
      'name' => ['required', 'string', 'min:2', 'max:255'],
      'description' => ['nullable', 'string', 'min:2'],
    ];

    $msgs = [
      'name.required' => 'El nombre del evento es obligatorio',
    ];

    return Validator::make($data, $rules, $msgs);
  }

  public static function validAddress(array $data) {
    $rules = [

      'place_name' => ['required', 'string', 'min:2', 'max:60'],
      'address' => ['required', 'string', 'min:2', 'max:60'],
      'municipality_id' => ['required', 'integer', 'exists:municipalities,id'],
      'address_reference' => ['required', 'string', 'min:2', 'max:150'],
    ];

    $msgs = [
      'place_name.required' => 'El nombre del lugar es obligatorio',
      'address.required' => 'La dirección es obligatoria',
      'municipality_id.required' => 'La ciudad es obligatoria',
      'municipality_id.exists' => 'La ciudad seleccionada no existe',
      'address_reference.required' => 'La referencia adicional es obligatoria'
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
    $company_user = CompanyUser::getFirstByUser($request->user()->id);

    $items = self::query();

    $items->select([
      'events.id',
      'events.is_active',
      'events.name',
      'events.description',
      'events.place_name',
      'events.address',
      'events.logo_path',
      'events.flyer_path',
      'events.municipality_id',
      'events.address_reference',
    ]);

    $items->where('events.is_active', (bool) ((int) $is_active))->
      where('company_id', $company_user->company_id);

    $items = $items->get();

    $items->map(function ($item) {
      $item->logo_b64 = StorageMgrService::getBase64($item->logo_path, 'Event');
      $item->logo_doc = null;

      $item->flyer_b64 = StorageMgrService::getBase64($item->flyer_path, 'Event');
      $item->flyer_doc = null;

      return $item;
    });

    return $items;
  }

  public static function getItem($id, Request $request = null) {
    $company_user = CompanyUser::getFirstByUser($request->user()->id);
    $item = self::query();

    $item->select(['events.*']);

    $item->with([
      'created_by:id,email,name,paternal_surname,maternal_surname',
      'updated_by:id,email,name,paternal_surname,maternal_surname',
      'municipality:id,name,state_id',
      'municipality.state:id,name',

      'presentation_dates' => function ($query) {
        $query->select([
          'id',
          'event_id',
          'is_active',
          'date',
          'reception_time',
          'start_time',
          'end_time',
        ])
          ->where('is_active', true)
          ->orderBy('date')
          ->orderBy('start_time');
      },
    ]);

    $item->whereKey((int) $id)->
      where('company_id', $company_user->company_id);

    $item = $item->first();

    if (is_null($item)) {
      return null;
    }

    $item->logo_b64 = StorageMgrService::getBase64($item->logo_path, 'Event');
    $item->logo_doc = null;

    $item->flyer_b64 = StorageMgrService::getBase64($item->flyer_path, 'Event');
    $item->flyer_doc = null;

    return $item;
  }

  public static function getStandStatus(Request $request = null) {
    $company_user = CompanyUser::getFirstByUser($request->user()->id);
    $item = self::query();

    $item->select(['events.has_stands']);

    $item->whereKey((int) $request->event_id)->
      where('company_id', $company_user->company_id);

    $item = $item->first();

    return $item;
  }

  /**
   * ===========================================
   * GUARDADO DE DATOS
   * ===========================================
   */
  public static function saveData(self $item, array $data): self {
    $logo_doc = data_get($data, 'logo_doc');
    $flyer_doc = data_get($data, 'flyer_doc');

    $item->company_id = Input::toId(data_get($data, 'company_id'));
    $item->name = Input::toUpper(data_get($data, 'name'));
    $item->description = Input::toUpper(data_get($data, 'description'));
    $item->place_name = Input::toUpper(data_get($data, 'place_name'));
    $item->address = Input::toUpper(data_get($data, 'address'));
    $item->municipality_id = Input::toId(data_get($data, 'municipality_id'));
    $item->address_reference = Input::toUpper(data_get($data, 'address_reference'));

    $item->logo_path = StorageMgrService::syncPath(
      $item->logo_path,
      $logo_doc instanceof UploadedFile ? $logo_doc : null,
      'Event'
    );
    $item->flyer_path = StorageMgrService::syncPath(
      $item->flyer_path,
      $flyer_doc instanceof UploadedFile ? $flyer_doc : null,
      'Event'
    );

    $item->save();

    return $item;
  }

  public static function saveImages(self $item, array $data): self {
    $logo_doc = data_get($data, 'logo_doc');
    $flyer_doc = data_get($data, 'flyer_doc');

    $item->logo_path = StorageMgrService::syncPath(
      $item->logo_path,
      $logo_doc instanceof UploadedFile ? $logo_doc : null,
      'Event'
    );

    $item->flyer_path = StorageMgrService::syncPath(
      $item->flyer_path,
      $flyer_doc instanceof UploadedFile ? $flyer_doc : null,
      'Event'
    );

    $item->save();

    return $item;
  }

  public static function saveGeneral(self $item, array $data): self {

    $item->name = Input::toUpper(data_get($data, 'name'));
    $item->description = Input::toUpper(data_get($data, 'description'));

    $item->save();

    return $item;
  }
  
  public static function saveAddress(self $item, array $data): self {

    $item->place_name = Input::toUpper(data_get($data, 'place_name'));
    $item->address = Input::toUpper(data_get($data, 'address'));
    $item->municipality_id = Input::toId(data_get($data, 'municipality_id'));
    $item->address_reference = Input::toUpper(data_get($data, 'address_reference'));

    $item->save();

    return $item;
  }

  /**
   * ===========================================
   * CONSULTAS PUBLICAS
   * ===========================================
   */
  public static function publicGetItems(Request $request) {
    $now = Carbon::now();

    $items = self::query();

    $items->select([
      'events.id',
      'events.name',
      'events.has_stands',
      'events.has_buyers',
      'events.description',
      'events.place_name',
      'events.address',
      'events.logo_path',
      'events.flyer_path',
      'events.sale_start_at',
      'events.sale_end_at',

      DB::raw('MIN(presentation_tickets.price) as price_from'),
      DB::raw('SUM(COALESCE(presentation_tickets.capacity - presentation_tickets.sold, 0)) as tickets_available'),
      DB::raw('MIN(presentation_dates.date) as next_date'),
    ]);

    $items->join('presentation_dates', 'presentation_dates.event_id', '=', 'events.id');

    $items->join(
      'presentation_tickets',
      'presentation_tickets.presentation_date_id',
      '=',
      'presentation_dates.id'
    );

    $items->where('events.is_active', true);

    $items->where('events.sale_start_at', '<=', $now);
    $items->where('events.sale_end_at', '>=', $now);

    $items->where(function ($q) {
      $q->whereNull('presentation_tickets.capacity')
        ->orWhereRaw('presentation_tickets.sold < presentation_tickets.capacity');
    });

    $items->groupBy([
      'events.id',
      'events.name',
      'events.description',
      'events.place_name',
      'events.address',
      'events.logo_path',
      'events.flyer_path',
      'events.sale_start_at',
      'events.sale_end_at'
    ]);

    $items = $items->get();

    foreach ($items as $key => $item) {

      $item->logo_b64 = StorageMgrService::getBase64($item->logo_path, 'Event');
      $item->logo_doc = null;

      $item->flyer_b64 = StorageMgrService::getBase64($item->flyer_path, 'Event');
      $item->flyer_doc = null;
    }

    return $items;
  }
  public static function getPublicItem($id, Request $request = null) {
    $item = self::query();

    $item->select([
      'events.id',
      'events.name',
      'events.has_stands',
      'events.has_buyers',
      'events.description',
      'events.place_name',
      'events.address',
      'events.logo_path',
      'events.flyer_path',
      'events.sale_start_at',
      'events.sale_end_at',

      DB::raw('MIN(presentation_tickets.price) as price_from'),
      DB::raw('SUM(COALESCE(presentation_tickets.capacity - presentation_tickets.sold, 0)) as tickets_available'),
      DB::raw('MIN(presentation_dates.date) as next_date'),
    ]);

    $item->join('presentation_dates', 'presentation_dates.event_id', '=', 'events.id');

    $item->join(
      'presentation_tickets',
      'presentation_tickets.presentation_date_id',
      '=',
      'presentation_dates.id'
    );

    $item->where('events.id', (int) $id);

    $item->where(function ($q) {
      $q->whereNull('presentation_tickets.capacity')
        ->orWhereRaw('presentation_tickets.sold < presentation_tickets.capacity');
    });

    $item->groupBy([
      'events.id',
      'events.name',
      'events.has_stands',
      'events.has_buyers',
      'events.description',
      'events.place_name',
      'events.address',
      'events.logo_path',
      'events.flyer_path',
      'events.sale_start_at',
      'events.sale_end_at',
    ]);

    $item = $item->first();

    if (is_null($item)) {
      return null;
    }

    $item->logo_b64 = StorageMgrService::getBase64($item->logo_path, 'Event');
    $item->logo_doc = null;

    $item->flyer_b64 = StorageMgrService::getBase64($item->flyer_path, 'Event');
    $item->flyer_doc = null;

    return $item;
  }
  public static function getSupplierItem($id, Request $request = null) {
    $item = self::query();

    $item->select([
      'events.id',
      'events.name',
      'events.has_stands',
      'events.has_buyers',
      'events.description',
      'events.place_name',
      'events.address',
      'events.logo_path',
      'events.flyer_path',
      'events.sale_start_at',
      'events.sale_end_at',

      DB::raw('MIN(presentation_tickets.price) as price_from'),
      DB::raw('SUM(COALESCE(presentation_tickets.capacity - presentation_tickets.sold, 0)) as tickets_available'),
      DB::raw('MIN(presentation_dates.date) as next_date'),
    ]);

    $item->join('presentation_dates', 'presentation_dates.event_id', '=', 'events.id');

    $item->join(
      'presentation_tickets',
      'presentation_tickets.presentation_date_id',
      '=',
      'presentation_dates.id'
    );

    $item->where('events.id', (int) $id);

    $item->where(function ($q) {
      $q->whereNull('presentation_tickets.capacity')
        ->orWhereRaw('presentation_tickets.sold < presentation_tickets.capacity');
    });

    $item->groupBy([
      'events.id',
      'events.name',
      'events.has_stands',
      'events.has_buyers',
      'events.description',
      'events.place_name',
      'events.address',
      'events.logo_path',
      'events.flyer_path',
      'events.sale_start_at',
      'events.sale_end_at',
    ]);

    $item = $item->first();

    if (is_null($item)) {
      return null;
    }

    $item->logo_b64 = StorageMgrService::getBase64($item->logo_path, 'Event');
    $item->logo_doc = null;

    $item->flyer_b64 = StorageMgrService::getBase64($item->flyer_path, 'Event');
    $item->flyer_doc = null;

    return $item;
  }
  public static function getBuyerItem($id, Request $request = null) {
    $item = self::query();

    $item->select([
      'events.id',
      'events.name',
      'events.has_stands',
      'events.has_buyers',
      'events.description',
      'events.place_name',
      'events.address',
      'events.logo_path',
      'events.flyer_path',
      'events.sale_start_at',
      'events.sale_end_at',

      DB::raw('MIN(presentation_tickets.price) as price_from'),
      DB::raw('SUM(COALESCE(presentation_tickets.capacity - presentation_tickets.sold, 0)) as tickets_available'),
      DB::raw('MIN(presentation_dates.date) as next_date'),
    ]);

    $item->join('presentation_dates', 'presentation_dates.event_id', '=', 'events.id');

    $item->join(
      'presentation_tickets',
      'presentation_tickets.presentation_date_id',
      '=',
      'presentation_dates.id'
    );

    $item->where('events.id', (int) $id);

    $item->where(function ($q) {
      $q->whereNull('presentation_tickets.capacity')
        ->orWhereRaw('presentation_tickets.sold < presentation_tickets.capacity');
    });

    $item->groupBy([
      'events.id',
      'events.name',
      'events.has_stands',
      'events.has_buyers',
      'events.description',
      'events.place_name',
      'events.address',
      'events.logo_path',
      'events.flyer_path',
      'events.sale_start_at',
      'events.sale_end_at',
    ]);

    $item = $item->first();

    if (is_null($item)) {
      return null;
    }

    $item->logo_b64 = StorageMgrService::getBase64($item->logo_path, 'Event');
    $item->logo_doc = null;

    $item->flyer_b64 = StorageMgrService::getBase64($item->flyer_path, 'Event');
    $item->flyer_doc = null;

    return $item;
  }
}
