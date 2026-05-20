<?php

namespace App\Models;

use App\Services\MeetingAvailabilityService;
use Illuminate\Http\UploadedFile;
use App\Services\StorageMgrService;
use App\Support\DisplayId;
use App\Support\Input;
use Carbon\Carbon;
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
  
  public function buyer_users() {
  return $this->hasMany(BuyerUser::class);
}

  /**
   * ===========================================
   * ACCESSORES
   * ===========================================
   */
  public function getDisplayIdAttribute(): string {
    return DisplayId::make('U', $this->id, 4);
  }
  public function appendLogoBase64() {
    $this->logo_b64 = StorageMgrService::getBase64($this->logo_path, 'Buyer');

    return $this;
  }

  public function setMunicipality() {
    $this->municipality = Municipality::find($this->municipality_id, ['name', 'state_id']);
    $this->municipality->state = State::find($this->municipality->state_id, ['name'])->name;

    return $this;
  }

  private static function buyerHasAvailableHours(
    int $event_id,
    int $buyer_id,
    int $buyer_user_id
  ): bool {
    $event = Event::query()
      ->select(['id', 'meeting_time'])
      ->where('id', $event_id)
      ->where('is_active', true)
      ->first();

    if (!$event || !$event->meeting_time || $event->meeting_time <= 0) {
      return false;
    }

    $meeting_minutes = (int) $event->meeting_time;

    $schedules = BuyerUserSchedule::query()
      ->select([
        'presentation_date_id',
        'start_time',
        'end_time',
      ])
      ->where('is_active', true)
      ->where('event_id', $event_id)
      ->where('buyer_id', $buyer_id)
      ->where('buyer_user_id', $buyer_user_id)
      ->orderBy('presentation_date_id')
      ->orderBy('start_time')
      ->get();

    if ($schedules->isEmpty()) {
      return false;
    }

    $presentation_date_ids = $schedules->pluck('presentation_date_id')->unique()->values();

    $busy_meetings = Meeting::query()
      ->select([
        'presentation_date_id',
        'start_time',
        'end_time',
      ])
      ->where('is_active', true)
      ->whereIn('presentation_date_id', $presentation_date_ids)
      ->where('buyer_id', $buyer_id)
      ->where('buyer_user_id', $buyer_user_id)
      ->where(function ($query) {
        $query->whereNull('is_confirmed')
          ->orWhere('is_confirmed', true);
      })
      ->get();

    $busy_by_presentation_date = [];

    foreach ($busy_meetings as $meeting) {
      $busy_by_presentation_date[$meeting->presentation_date_id][] = [
        'start_time' => $meeting->start_time,
        'end_time' => $meeting->end_time,
      ];
    }

    foreach ($schedules as $schedule) {
      $slot_start = Carbon::createFromFormat('H:i:s', $schedule->start_time);
      $schedule_end = Carbon::createFromFormat('H:i:s', $schedule->end_time);

      while (true) {
        $slot_end = (clone $slot_start)->addMinutes($meeting_minutes);

        if ($slot_end->gt($schedule_end)) {
          break;
        }

        $is_busy = false;
        $busy_ranges = $busy_by_presentation_date[$schedule->presentation_date_id] ?? [];

        foreach ($busy_ranges as $busy_range) {
          $busy_start = Carbon::createFromFormat('H:i:s', $busy_range['start_time']);
          $busy_end = Carbon::createFromFormat('H:i:s', $busy_range['end_time']);

          $overlaps = $slot_start->lt($busy_end) && $slot_end->gt($busy_start);

          if ($overlaps) {
            $is_busy = true;
            break;
          }
        }

        if (!$is_busy) {
          return true;
        }

        $slot_start = $slot_end;
      }
    }

    return false;
  }

  /**
   * ===========================================
   * VALIDACIONES
   * ===========================================
   */
  public static function validData(array $data) {
    $rules = [
      'name' => ['required', 'string', 'min:2', 'max:60'],

      'logo_doc' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

      'phone' => ['nullable', 'regex:/^\d{10}$/'],
      'website_url' => ['nullable', 'string', 'max:150'],
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

      'logo_doc.image' => 'El logo debe ser una imagen',

      'phone.regex' => 'El teléfono debe contener exactamente 10 dígitos.',

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

    $item->logo_b64 = StorageMgrService::getBase64($item->logo_path, 'Buyer');
    $item->logo_doc = null;

    return $item;
  }

  /**
   * ===========================================
   * GUARDADO DE DATOS
   * ===========================================
   */
  public static function saveData(self $item, array $data) {
    $logo_doc = data_get($data, 'logo_doc');

    $item->name = Input::toUpper(data_get($data, 'name'));

    $item->phone = Input::onlyDigitsOrNull(data_get($data, 'phone'), 10);
    $item->website_url = Input::trimOrNull(data_get($data, 'website_url'));
    $item->description = Input::toText(data_get($data, 'description'));
    $item->address = Input::toText(data_get($data, 'address'));

    $item->municipality_id = Input::toId(data_get($data, 'municipality_id'));
    $item->zip = Input::onlyDigitsOrNull(data_get($data, 'zip'), 5);

    $item->is_reviewed = null;
    $item->reviewed_by_id = null;
    $item->reviewed_at = null;

    $item->logo_path = StorageMgrService::syncPath(
      $item->logo_path,
      $logo_doc instanceof UploadedFile ? $logo_doc : null,
      'Buyer'
    );

    $item->save();

    return $item;
  }

  public static function getMatchedSupplierAreas(Request $request): array {
    $buyer_user = BuyerUser::getFirstByUser($request->user()->id);

    if (!$buyer_user) {
      return [
        'has_available_hours' => false,
        'items' => collect(),
      ];
    }

    $event_id = (int) $request->event_id;
    $buyer_id = $buyer_user->buyer_id;
    $buyer_user_id = $buyer_user->id;
    $search = trim((string) $request->search);

    if ($event_id <= 0) {
      return [
        'has_available_hours' => false,
        'items' => collect(),
      ];
    }

    $has_available_hours = MeetingAvailabilityService::buyerHasAvailableHours(
      $event_id,
      $buyer_id,
      $buyer_user_id
    );

    if (!$has_available_hours) {
      return [
        'has_available_hours' => false,
        'items' => collect(),
      ];
    }

    $items = DB::table('supplier_event_areas')
      ->select([
        'supplier_event_areas.id as supplier_event_area_id',
        'supplier_event_areas.supplier_id',
        'supplier_event_areas.supplier_user_id',
        'supplier_event_areas.event_area_id',
        'buyer_offer_areas.id as buyer_offer_area_id',
      ])
      ->join('suppliers', 'suppliers.id', '=', 'supplier_event_areas.supplier_id')
      ->join('supplier_users', 'supplier_users.id', '=', 'supplier_event_areas.supplier_user_id')
      ->join('users', 'users.id', '=', 'supplier_users.user_id')
      ->join('event_areas', 'event_areas.id', '=', 'supplier_event_areas.event_area_id')
      ->join('buyer_offer_areas', function ($join) use ($buyer_id, $buyer_user_id) {
        $join->on('buyer_offer_areas.event_area_id', '=', 'supplier_event_areas.event_area_id')
          ->where('buyer_offer_areas.buyer_id', '=', $buyer_id)
          ->where('buyer_offer_areas.buyer_user_id', '=', $buyer_user_id)
          ->where('buyer_offer_areas.is_active', '=', true);
      })
      ->where('supplier_event_areas.is_active', true)
      ->where('suppliers.is_active', true)
      ->where('suppliers.is_reviewed', true)
      ->where('event_areas.is_active', true)
      ->where('event_areas.event_id', $event_id)
      ->whereNotExists(function ($query) {
        $query->selectRaw('1')
          ->from('meetings')
          ->whereColumn('meetings.supplier_event_area_id', 'supplier_event_areas.id')
          ->whereColumn('meetings.buyer_offer_area_id', 'buyer_offer_areas.id')
          ->where('meetings.is_active', true)
          ->where(function ($q) {
            $q->whereNull('meetings.is_confirmed')
              ->orWhere('meetings.is_confirmed', true);
          });
      })
      ->whereNotExists(function ($query) {
        $query->selectRaw('1')
          ->from('meeting_requests')
          ->whereColumn('meeting_requests.supplier_event_area_id', 'supplier_event_areas.id')
          ->whereColumn('meeting_requests.buyer_offer_area_id', 'buyer_offer_areas.id')
          ->where('meeting_requests.is_active', true)
          ->where(function ($q) {
            $q->whereNull('meeting_requests.is_approved')
              ->orWhere('meeting_requests.is_approved', true);
          });
      });

    if ($search !== '') {
      $items->where(function ($query) use ($search) {
        $query->where('suppliers.name', 'like', '%' . $search . '%')
          ->orWhere('suppliers.description', 'like', '%' . $search . '%')
          ->orWhere('suppliers.website_url', 'like', '%' . $search . '%')
          ->orWhere('event_areas.name', 'like', '%' . $search . '%')
          ->orWhere('users.name', 'like', '%' . $search . '%')
          ->orWhere('users.paternal_surname', 'like', '%' . $search . '%')
          ->orWhere('users.maternal_surname', 'like', '%' . $search . '%')
          ->orWhere('users.email', 'like', '%' . $search . '%');
      });
    }

    $rows = $items
      ->distinct()
      ->orderBy('event_areas.name')
      ->orderBy('suppliers.name')
      ->orderBy('users.name')
      ->get();

    if ($rows->isEmpty()) {
      return [
        'has_available_hours' => true,
        'items' => collect(),
      ];
    }

    $available_rows = $rows->filter(function ($row) use ($event_id) {
      return MeetingAvailabilityService::supplierHasAvailableHours(
        $event_id,
        (int) $row->supplier_id,
        (int) $row->supplier_user_id
      );
    })->values();

    if ($available_rows->isEmpty()) {
      return [
        'has_available_hours' => true,
        'items' => collect(),
      ];
    }

    $supplier_ids = $available_rows->pluck('supplier_id')->unique()->values();
    $supplier_user_ids = $available_rows->pluck('supplier_user_id')->unique()->values();
    $event_area_ids = $available_rows->pluck('event_area_id')->unique()->values();

    $suppliers = Supplier::query()
      ->select([
        'id',
        'name',
        'logo_path',
        'phone',
        'website_url',
        'description',
        'municipality_id',
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

    $supplier_users = SupplierUser::query()
      ->select([
        'supplier_users.id',
        'supplier_users.supplier_id',
        'supplier_users.user_id',
        'users.name',
        'users.paternal_surname',
        'users.maternal_surname',
        'users.avatar_path',
        'users.email',
        'users.phone',
      ])
      ->join('users', 'users.id', '=', 'supplier_users.user_id')
      ->whereIn('supplier_users.id', $supplier_user_ids)
      ->get()
      ->keyBy('id');

    $mapped = $available_rows->map(function ($row) use ($suppliers, $supplier_users, $event_areas) {
      $supplier = $suppliers[$row->supplier_id] ?? null;
      $supplier_user = $supplier_users[$row->supplier_user_id] ?? null;
      $event_area = $event_areas[$row->event_area_id] ?? null;

      if ($supplier) {
        $supplier->appendLogoBase64();
        $supplier->setMunicipality();
      }

      return [
        'id' => $row->supplier_event_area_id,
        'supplier_id' => $row->supplier_id,
        'supplier' => $supplier,
        'supplier_user_id' => $row->supplier_user_id,
        'supplier_user' => $supplier_user,
        'event_area_id' => $row->event_area_id,
        'event_area' => $event_area,
        'supplier_event_area_id' => $row->supplier_event_area_id,
        'buyer_offer_area_id' => $row->buyer_offer_area_id,
      ];
    })->values();

    return [
      'has_available_hours' => true,
      'items' => $mapped,
    ];
  }

  //COMPANY


  public static function getNotReviewItems(Request $request = null) {
    $items = self::query();

    $items->select(['buyers.*']);

    $items->with([
      'municipality:id,name,state_id',
      'municipality.state:id,name',
    ]);

    $items->join('event_buyers', 'event_buyers.buyer_id', 'buyers.id');

    $items->where('buyers.is_active', '=', true)->
      where('event_buyers.event_id', '=', $request->event_id);


    $items->orderBy('is_reviewed')->
      orderBy('name', 'asc');

    $items = $items->get();

    if (is_null($items)) {
      return null;
    }


    return $items;
  }


  public static function getNotReviewItem(Request $request = null) {
    $item = self::query();

    $item->select(['buyers.*']);

    $item->with([
      'created_by:id,email',
      'updated_by:id,email',
      'municipality:id,name,state_id',
      'municipality.state:id,name',
    ]);

    $item->join('event_buyers', 'event_buyers.buyer_id', 'buyers.id');

    $item->where('buyers.is_active', '=', true)->
      where('event_buyers.event_id', '=', $request->event_id)->
      where('buyers.id', '=', $request->buyer_id);

    $item = $item->first();

    if (is_null($item)) {
      return null;
    }

    $item->logo_b64 = StorageMgrService::getBase64($item->logo_path, 'Buyer');
    $item->logo_doc = null;

    return $item;
  }

}
