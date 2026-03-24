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

class BuyerUserSchedule extends Model {
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

  public function buyer_user(): BelongsTo {
    return $this->belongsTo(BuyerUser::class, 'buyer_user_id');
  }

  public function user(): BelongsTo {
    return $this->belongsTo(User::class, 'user_id');
  }

  /**
   * ===========================================
   * ACCESSORES
   * ===========================================
   */
  public function getDisplayIdAttribute(): string {
    return DisplayId::make('BUS', $this->id, 4);
  }

  /**
   * ===========================================
   * VALIDACIONES
   * ===========================================
   */
  public static function validData(array $data) {
    $rules = [
      'buyer_id' => ['required', 'integer', 'exists:buyers,id'],

      'event_id' => ['required', 'integer', 'exists:events,id'],

      'buyer_user_id' => [
        'required',
        'integer',
        'exists:buyer_users,id',
      ],

      'presentation_date_id' => [
        'required',
        'integer',
        'exists:presentation_dates,id',
      ],

      'start_time' => ['required', 'date_format:H:i'],
      'end_time' => ['required', 'date_format:H:i'],
    ];

    $msgs = [
      'buyer_id.required' => 'El comprador es obligatorio.',
      'buyer_id.exists' => 'El comprador no existe.',

      'event_id.required' => 'El evento es obligatorio.',
      'event_id.exists' => 'El evento no existe.',

      'buyer_user_id.required' => 'El usuario del comprador es obligatorio.',
      'buyer_user_id.exists' => 'El usuario del comprador no existe.',

      'presentation_date_id.required' => 'La fecha de presentación es obligatoria.',
      'presentation_date_id.exists' => 'La fecha de presentación no existe.',

      'start_time.required' => 'La hora de inicio es obligatoria.',
      'start_time.date_format' => 'La hora de inicio debe tener formato HH:MM.',

      'end_time.required' => 'La hora de fin es obligatoria.',
      'end_time.date_format' => 'La hora de fin debe tener formato HH:MM.',
    ];

    $validator = Validator::make($data, $rules, $msgs);

    $validator->after(function ($validator) use ($data) {

      if (
        !isset($data['start_time']) ||
        !isset($data['end_time']) ||
        !isset($data['presentation_date_id'])
      ) {
        return;
      }

      // 🔥 1. start < end
      if ($data['start_time'] >= $data['end_time']) {
        $validator->errors()->add('start_time', 'La hora de inicio debe ser menor que la hora de fin.');
        return;
      }

      // 🔥 2. buyer_user pertenece a buyer
      $validBuyerUser = DB::table('buyer_users')
        ->where('id', $data['buyer_user_id'])
        ->where('buyer_id', $data['buyer_id'])
        ->exists();

      if (!$validBuyerUser) {
        $validator->errors()->add('buyer_user_id', 'El usuario no pertenece al comprador.');
      }

      // 🔥 3. presentation_date pertenece al evento
      $validDate = DB::table('presentation_dates')
        ->where('id', $data['presentation_date_id'])
        ->where('event_id', $data['event_id'])
        ->exists();

      if (!$validDate) {
        $validator->errors()->add('presentation_date_id', 'La fecha no pertenece al evento.');
      }

      // 🔥 4. Dentro de ventanas permitidas
      $insideWindow = DB::table('event_meeting_windows')
        ->where('presentation_date_id', $data['presentation_date_id'])
        ->where(function ($q) use ($data) {
          $q->where('start_time', '<=', $data['start_time'])
            ->where('end_time', '>=', $data['end_time']);
        })
        ->exists();

      if (!$insideWindow) {
        $validator->errors()->add('start_time', 'El horario está fuera de los rangos permitidos.');
      }

      // 🔥 5. Evitar traslapes por usuario
      $overlap = DB::table('buyer_user_schedules')
        ->where('buyer_user_id', $data['buyer_user_id'])
        ->where('presentation_date_id', $data['presentation_date_id'])

        // 🔥 Ignorar en edición
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
        $validator->errors()->add('start_time', 'El usuario ya tiene un horario que se traslapa.');
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
      'buyer_user_schedules.id',
      'buyer_user_schedules.is_active',
      'buyer_user_schedules.buyer_id',
      'buyer_user_schedules.event_id',
      'buyer_user_schedules.buyer_user_id',
      'buyer_user_schedules.presentation_date_id',
      'buyer_user_schedules.start_time',
      'buyer_user_schedules.end_time',
    ]);

    $items->with([
      'buyer_user:id,user_id',
      'buyer_user.user:id,name,paternal_surname,maternal_surname'
    ]);

    $items->where('buyer_user_schedules.is_active', (bool) ((int) $is_active))->
      where('event_id',$request->event_id);


    if ($request->user()->role_id === 3 || $request->user()->role_id === 4) {
      $items->join('company_users', 'company_users.company_id', 'buyer_user_schedules.id');
      $items->where('company_users.user_id', $request->user()->id);
    }

    return $items->get();
  }

  public static function getItem($id, Request $request = null) {
    $item = self::query();

    $item->select(['buyer_user_schedules.*']);

    $item->with([
      'created_by:id,email',
      'updated_by:id,email',
      'buyer_user:id,user_id',
      'buyer_user.user:id,name,paternal_surname,maternal_surname'
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
    $item->event_id = Input::toId(data_get($data, 'event_id'));
    $item->buyer_user_id = Input::toId(data_get($data, 'buyer_user_id'));
    $item->presentation_date_id = Input::toId(data_get($data, 'presentation_date_id'));
    $item->start_time = Input::toText(data_get($data, 'start_time'));
    $item->end_time = Input::toText(data_get($data, 'end_time'));

    $item->save();

    return $item;
  }
}
