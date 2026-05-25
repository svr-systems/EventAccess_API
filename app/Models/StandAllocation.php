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
use Illuminate\Validation\Rule;

class StandAllocation extends Model {
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

  public function transaction() {
    return $this->belongsTo(Transaction::class);
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
      'stand_request_id' => [
        'required',
        'integer',
        'exists:stand_requests,id',
        function ($attribute, $value, $fail) {

          $request = DB::table('stand_requests')->where('id', $value)->first();

          if (!$request) {
            $fail('La solicitud no existe.');
            return;
          }

          // 🔥 Debe estar aprobada
          if ($request->is_approved !== 1) {
            $fail('La solicitud no está aprobada.');
          }
        }
      ],

      'event_id' => ['required', 'integer', 'exists:events,id'],

      'supplier_id' => ['required', 'integer', 'exists:suppliers,id'],

      'event_stand_config_id' => [
        'required',
        'integer',
        'exists:event_stand_configs,id',
      ]
    ];

    $msgs = [
      'stand_request_id.required' => 'La solicitud es obligatoria.',
      'stand_request_id.integer' => 'La solicitud debe ser un identificador válido.',
      'stand_request_id.exists' => 'La solicitud no existe.',

      'event_id.required' => 'El evento es obligatorio.',
      'event_id.integer' => 'El evento debe ser un identificador válido.',
      'event_id.exists' => 'El evento seleccionado no existe.',

      'supplier_id.required' => 'El proveedor es obligatorio.',
      'supplier_id.integer' => 'El proveedor debe ser un identificador válido.',
      'supplier_id.exists' => 'El proveedor seleccionado no existe.',

      'event_stand_config_id.required' => 'El stand asignado es obligatorio.',
      'event_stand_config_id.integer' => 'El stand asignado debe ser un identificador válido.',
      'event_stand_config_id.exists' => 'El stand asignado no existe.',
    ];

    // 🔥 Validaciones de coherencia cruzada
    $validator = Validator::make($data, $rules, $msgs);

    $validator->after(function ($validator) use ($data) {

      $request = DB::table('stand_requests')
        ->where('id', $data['stand_request_id'] ?? null)
        ->first();

      if (!$request)
        return;

      // 🔥 Validar coherencia con request
      if (
        $request->event_id != ($data['event_id'] ?? null) ||
        $request->supplier_id != ($data['supplier_id'] ?? null) ||
        $request->event_stand_config_id != ($data['event_stand_config_id'] ?? null)
      ) {
        $validator->errors()->add('stand_request_id', 'Los datos no coinciden con la solicitud.');
      }

      // 🔥 Evitar doble asignación
      $exists = DB::table('stand_allocations')
        ->where('stand_request_id', $data['stand_request_id'])
        ->exists();

      if ($exists) {
        $validator->errors()->add('stand_request_id', 'Esta solicitud ya tiene un stand asignado.');
      }

    });

    return $validator;
  }


  public static function validPaymentData(array $data, int $user_id) {
    $supplier_user = SupplierUser::getFirstByUser($user_id);

    $supplier_id = $supplier_user?->supplier_id;

    return Validator::make($data, [
      'stand_request_id' => [
        'required',
        'integer',
        Rule::exists('stand_requests', 'id')
          ->where(function ($query) use ($supplier_id) {
            $query->where('supplier_id', $supplier_id)
              ->where('is_active', true)
              ->where('is_approved', true);
          }),
      ],

      'token_id' => [
        'required',
        'string',
        'max:255',
      ],

      'device_session_id' => [
        'required',
        'string',
        'max:255',
      ],

      'use_card_points' => [
        'nullable',
        'boolean',
      ],

      'name' => [
        'required',
        'string',
        'max:100',
      ],

      'last_name' => [
        'required',
        'string',
        'max:100',
      ],
    ], [
      'stand_request_id.required' => 'La solicitud de stand es obligatoria.',
      'stand_request_id.integer' => 'La solicitud de stand no es válida.',
      'stand_request_id.exists' => 'La solicitud de stand no existe.',

      'token_id.required' => 'El token de pago es obligatorio.',
      'token_id.string' => 'El token de pago no es válido.',
      'token_id.max' => 'El token de pago no debe exceder los 255 caracteres.',

      'device_session_id.required' => 'El identificador de sesión del dispositivo es obligatorio.',
      'device_session_id.string' => 'El identificador de sesión del dispositivo no es válido.',
      'device_session_id.max' => 'El identificador de sesión del dispositivo no debe exceder los 255 caracteres.',

      'use_card_points.boolean' => 'El uso de puntos no es válido.',

      'name.required' => 'El nombre es obligatorio.',
      'name.string' => 'El nombre no es válido.',
      'name.max' => 'El nombre no debe exceder los 100 caracteres.',

      'last_name.required' => 'El apellido es obligatorio.',
      'last_name.string' => 'El apellido no es válido.',
      'last_name.max' => 'El apellido no debe exceder los 100 caracteres.',
    ]);
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
      'stand_allocations.id',
      'stand_allocations.is_active',
      'stand_allocations.stand_request_id',
      'stand_allocations.event_id',
      'stand_allocations.supplier_id',
      'stand_allocations.event_stand_config_id',
      'stand_allocations.is_paid',
    ]);

    $items->where('stand_allocations.is_active', (bool) ((int) $is_active))->
      where('stand_allocations.event_id', $request->event_id)->
      where('stand_allocations.supplier_id', $request->supplier_id);

    return $items->get();
  }

  public static function getItem($id, Request $request = null) {
    $item = self::query();

    $item->select(['stand_allocations.*']);

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

  public static function getStandAllocationValid($stand_request_id) {
    $item = self::query();

    $item->select(['stand_allocations.*']);

    $item->where('stand_request_id', $stand_request_id)->
      where('is_active', true)->
      where('is_paid', true);

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
  public static function saveData(self $item, array $data, $status = false): self {

    $item->stand_request_id = Input::toId(data_get($data, 'id'));
    $item->event_id = Input::toId(data_get($data, 'event_id'));
    $item->supplier_id = Input::toId(data_get($data, 'supplier_id'));
    $item->event_stand_config_id = Input::toId(data_get($data, 'event_stand_config_id'));
    $item->is_paid = Input::toBool($status);
    $item->save();

    return $item;
  }

  /**
   * ===========================================
   * CONSULTAS COMPANY
   * ===========================================
   */
  public static function getCompanyItems(Request $request) {

    $supplier_user = SupplierUser::getFirstByUser($request->user()->id);

    $items = self::query();

    $items->select([
      'stand_allocations.id',
      'stand_allocations.is_active',
      'stand_allocations.stand_request_id',
      'stand_allocations.event_id',
      'stand_allocations.supplier_id',
      'stand_allocations.event_stand_config_id',
      'stand_allocations.is_paid',
    ]);

    $items->where('stand_allocations.is_active', 1)->
      where('stand_allocations.supplier_id', $supplier_user->supplier_id)->
      where('stand_allocations.event_id', $request->event_id);

    return $items->get();
  }

  public static function getCompanyItem($id, Request $request = null) {
    $item = self::query();

    $item->select(['stand_allocations.*']);

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
}
