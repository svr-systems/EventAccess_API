<?php

namespace App\Models;

use App\Models\Traits\HasAuditFields;
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
  use HasApiTokens, HasFactory, Notifiable, HasAuditFields;

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

  public function presentation_date() {
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
      'event_id' => ['required', 'integer', 'exists:events,id'],
      'presentation_date_id' => ['required', 'integer', 'exists:presentation_dates,id'],

      'name' => ['required', 'string', 'min:2', 'max:30'],
      'description' => ['nullable', 'string', 'min:2'],

      'price' => ['required', 'numeric', 'min:0'],
      'max_sale' => ['required', 'integer', 'min:1'],
      'capacity' => ['nullable', 'integer', 'min:1'],

      'start_sale' => ['required', 'date'],
      'end_sale' => ['required', 'date', 'after:start_sale'],
    ];

    $msgs = [
      'event_id.required' => 'El evento es obligatorio',
      'event_id.exists' => 'El evento seleccionado no existe',

      'presentation_date_id.required' => 'La fecha de presentación es obligatoria',
      'presentation_date_id.exists' => 'La fecha de presentación no existe',

      'name.required' => 'El nombre del boleto es obligatorio',
      'name.max' => 'El nombre no puede tener más de 30 caracteres',

      'price.required' => 'El precio es obligatorio',
      'price.numeric' => 'El precio debe ser un número válido',
      'price.min' => 'El precio no puede ser negativo',

      'max_sale.required' => 'El máximo por compra es obligatorio',
      'max_sale.integer' => 'El máximo por compra debe ser un número entero',
      'max_sale.min' => 'El máximo por compra debe ser al menos 1',

      'capacity.integer' => 'La capacidad debe ser un número entero',
      'capacity.min' => 'La capacidad debe ser al menos 1',

      'start_sale.required' => 'La fecha de inicio de venta es obligatoria',
      'end_sale.required' => 'La fecha de fin de venta es obligatoria',
      'end_sale.after' => 'La fecha de fin debe ser posterior al inicio',
    ];

    $validator = Validator::make($data, $rules, $msgs);

    /**
     * ===========================================
     * VALIDACIÓN DE CONSISTENCIA
     * ===========================================
     */
    $validator->after(function ($validator) use ($data) {
      $event_id = data_get($data, 'event_id');
      $presentation_date_id = data_get($data, 'presentation_date_id');

      if ($event_id && $presentation_date_id) {
        $exists = PresentationDate::where('id', $presentation_date_id)
          ->where('event_id', $event_id)
          ->exists();

        if (!$exists) {
          $validator->errors()->add(
            'presentation_date_id',
            'La fecha de presentación no pertenece al evento seleccionado'
          );
        }
      }

      /**
       * Validar capacidad vs max_sale
       */
      $capacity = data_get($data, 'capacity');
      $max_sale = data_get($data, 'max_sale');

      if ($capacity && $max_sale && $max_sale > $capacity) {
        $validator->errors()->add(
          'max_sale',
          'El máximo por compra no puede ser mayor a la capacidad'
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

    $items = self::query();

    $items->select([
      'presentation_tickets.id',
      'presentation_tickets.is_active',
      'presentation_tickets.presentation_date_id',
      'presentation_tickets.name',
      'presentation_tickets.description',
      'presentation_tickets.price',
      'presentation_tickets.capacity',
      'presentation_tickets.sold',
      'presentation_tickets.start_sale',
      'presentation_tickets.end_sale',
    ]);

    $items->with([
      'ticket_type:id,name,description'
    ]);

    $items->where('presentation_tickets.is_active', (bool) ((int) $is_active))->
      where('event_id', $request->event_id);

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
    $item->event_id = Input::toId(data_get($data, 'event_id'));
    $item->presentation_date_id = Input::toId(data_get($data, 'presentation_date_id'));

    $item->name = Input::toUpper(data_get($data, 'name'));
    $item->description = Input::toUpper(data_get($data, 'description'));

    $item->price = Input::toFloat(data_get($data, 'price'));
    $item->max_sale = Input::toInt(data_get($data, 'max_sale'));
    $item->capacity = Input::toInt(data_get($data, 'capacity'));
    $item->start_sale = data_get($data, 'start_sale');
    $item->end_sale = data_get($data, 'end_sale');

    $item->save();

    return $item;
  }

  /**
   * ===========================================
   * CONSULTAS PUBLIC
   * ===========================================
   */
  public static function publicGetItems(Request $request) {

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

    $items->where('presentation_tickets.is_active', 1)->
      where('presentation_date_id', $request->presentation_date_id);

    return $items->get();
  }
}
