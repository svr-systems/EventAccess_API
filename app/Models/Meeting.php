<?php

namespace App\Models;

use App\Models\Traits\HasAuditFields;
use App\Support\DisplayId;
use App\Support\Input;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use NunoMaduro\Collision\Provider;
use Validator;

class Meeting extends Model {
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

  public function supplier(): BelongsTo {
    return $this->belongsTo(Supplier::class, 'supplier_id');
  }

  public function presentation_date(): BelongsTo {
    return $this->belongsTo(PresentationDate::class, 'presentation_date_id');
  }

  public function buyer(): BelongsTo {
    return $this->belongsTo(Buyer::class, 'buyer_id');
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
      'id' => ['nullable', 'integer'],
      'event_id' => ['required', 'integer', 'exists:events,id'],
      'presentation_date_id' => ['required', 'integer', 'exists:presentation_dates,id'],
      'event_area_id' => ['required', 'integer', 'exists:event_areas,id'],
      'supplier_id' => ['required', 'integer', 'exists:suppliers,id'],
      'supplier_user_id' => ['required', 'integer', 'exists:supplier_users,id'],
      'start_time' => ['required', 'date_format:H:i'],
      'is_confirmed' => ['nullable', 'boolean'],
    ];

    $msgs = [
      'id.integer' => 'El identificador debe ser válido.',

      'event_id.required' => 'El evento es obligatorio.',
      'event_id.integer' => 'El evento debe ser un identificador válido.',
      'event_id.exists' => 'El evento seleccionado no es válido.',

      'presentation_date_id.required' => 'La fecha de presentación es obligatoria.',
      'presentation_date_id.integer' => 'La fecha de presentación debe ser un identificador válido.',
      'presentation_date_id.exists' => 'La fecha de presentación seleccionada no es válida.',

      'event_area_id.required' => 'El área del evento es obligatoria.',
      'event_area_id.integer' => 'El área del evento debe ser un identificador válido.',
      'event_area_id.exists' => 'El área del evento seleccionada no es válida.',

      'supplier_id.required' => 'El proveedor es obligatorio.',
      'supplier_id.integer' => 'El proveedor debe ser un identificador válido.',
      'supplier_id.exists' => 'El proveedor seleccionado no es válido.',

      'supplier_user_id.required' => 'El usuario proveedor es obligatorio.',
      'supplier_user_id.integer' => 'El usuario proveedor debe ser un identificador válido.',
      'supplier_user_id.exists' => 'El usuario proveedor seleccionado no es válido.',

      'start_time.required' => 'La hora de inicio es obligatoria.',
      'start_time.date_format' => 'La hora de inicio debe tener formato HH:MM:SS.',

      'is_confirmed.boolean' => 'El valor de confirmación debe ser verdadero o falso.',
    ];

    $validator = Validator::make($data, $rules, $msgs);

    $validator->after(function ($validator) use ($data) {
      $id = Input::toId(data_get($data, 'id'));
      $event_id = Input::toId(data_get($data, 'event_id'));
      $presentation_date_id = Input::toId(data_get($data, 'presentation_date_id'));
      $event_area_id = Input::toId(data_get($data, 'event_area_id'));
      $supplier_id = Input::toId(data_get($data, 'supplier_id'));
      $supplier_user_id = Input::toId(data_get($data, 'supplier_user_id'));
      $start_time = Input::trimOrNull(data_get($data, 'start_time'));
      $end_time = Input::trimOrNull(data_get($data, 'end_t$end_time'));
      $buyer_id = Input::toId(data_get($data, 'buyer_id'));
      $buyer_user_id = Input::toId(data_get($data, 'buyer_user_id'));

      if (!is_null($presentation_date_id) && !is_null($event_id)) {
        $exists = \App\Models\PresentationDate::query()
          ->whereKey($presentation_date_id)
          ->where('event_id', $event_id)
          ->exists();

        if (!$exists) {
          $validator->errors()->add(
            'presentation_date_id',
            'La fecha de presentación no pertenece al evento seleccionado.'
          );
        }
      }

      if (!is_null($event_area_id) && !is_null($event_id)) {
        $exists = \App\Models\EventArea::query()
          ->whereKey($event_area_id)
          ->where('event_id', $event_id)
          ->exists();

        if (!$exists) {
          $validator->errors()->add(
            'event_area_id',
            'El área no pertenece al evento seleccionado.'
          );
        }
      }

      if (!is_null($supplier_user_id) && !is_null($supplier_id)) {
        $exists = \App\Models\SupplierUser::query()
          ->whereKey($supplier_user_id)
          ->where('supplier_id', $supplier_id)
          // ->where('is_active', true)
          ->exists();

        if (!$exists) {
          $validator->errors()->add(
            'supplier_user_id',
            'El usuario proveedor no pertenece al proveedor seleccionado.'
          );
        }
      }

      if (!is_null($buyer_user_id) && !is_null($buyer_id)) {
        $exists = \App\Models\BuyerUser::query()
          ->whereKey($buyer_user_id)
          ->where('buyer_id', $buyer_id)
          // ->where('is_active', true)
          ->exists();

        if (!$exists) {
          $validator->errors()->add(
            'buyer_user_id',
            'El usuario comprador no pertenece al comprador seleccionado.'
          );
        }
      }

      if (
        is_null($event_id) ||
        is_null($presentation_date_id) ||
        is_null($event_area_id) ||
        is_null($supplier_id) ||
        is_null($supplier_user_id) ||
        is_null($buyer_id) ||
        is_null($buyer_user_id) ||
        is_null($start_time) ||
        is_null($end_time)
      ) {
        return;
      }

      $buyerOverlap = self::query()
        ->where('event_id', $event_id)
        ->where('presentation_date_id', $presentation_date_id)
        ->where('buyer_user_id', $buyer_user_id)
        ->where('is_active', true)
        ->where(function ($q) use ($start_time, $end_time) {
          $q->where('start_time', '<', $end_time)
            ->where('end_time', '>', $start_time);
        })
        ->where(function ($q) {
          $q->whereNull('is_confirmed')
            ->orWhere('is_confirmed', true);
        });

      if (!is_null($id)) {
        $buyerOverlap->where('id', '<>', $id);
      }

      if ($buyerOverlap->exists()) {
        $validator->errors()->add(
          'start_time',
          'El comprador ya tiene una reunión en ese horario.'
        );
      }

      $supplierOverlap = self::query()
        ->where('event_id', $event_id)
        ->where('presentation_date_id', $presentation_date_id)
        ->where('supplier_user_id', $supplier_user_id)
        ->where('is_active', true)
        ->where(function ($q) use ($start_time, $end_time) {
          $q->where('start_time', '<', $end_time)
            ->where('end_time', '>', $start_time);
        })
        ->where(function ($q) {
          $q->whereNull('is_confirmed')
            ->orWhere('is_confirmed', true);
        });

      if (!is_null($id)) {
        $supplierOverlap->where('id', '<>', $id);
      }

      if ($supplierOverlap->exists()) {
        $validator->errors()->add(
          'start_time',
          'El proveedor ya tiene una reunión en ese horario.'
        );
      }

      $validSupplier = \DB::table('supplier_event_areas')
        ->join('event_areas', 'event_areas.id', '=', 'supplier_event_areas.event_area_id')
        ->join('buyer_offer_areas', function ($join) use ($buyer_id) {
          $join->on('buyer_offer_areas.event_area_id', '=', 'supplier_event_areas.event_area_id')
            ->where('buyer_offer_areas.buyer_id', $buyer_id)
            ->where('buyer_offer_areas.is_active', true);
        })
        ->where('supplier_event_areas.supplier_id', $supplier_id)
        ->where('event_areas.event_id', $event_id)
        ->where('supplier_event_areas.is_active', true)
        ->where('event_areas.is_active', true)
        ->exists();

      if (!$validSupplier) {
        $validator->errors()->add(
          'supplier_id',
          'El proveedor no es válido para este comprador en el evento.'
        );
      }

      $meeting_time = Input::toInt(data_get($data, 'meeting_time'));

      if ($meeting_time > 0 && !is_null($start_time)) {
        $minutes = \Carbon\Carbon::createFromFormat('H:i:s', $start_time)->minute;

        if ($minutes % $meeting_time !== 0) {
          $validator->errors()->add(
            'start_time',
            'La hora no es válida según la duración de las reuniones.'
          );
        }
      }

      $validSchedule = \App\Models\BuyerUserSchedule::query()
        ->where('event_id', $event_id)
        ->where('presentation_date_id', $presentation_date_id)
        ->where('buyer_user_id', $buyer_user_id)
        ->where('is_active', true)
        ->where('start_time', '<=', $start_time)
        ->where('end_time', '>=', $end_time)
        ->exists();

      if (!$validSchedule) {
        $validator->errors()->add(
          'start_time',
          'El horario está fuera de la disponibilidad del comprador.'
        );
      }

      $validEventSupplier = \App\Models\EventSupplier::query()
        ->where('event_id', $event_id)
        ->where('supplier_id', $supplier_id)
        ->where('is_active', true)
        ->exists();

      if (!$validEventSupplier) {
        $validator->errors()->add(
          'supplier_id',
          'El proveedor no está registrado en el evento.'
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
    $buyer_user = BuyerUser::getFirstByUser($request->user()->id);

    $items = self::query();

    $items->select([
      'meetings.*'
    ]);

    $items->with([
      'event_area:id,name',
      'supplier:id,name,logo_path',
      'presentation_date:id,date',
    ]);

    $items->where('meetings.is_active', (bool) ((int) $is_active))->
      where('buyer_user_id', $buyer_user->id)->
      where('buyer_id', $buyer_user->buyer_id);

    $items = $items->get();

    return $items->map(function ($item) {
      $item->supplier->appendLogoBase64();

      return $item;
    });
  }

  public static function getItem($id, Request $request = null) {
    $item = self::query();

    $item->select(['meetingd.*']);

    $item->with([
      'created_by:id,email,name,paternal_surname,maternal_surname',
      'updated_by:id,email,name,paternal_surname,maternal_surname',
      'stand_type:id,name'
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
    $item->event_area_id = Input::toId(data_get($data, 'event_area_id'));

    $item->buyer_id = Input::toId(data_get($data, 'buyer_id'));
    $item->buyer_user_id = Input::toId(data_get($data, 'buyer_user_id'));

    $item->supplier_id = Input::toId(data_get($data, 'supplier_id'));
    $item->supplier_user_id = Input::toId(data_get($data, 'supplier_user_id'));

    $item->start_time = Input::trimOrNull(data_get($data, 'start_time'));
    $item->end_time = Input::trimOrNull(data_get($data, 'end_time'));

    $item->is_confirmed = true;


    $item->save();

    return $item;
  }

  public static function calcEndTime(?string $start_time, int $minutes): ?string {
    if (is_null($start_time) || $minutes <= 0) {
      return null;
    }

    return \Carbon\Carbon::createFromFormat('H:i', $start_time)
      ->addMinutes($minutes)
      ->format('H:i:s');
  }

  public static function getAvailableSlots(Request $request) {
    $buyer_user = BuyerUser::getFirstByUser($request->user()->id);

    if (!$buyer_user) {
      return collect();
    }

    $buyer_id = $buyer_user->buyer_id;
    $buyer_user_id = $buyer_user->id;
    $supplier_user_id = (int) $request->supplier_user_id;
    $event_id = (int) $request->event_id;

    $supplier_user = SupplierUser::query()
      ->select([
        'id',
        'supplier_id',
        'user_id',
      ])
      ->where('id', $supplier_user_id)
      ->first();

    if (!$supplier_user) {
      return collect();
    }

    $supplier_id = $supplier_user->supplier_id;

    // Validar que ese supplier sí sea visible para este buyer dentro del evento
    $supplier_is_available = DB::table('supplier_event_areas')
      ->join('event_areas', 'event_areas.id', '=', 'supplier_event_areas.event_area_id')
      ->join('buyer_offer_areas', function ($join) use ($buyer_id) {
        $join->on('buyer_offer_areas.event_area_id', '=', 'supplier_event_areas.event_area_id')
          ->where('buyer_offer_areas.buyer_id', $buyer_id)
          ->where('buyer_offer_areas.is_active', true);
      })
      ->where('supplier_event_areas.is_active', true)
      ->where('event_areas.is_active', true)
      ->where('supplier_event_areas.supplier_id', $supplier_id)
      ->where('event_areas.event_id', $event_id)
      ->exists();

    if (!$supplier_is_available) {
      return collect();
    }

    $event = Event::query()
      ->select([
        'id',
        'meeting_time',
      ])
      ->where('id', $event_id)
      ->where('is_active', true)
      ->first();

    if (!$event || !$event->meeting_time || $event->meeting_time <= 0) {
      return collect();
    }

    $meeting_minutes = (int) $event->meeting_time;

    $schedules = BuyerUserSchedule::query()
      ->select([
        'id',
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
      return collect();
    }

    $presentation_date_ids = $schedules->pluck('presentation_date_id')->unique()->values();

    $presentation_dates = PresentationDate::query()
      ->select([
        'id',
        'date',
      ])
      ->whereIn('id', $presentation_date_ids)
      ->where('is_active', true)
      ->get()
      ->keyBy('id');

    // Meetings ocupados del buyer_user
    $buyer_busy_meetings = self::query()
      ->select([
        'presentation_date_id',
        'start_time',
        'end_time',
      ])
      ->where('is_active', true)
      ->whereIn('presentation_date_id', $presentation_date_ids)
      ->where('buyer_user_id', $buyer_user_id)
      ->where(function ($query) {
        $query->whereNull('is_confirmed')
          ->orWhere('is_confirmed', true);
      })
      ->get();

    // Meetings ocupados del supplier_user seleccionado
    $supplier_user_busy_meetings = self::query()
      ->select([
        'presentation_date_id',
        'start_time',
        'end_time',
      ])
      ->where('is_active', true)
      ->whereIn('presentation_date_id', $presentation_date_ids)
      ->where('supplier_user_id', $supplier_user_id)
      ->where(function ($query) {
        $query->whereNull('is_confirmed')
          ->orWhere('is_confirmed', true);
      })
      ->get();

    $busy_by_presentation_date = [];

    foreach ($buyer_busy_meetings as $meeting) {
      $busy_by_presentation_date[$meeting->presentation_date_id][] = [
        'start_time' => $meeting->start_time,
        'end_time' => $meeting->end_time,
      ];
    }

    foreach ($supplier_user_busy_meetings as $meeting) {
      $busy_by_presentation_date[$meeting->presentation_date_id][] = [
        'start_time' => $meeting->start_time,
        'end_time' => $meeting->end_time,
      ];
    }

    $result = collect();

    foreach ($schedules as $schedule) {
      $presentation_date = $presentation_dates[$schedule->presentation_date_id] ?? null;

      if (!$presentation_date) {
        continue;
      }

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
          $result->push([
            'presentation_date_id' => $schedule->presentation_date_id,
            'presentation_date' => $presentation_date,
            'start_time' => $slot_start->format('H:i'),
            'end_time' => $slot_end->format('H:i'),
          ]);
        }

        $slot_start = $slot_end;
      }
    }

    return $result
      ->sortBy([
        ['presentation_date.date', 'asc'],
        ['start_time', 'asc'],
      ])
      ->values();
  }

  /**
   * ===========================================
   * CONSULTAS SUPPLIER
   * ===========================================
   */
  public static function getSupplierItems(Request $request) {
    $is_active = $request->query('is_active', 1);
    $supplier_user = SupplierUser::getFirstByUser($request->user()->id);

    $items = self::query();

    $items->select([
      'meetings.*'
    ]);

    $items->with([
      'event_area:id,name',
      'buyer:id,name,logo_path',
      'presentation_date:id,date',
    ]);

    $items->where('meetings.is_active', (bool) ((int) $is_active))->
      where('supplier_user_id', $supplier_user->id)->
      where('supplier_id', $supplier_user->supplier_id);

    $items = $items->get();

    return $items->map(function ($item) {
      $item->buyer->appendLogoBase64();

      return $item;
    });
  }
}
