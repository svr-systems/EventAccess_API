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

class PresentationTicket extends Model {
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

  public function ticket_type(): BelongsTo {
    return $this->belongsTo(TicketType::class, 'ticket_type_id');
  }
  
  public function presentation_date()
{
    return $this->belongsTo(PresentationDate::class);
}

  /**
   * ===========================================
   * ACCESSORES
   * ===========================================
   */
  public function getDisplayIdAttribute(): string {
    return DisplayId::make('PT', $this->id, 4);
  }

  /**
   * ===========================================
   * VALIDACIONES
   * ===========================================
   */
  public static function validData(array $data) {
    $rules = [
      'presentation_date_id' => ['required', 'integer', 'exists:presentation_dates,id'],
      'ticket_type_id' => ['required', 'integer', 'exists:ticket_types,id'],
      'price' => ['required', 'numeric', 'min:0'],
      'capacity' => ['nullable', 'integer', 'min:1'],
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
      'presentation_tickets.id',
      'presentation_tickets.is_active',
      'presentation_tickets.presentation_date_id',
      'presentation_tickets.ticket_type_id',
      'presentation_tickets.price',
      'presentation_tickets.capacity',
      'presentation_tickets.sold',
    ]);

    $items->with([
      'ticket_type:id,name,description'
    ]);

    $items->where('presentation_tickets.is_active', (bool) ((int) $is_active))->
      where('presentation_date_id', $request->presentation_date_id);

    return $items->get();
  }

  public static function getItem($id, Request $request = null) {
    $item = self::query();

    $item->select(['presentation_tickets.*']);

    $item->with([
      'ticket_type:id,name,description',
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
    $item->presentation_date_id = Input::toId(data_get($data, 'presentation_date_id'));
    $item->ticket_type_id = Input::toId(data_get($data, 'ticket_type_id'));
    $item->price = Input::toFloat(data_get($data, 'price'));
    $item->capacity = Input::toInt(data_get($data, 'capacity'));
    $item->save();

    return $item;
  }

  /**
   * ===========================================
   * CONSULTAS PUBLIC
   * ===========================================
   */
  public static function publicGetItems(Request $request) {
    $is_active = $request->query('is_active', 1);

    $items = self::query();

    $items->select([
      'presentation_tickets.id',
      'presentation_tickets.is_active',
      'presentation_tickets.presentation_date_id',
      'presentation_tickets.ticket_type_id',
      'presentation_tickets.price',
      'presentation_tickets.capacity',
      'presentation_tickets.sold',
    ]);

    $items->with([
      'ticket_type:id,name,description'
    ]);

    $items->where('presentation_tickets.is_active', (bool) ((int) $is_active))->
      where('presentation_date_id', $request->presentation_date_id);

    return $items->get();
  }
}
