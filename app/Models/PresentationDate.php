<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use App\Support\DisplayId;
use App\Support\Input;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\HasApiTokens;

class PresentationDate extends Model {
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
    'reception_time' => 'datetime:H:i',
    'start_time' => 'datetime:H:i',
    'end_time' => 'datetime:H:i',
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
  public function event()
{
    return $this->belongsTo(Event::class);
}

  /**
   * ===========================================
   * ACCESSORES
   * ===========================================
   */
  public function getDisplayIdAttribute(): string {
    return DisplayId::make('PD', $this->id, 4);
  }

  /**
   * ===========================================
   * VALIDACIONES
   * ===========================================
   */
  public static function validData(array $data) {
    $rules = [
      'event_id' => ['required', 'integer', 'exists:events,id'],

      'date' => ['required', 'date'],

      'reception_time' => ['required', 'date_format:H:i'],
      'start_time' => ['required', 'date_format:H:i', 'after_or_equal:reception_time'],
      'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
    ];
    $msgs = [
      'start_time.after_or_equal' => 'La hora de inicio debe ser posterior a la recepción',
      'end_time.after' => 'La hora de término debe ser posterior al inicio',
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
      'presentation_dates.id',
      'presentation_dates.is_active',
      'presentation_dates.event_id',
      'presentation_dates.date',
      'presentation_dates.reception_time',
      'presentation_dates.start_time',
      'presentation_dates.end_time',
    ]);

    $items->where('presentation_dates.is_active', (bool) ((int) $is_active))->
      where('event_id', $request->event_id);

    return $items->get();
  }

  public static function getItem($id, Request $request = null) {
    $item = self::query();

    $item->select(['presentation_dates.*']);

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
    $item->date = Input::toText(data_get($data, 'date'));
    $item->reception_time = Input::toText(data_get($data, 'reception_time'));
    $item->start_time = Input::toText(data_get($data, 'start_time'));
    $item->end_time = Input::toText(data_get($data, 'end_time'));
    $item->save();

    return $item;
  }

  /**
   * ===========================================
   * CONSULTAS PUBLICAS
   * ===========================================
   */
  public static function publicGetItems(Request $request) {
    $is_active = $request->query('is_active', 1);

    $items = self::query();

    $items->select([
      'presentation_dates.id',
      'presentation_dates.is_active',
      'presentation_dates.event_id',
      'presentation_dates.date',
      'presentation_dates.reception_time',
      'presentation_dates.start_time',
      'presentation_dates.end_time',

      DB::raw('SUM(presentation_tickets.capacity) as capacity_total'),
      DB::raw('SUM(presentation_tickets.sold) as sold_total'),
      DB::raw('SUM(presentation_tickets.capacity - presentation_tickets.sold) as available_total')
    ]);

    $items->leftJoin(
      'presentation_tickets',
      'presentation_tickets.presentation_date_id',
      '=',
      'presentation_dates.id'
    );

    $items->where('presentation_dates.is_active', (bool) ((int) $is_active))
      ->where('presentation_dates.event_id', $request->event_id);

    $items->groupBy([
      'presentation_dates.id',
      'presentation_dates.is_active',
      'presentation_dates.event_id',
      'presentation_dates.date',
      'presentation_dates.reception_time',
      'presentation_dates.start_time',
      'presentation_dates.end_time'
    ]);

    return $items->get();
  }
}
