<?php

namespace App\Services;

use App\Catalogs\OpenpayErrorCatalog;
use App\Support\Input;
use Openpay\Data\Openpay;
use Throwable;

class OpenpayService {

  public static function payment(array $charge_data): array {
    try {
      $openpay = Openpay::getInstance(
        config('services.openpay.merchant_id'),
        config('services.openpay.private_key'),
        config('services.openpay.country', 'MX'),
        config('services.openpay.ip', '127.0.0.1')
      );

      $charge = $openpay->charges->create($charge_data);

      return [
        'success' => true,
        'charge' => $charge,
      ];

    } catch (Throwable $e) {
      $error_code = method_exists($e, 'getErrorCode')
        ? (int) $e->getErrorCode()
        : null;

      $error = OpenpayErrorCatalog::get($error_code);

      if (!$error) {
        return [
          'success' => false,
          'is_openpay_error' => true,
          'http_code' => 500,
          'message' => 'No fue posible procesar el pago. Inténtelo nuevamente. ' . $e,
          'error_code' => $error_code,
          'exception' => $e,
        ];
      }

      return [
        'success' => false,
        'is_openpay_error' => false,
        'http_code' => $error['http_code'],
        'message' => $error['message'],
        'error_code' => $error_code,
        'exception' => $e,
      ];
    }
  }

  public static function getCustomer($user, $request): array {
    return [
      'name' => $request->name,
      'last_name' => $request->last_name,
      'phone_number' => $user->phone,
      'email' => $user->email,
    ];
  }

  public static function getChargeData($customer, $data): array {
    $charge_data = [
      'method' => 'card',
      'source_id' => $data->token_id,
      'amount' => $data->price,
      'description' => $data->description,
      'use_card_points' => $data->use_card_points,
      'device_session_id' => $data->device_session_id,
      'customer' => $customer,
      'use_3d_secure' => false,
    ];

    $secure_amount = Input::toFloat(config('services.openpay.three_d_secure_amount'));

    if ($secure_amount && $data->price > $secure_amount) {
      $charge_data['use_3d_secure'] = true;
      $charge_data['redirect_url'] = config('app.front_url') . 'proveedor/pago_exitoso';
    }

    return $charge_data;
  }

  public static function getCharge($openpay_id) {
    $openpay = Openpay::getInstance(
      config('services.openpay.merchant_id'),
      config('services.openpay.private_key'),
      config('services.openpay.country', 'MX'),
      config('services.openpay.ip', '127.0.0.1')
    );

    return $openpay->charges->get($openpay_id);
  }
}