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

class StandRequest extends Model {
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

  public function supplier(): BelongsTo {
    return $this->belongsTo(Supplier::class, 'supplier_id');
  }

  public function event_stand_config(): BelongsTo {
    return $this->belongsTo(EventStandConfig::class, 'event_stand_config_id');
  }

  public function stand_allocation() {
    return $this->hasOne(StandAllocation::class, 'stand_request_id');
  }

  /**
   * ===========================================
   * ACCESSORES
   * ===========================================
   */
  public function getDisplayIdAttribute(): string {
    return DisplayId::make('SR', $this->id, 4);
  }

  /**
   * ===========================================
   * VALIDACIONES
   * ===========================================
   */
  public static function validData(array $data) {
    $rules = [
      'event_id' => ['required', 'integer', 'exists:events,id'],
      'justification' => ['required'],

      'event_stand_config_id' => [
        'required',
        'integer',
        'exists:event_stand_configs,id',
        function ($attribute, $value, $fail) use ($data) {

          $exists = DB::table('event_stand_configs')
            ->where('event_stand_configs.id', $value)
            ->where('event_stand_configs.event_id', $data['event_id'] ?? null)
            ->where('event_stand_configs.is_active', true)
            ->exists();

          if (!$exists) {
            $fail('La configuración del stand no pertenece al evento o no está activa.');
            return;
          }

          // No permitir repetir solicitud si ya existe una pendiente o aprobada
          if (!empty($data['supplier_id']) && !empty($data['event_id'])) {
            $query = DB::table('stand_requests')
              ->where('event_id', $data['event_id'])
              ->where('supplier_id', $data['supplier_id'])
              ->where('event_stand_config_id', $value)
              ->where('is_active', true)
              ->where(function ($q) {
                $q->whereNull('is_approved')
                  ->orWhere('is_approved', true);
              });

            // Ignorar el mismo registro en edición
            if (!empty($data['id'])) {
              $query->where('id', '!=', $data['id']);
            }

            if ($query->exists()) {
              $fail('Ya existe una solicitud enviada para esta configuración de stand. Solo puedes volver a enviarla si la anterior fue rechazada.');
            }
          }
        }
      ],
    ];

    $msgs = [
      'event_id.required' => 'El evento es obligatorio.',
      'event_id.integer' => 'El evento debe ser un identificador válido.',
      'event_id.exists' => 'El evento seleccionado no existe.',

      'justification.required' => 'La justificación es obligatoria.',

      'event_stand_config_id.required' => 'La configuración del stand es obligatoria.',
      'event_stand_config_id.integer' => 'La configuración del stand debe ser un identificador válido.',
      'event_stand_config_id.exists' => 'La configuración del stand no existe.',
    ];

    return Validator::make($data, $rules, $msgs);
  }

  public static function validDataApproved(array $data) {
    $rules = [
      'notes' => ['nullable', 'string'],
      'is_approved' => ['required', 'boolean'],
    ];

    $msgs = [
      'notes.string' => 'Las notas deben ser un texto válido.',

      'is_approved.required' => 'La aprovación es obligatoria.',
      'is_approved.boolean' => 'La aprovación debe ser boleano.',
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
      'stand_requests.id',
      'stand_requests.is_active',
      'stand_requests.event_id',
      'stand_requests.supplier_id',
      'stand_requests.event_stand_config_id',
      'stand_requests.justification',
      'stand_requests.notes',
      'stand_requests.price',
      'stand_requests.is_approved',
    ]);

    $items->with([
      'event_stand_config:id,name,has_electricity,has_water,has_internet',
      'supplier:id,name',
      'stand_allocation' => function ($query) {
        $query->select([
          'id',
          'stand_request_id',
          'is_paid',
          'transaction_id',
          'nexora_invoice_id',
          'organization_invoice_id',
        ])->with([
              'transaction:id,external_id',
            ]);
      },
    ]);

    $items->where('stand_requests.is_active', (bool) ((int) $is_active))
      ->where('stand_requests.event_id', $request->event_id)
      ->where('stand_requests.created_by_id', $request->user()->id);

    $items->leftJoin('stand_allocations', function ($join) {
      $join->on('stand_allocations.stand_request_id', '=', 'stand_requests.id');
    });

    $items->where('stand_requests.is_active', (bool) ((int) $is_active))
      ->where('stand_requests.event_id', $request->event_id)
      ->where('stand_requests.created_by_id', $request->user()->id);

    $items->orderByRaw("
      CASE
        WHEN stand_requests.is_approved IS NULL THEN 1
        WHEN stand_requests.is_approved = 1 AND stand_allocations.id IS NULL THEN 2
        WHEN stand_requests.is_approved = 1 AND stand_allocations.id IS NOT NULL THEN 3
        WHEN stand_requests.is_approved = 0 THEN 4
        ELSE 5
      END
    ");

    return $items->get()->map(function ($item) {
      if ($item->stand_allocation) {
        $item->stand_allocation->is_paid = $item->stand_allocation->is_paid ? 1 : 0;
        $item->stand_allocation->external_id = $item->stand_allocation->transaction?->external_id;
        $item->stand_allocation->makeHidden(['transaction']);
      }

      return $item;
    });
  }

  public static function getItem($id, Request $request = null) {
    $item = self::query();

    $item->select(['stand_requests.*']);

    $item->selectSub(function ($query) {
      $query->from('stand_allocations')
        ->selectRaw('COALESCE(MAX(CASE WHEN is_paid = 1 THEN 1 ELSE 0 END), 0)')
        ->whereColumn('stand_allocations.stand_request_id', 'stand_requests.id');
    }, 'stand_allocation');

    $item->with([
      'created_by:id,email,name,paternal_surname,maternal_surname',
      'updated_by:id,email,name,paternal_surname,maternal_surname',
      'event_stand_config:*',
      'supplier:id,name',
    ]);

    $item->whereKey((int) $id)
      ->where('stand_requests.created_by_id', $request->user()->id);

    $item = $item->first();

    if (is_null($item)) {
      return null;
    }

    return $item;
  }

  public static function getApprovedPendingAllocations(Request $request) {
    $is_active = $request->query('is_active', 1);

    $items = self::query();

    $items->select([
      'stand_requests.id',
      'stand_requests.is_active',
      'stand_requests.event_id',
      'stand_requests.supplier_id',
      'stand_requests.event_stand_config_id',
      'stand_requests.justification',
      'stand_requests.notes',
      'stand_requests.is_approved',
    ]);

    $items->with([
      'stand_allocation' => function ($query) {
        $query->select([
          'id',
          'stand_request_id',
          'is_paid',
        ]);
      },
    ]);

    $items->where('stand_requests.is_active', (bool) ((int) $is_active))
      ->where('stand_requests.event_id', $request->event_id)
      ->where('stand_requests.is_approved', true)
      ->whereDoesntHave('stand_allocation', function ($query) {
        $query->where('is_paid', true);
      });

    return $items->get();
  }

  /**
   * ===========================================
   * GUARDADO DE DATOS
   * ===========================================
   */
  public static function saveData(self $item, array $data): self {

    $item->event_id = Input::toId(data_get($data, 'event_id'));
    $item->event_stand_config_id = Input::toId(data_get($data, 'event_stand_config_id'));
    $item->supplier_id = Input::toId(data_get($data, 'supplier_id'));
    $item->justification = Input::toText(data_get($data, 'justification'));
    $item->price = Input::toText(data_get($data, 'price'));

    $item->save();

    return $item;
  }

  /**
   * ===========================================
   * CONSULTAS COMPANY
   * ===========================================
   */
  public static function getCompanyItems(Request $request) {
    $is_active = $request->query('is_active', 1);

    $items = self::query();

    $items->select([
      'stand_requests.id',
      'stand_requests.is_active',
      'stand_requests.event_id',
      'stand_requests.event_stand_config_id',
      'stand_requests.supplier_id',
      'stand_requests.justification',
      'stand_requests.notes',
      'stand_requests.is_approved',
    ]);

    $items->with([
      'event_stand_config:*',
      'supplier:id,name'
    ]);

    $items->where('stand_requests.is_active', (bool) ((int) $is_active))->
      where('stand_requests.event_id', $request->event_id)->
      where('stand_requests.is_approved', $request->is_approved);

    return $items->get();
  }

  /**
   * ===========================================
   * GUARDADO DE DATOS COMPANY
   * ===========================================
   */
  public static function setApproved(self $item, array $data): self {
    $item->notes = Input::toUpper(data_get($data, 'notes'));
    $item->is_approved = Input::toBool(data_get($data, 'is_approved'));

    $item->save();

    return $item;
  }
}
