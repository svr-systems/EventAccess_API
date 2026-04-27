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

class EventMeetingWindow extends Model {
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

  public function company_users() {
    return $this->hasMany(CompanyUser::class);
  }

  public function presentation_date(): BelongsTo {
    return $this->belongsTo(PresentationDate::class, 'presentation_date_id');
  }

  public function buyer_user_schedule(): BelongsTo {
    return $this->belongsTo(BuyerUserSchedule::class, 'buyer_user_schedule_id');
  }

  /**
   * ===========================================
   * ACCESSORES
   * ===========================================
   */
  public function getDisplayIdAttribute(): string {
    return DisplayId::make('EMW', $this->id, 4);
  }

  /**
   * ===========================================
   * VALIDACIONES
   * ===========================================
   */
  public static function validData(array $data) {
    $rules = [
      'event_id' => ['required', 'integer', 'exists:events,id'],

      'presentation_date_id' => [
        'required',
        'integer',
        'exists:presentation_dates,id',
        function ($attribute, $value, $fail) use ($data) {

          // 🔥 Validar coherencia event ↔ presentation_date
          $exists = DB::table('presentation_dates')
            ->where('id', $value)
            ->where('event_id', $data['event_id'] ?? null)
            ->exists();

          if (!$exists) {
            $fail('La fecha de presentación no pertenece al evento.');
          }
        }
      ],

      'start_time' => ['required', 'date_format:H:i'],
      'end_time' => ['required', 'date_format:H:i'],
    ];

    $msgs = [
      'event_id.required' => 'El evento es obligatorio.',
      'event_id.integer' => 'El evento debe ser un identificador válido.',
      'event_id.exists' => 'El evento seleccionado no existe.',

      'presentation_date_id.required' => 'La fecha de presentación es obligatoria.',
      'presentation_date_id.integer' => 'La fecha de presentación debe ser un identificador válido.',
      'presentation_date_id.exists' => 'La fecha de presentación no existe.',

      'start_time.required' => 'La hora de inicio es obligatoria.',
      'start_time.date_format' => 'La hora de inicio debe tener formato HH:MM.',

      'end_time.required' => 'La hora de fin es obligatoria.',
      'end_time.date_format' => 'La hora de fin debe tener formato HH:MM.',
    ];

    $validator = Validator::make($data, $rules, $msgs);

    // 🔥 Validaciones avanzadas
    $validator->after(function ($validator) use ($data) {

      if (
        !isset($data['start_time']) ||
        !isset($data['end_time']) ||
        !isset($data['presentation_date_id'])
      ) {
        return;
      }

      // 🔥 start < end
      if ($data['start_time'] >= $data['end_time']) {
        $validator->errors()->add('start_time', 'La hora de inicio debe ser menor que la hora de fin.');
      }

      // 🔥 Evitar traslapes
      $overlap = DB::table('event_meeting_windows')
        ->where('presentation_date_id', $data['presentation_date_id'])

        // 🔥 Ignorar el mismo registro si es edición
        ->when(isset($data['id']), function ($query) use ($data) {
          $query->where('id', '!=', $data['id']);
        })

        ->where(function ($q) use ($data) {
          $q->whereBetween('start_time', [$data['start_time'], $data['end_time']])
            ->orWhereBetween('end_time', [$data['start_time'], $data['end_time']])
            ->orWhere(function ($q2) use ($data) {
              $q2->where('start_time', '<=', $data['start_time'])
                ->where('end_time', '>=', $data['end_time']);
            });
        })
        ->exists();

      if ($overlap) {
        $validator->errors()->add('start_time', 'El horario se traslapa con otro ya registrado.');
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
      'event_meeting_windows.id',
      'event_meeting_windows.is_active',
      'event_meeting_windows.event_id',
      'event_meeting_windows.presentation_date_id',
      'event_meeting_windows.start_time',
      'event_meeting_windows.end_time',
    ]);

    $items->with([
      'presentation_date:id,date,start_time,end_time',
    ]);

    $items->where('event_meeting_windows.is_active', (bool) ((int) $is_active))->
      where('event_id', $request->event_id);

    return $items->get();
  }

  public static function getItem($id, Request $request = null) {
    $item = self::query();

    $item->select(['event_meeting_windows.*']);

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
    $item->presentation_date_id = Input::toId(data_get($data, 'presentation_date_id'));
    $item->start_time = Input::toText(data_get($data, 'start_time'));
    $item->end_time = Input::toText(data_get($data, 'end_time'));

    $item->save();

    return $item;
  }
}
