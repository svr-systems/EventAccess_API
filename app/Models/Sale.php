<?php

namespace App\Models;

use App\Models\Traits\HasAuditFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Validator;

class Sale extends Model {
  use HasAuditFields;

  public static function validPaymentData(array $data, int $user_id) {

    return Validator::make($data, [
      'sale_id' => [
        'required',
        'integer',
        Rule::exists('sales', 'id')
          ->where(function ($query) use ($user_id) {
            $query->where('user_id', $user_id)
              ->where('is_active', true);
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
      'sale_id.required' => 'La venta es obligatoria.',
      'sale_id.integer' => 'La venta no es válida.',
      'sale_id.exists' => 'La venta no existe.',

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
}
