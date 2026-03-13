<?php

namespace App\Models;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use App\Services\StorageMgrService;
use App\Support\DisplayId;
use App\Support\Input;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\HasApiTokens;

class Event extends Model {
  use HasApiTokens, HasFactory, Notifiable;

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

  public function company_users()
{
    return $this->hasMany(CompanyUser::class);
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
      'has_stands' => ['required', 'boolean'],

      'company_id' => ['required', 'integer', 'exists:companies,id'],

      'name' => ['required', 'string', 'min:2', 'max:255'],
      'description' => ['nullable', 'string', 'min:2'],

      'place_name' => ['required', 'string', 'min:2', 'max:60'],
      'address' => ['required', 'string', 'min:2', 'max:60'],

      'latitude' => ['nullable', 'numeric', 'between:-90,90'],
      'longitude' => ['nullable', 'numeric', 'between:-180,180'],

      'is_public' => ['required', 'boolean'],

      'sale_start_at' => ['required', 'date'],
      'sale_end_at' => ['required', 'date', 'after_or_equal:sale_start_at'],
    ];

    $msgs = [
      'sale_end_at.after_or_equal' => 'La fecha de fin de venta debe ser posterior al inicio'
      //   'phone.regex' => 'El teléfono debe contener 10 dígitos',
      //   'logo_doc.image' => 'La fotografía debe ser una imagen válida',
      //   'logo_doc.mimes' => 'La fotografía debe ser JPG o PNG',
      //   'logo_doc.max' => 'La fotografía no debe exceder 2MB',
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
      'events.id',
      'events.is_active',
      'events.has_stands',
      'events.company_id',
      'events.name',
      'events.description',
      'events.place_name',
      'events.address',
      'events.latitude',
      'events.longitude',
      'events.logo_path',
      'events.flyer_path',
      'events.is_public',
      'events.sale_start_at',
      'events.sale_end_at',
    ]);

    $items->where('events.is_active', (bool) ((int) $is_active));

    return $items->get();
  }

  public static function getItem($id, Request $request = null) {
    $item = self::query();

    $item->select(['events.*']);

    $item->with([
      'created_by:id,email,name,paternal_surname,maternal_surname',
      'updated_by:id,email,name,paternal_surname,maternal_surname',
    ]);

    $item->whereKey((int) $id);

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

  /**
   * ===========================================
   * GUARDADO DE DATOS
   * ===========================================
   */
  public static function saveData(self $item, array $data): self {
    $logo_doc = data_get($data, 'logo_doc');
    $flyer_doc = data_get($data, 'flyer_doc');

    $item->has_stands = Input::toBool(data_get($data, 'has_stands'));
    $item->company_id = Input::toId(data_get($data, 'company_id'));
    $item->name = Input::toUpper(data_get($data, 'name'));
    $item->description = Input::toUpper(data_get($data, 'description'));
    $item->place_name = Input::toUpper(data_get($data, 'place_name'));
    $item->address = Input::toUpper(data_get($data, 'address'));
    $item->latitude = Input::toFloat(data_get($data, 'latitude'));
    $item->longitude = Input::toFloat(data_get($data, 'longitude'));
    $item->is_public = Input::toBool(data_get($data, 'is_public'));
    $item->sale_start_at = Input::toText(data_get($data, 'sale_start_at'));
    $item->sale_end_at = Input::toText(data_get($data, 'sale_end_at'));
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

    return $items->get();
  }
}
