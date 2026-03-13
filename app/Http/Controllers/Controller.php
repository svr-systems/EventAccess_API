<?php

namespace App\Http\Controllers;

use Throwable;

abstract class Controller
{
  public function apiRsp($code, $msg, $data = null)
  {
    $ok = $code == 200 || $code == 201;
    $msg_err_def = 'Error. Contacte al equipo de soporte técnico';

    return response()->json([
      'msg' => is_null($msg) && !$ok ? $msg_err_def : $msg,
      'data' => !$ok && !is_null($data) ? "Message:\n" . $data->getMessage() . "\n\n" . "Trace:\n" . $data->getTraceAsString() : $data,
    ], $code);
  }

  public function rsp(int $status_code, ?string $message, $data = null, ?array $errors = null)
  {
    $is_success = in_array($status_code, [200, 201], true);
    $default_error_msg = 'Error. Contacte al equipo de soporte técnico';
    $is_debug = (bool) config('app.debug');

    $payload_message = (!$is_success && is_null($message))
      ? $default_error_msg
      : $message;

    $payload_data = $data;

    if (!$is_success && $data instanceof Throwable) {
      $payload_data = $is_debug
        ? "Message:\n{$data->getMessage()}\n\nTrace:\n{$data->getTraceAsString()}"
        : null;
    }

    $payload = [
      'message' => $payload_message,
      'data' => $payload_data,
    ];

    if (!is_null($errors)) {
      $payload['errors'] = $errors;
    }

    return response()->json($payload, $status_code);
  }
}
