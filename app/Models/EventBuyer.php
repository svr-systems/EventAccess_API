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

class EventBuyer extends Model {
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

  public function events(): BelongsTo {
    return $this->belongsTo(Event::class, 'event_id');
  }

  /**
   * ===========================================
   * ACCESSORES
   * ===========================================
   */
  public function getDisplayIdAttribute(): string {
    return DisplayId::make('EB', $this->id, 4);
  }

  /**
   * ===========================================
   * VALIDACIONES
   * ===========================================
   */
  public static function validData(array $data) {
    $rules = [
      'event_id' => [
        'required',
        'integer',
        'exists:events,id',
      ],

      'buyer_id' => [
        'required',
        'integer',
        'exists:buyers,id',
        function ($attribute, $value, $fail) use ($data) {

          // 🔥 Evitar duplicados manualmente
          $exists = DB::table('event_buyers')
            ->where('event_id', $data['event_id'] ?? null)
            ->where('buyer_id', $value)
            ->exists();

          if ($exists) {
            $fail('Este comprador ya está registrado en el evento.');
          }
        }
      ],
    ];

    $msgs = [
      'event_id.required' => 'El evento es obligatorio.',
      'event_id.integer' => 'El evento debe ser un identificador válido.',
      'event_id.exists' => 'El evento seleccionado no existe.',

      'buyer_id.required' => 'El comprador es obligatorio.',
      'buyer_id.integer' => 'El comprador debe ser un identificador válido.',
      'buyer_id.exists' => 'El comprador seleccionado no existe.',
    ];

    return Validator::make($data, $rules, $msgs);

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
      'event_buyers.id',
      'event_buyers.is_active',
      'event_buyers.event_id',
      'event_buyers.buyer_id',
    ]);

    $items->with([
      'created_by:id,email,name,paternal_surname,maternal_surname',
      'updated_by:id,email,name,paternal_surname,maternal_surname',
      'events:id,name,description'
    ]);

    $items->where('event_buyers.is_active', (bool) ((int) $is_active))->
      where('buyer_id', $request->buyer_id);

    return $items->get();
  }

  public static function getItem($id, Request $request = null) {
    $item = self::query();

    $item->select(['event_buyers.*']);

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
    $item->buyer_id = Input::toId(data_get($data, 'buyer_id'));

    $item->save();

    return $item;
  }
}
