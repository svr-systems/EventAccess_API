<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\DisplayId;
use App\Support\Input;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\HasApiTokens;

class TicketType extends Model {
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
      'name' => ['required', 'string', 'min:2', 'max:30'],
      'description' => ['nullable', 'string', 'min:2'],
    ];

    $msgs = [
      // 'start_time.after_or_equal' => 'La hora de inicio debe ser posterior a la recepción',
      // 'end_time.after' => 'La hora de término debe ser posterior al inicio',
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
      'ticket_types.id',
      'ticket_types.is_active',
      'ticket_types.event_id',
      'ticket_types.name',
      'ticket_types.description',
    ]);

    $items->where('ticket_types.is_active', (bool) ((int) $is_active))->
      where('event_id',$request->event_id);

    return $items->get();
  }

  public static function getItem($id, Request $request = null) {
    $item = self::query();

    $item->select(['ticket_types.*']);

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
    $item->name = Input::toText(data_get($data, 'name'));
    $item->description = Input::toText(data_get($data, 'description'));
    $item->save();

    return $item;
  }
}
