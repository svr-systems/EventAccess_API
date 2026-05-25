<?php

namespace App\Catalogs;

class OpenpayErrorCatalog {
  public static function get(?int $error_code): ?array {
    return match ($error_code) {
      // Generales
      1000 => [
        'http_code' => 500,
        'message' => 'Ocurrió un error interno en Openpay. Inténtelo más tarde.',
      ],
      1001 => [
        'http_code' => 400,
        'message' => 'Los datos enviados para el pago no tienen el formato correcto.',
      ],
      1002 => [
        'http_code' => 401,
        'message' => 'No fue posible autenticar la operación con Openpay.',
      ],
      1003 => [
        'http_code' => 422,
        'message' => 'Uno o más datos del pago no son correctos.',
      ],
      1004 => [
        'http_code' => 503,
        'message' => 'El servicio de pagos no está disponible temporalmente. Inténtelo más tarde.',
      ],
      1005 => [
        'http_code' => 404,
        'message' => 'No se encontró uno de los recursos necesarios para procesar el pago.',
      ],
      1006 => [
        'http_code' => 409,
        'message' => 'Ya existe una transacción con el mismo identificador.',
      ],
      1007 => [
        'http_code' => 402,
        'message' => 'La operación no fue aceptada por la institución financiera.',
      ],
      1008 => [
        'http_code' => 423,
        'message' => 'Una de las cuentas requeridas se encuentra desactivada.',
      ],
      1009 => [
        'http_code' => 413,
        'message' => 'La información enviada para el pago es demasiado grande.',
      ],
      1010 => [
        'http_code' => 403,
        'message' => 'La operación no tiene permisos suficientes para realizarse.',
      ],

      // Almacenamiento
      2001 => [
        'http_code' => 409,
        'message' => 'La cuenta bancaria ya se encuentra registrada.',
      ],
      2002 => [
        'http_code' => 409,
        'message' => 'La tarjeta ya se encuentra registrada.',
      ],
      2003 => [
        'http_code' => 409,
        'message' => 'El cliente ya se encuentra registrado.',
      ],
      2004 => [
        'http_code' => 422,
        'message' => 'El número de tarjeta no es válido.',
      ],
      2005 => [
        'http_code' => 400,
        'message' => 'La tarjeta se encuentra expirada.',
      ],
      2006 => [
        'http_code' => 400,
        'message' => 'El código de seguridad de la tarjeta es obligatorio.',
      ],
      2007 => [
        'http_code' => 412,
        'message' => 'La tarjeta de prueba solo puede usarse en ambiente Sandbox.',
      ],
      2008 => [
        'http_code' => 412,
        'message' => 'La tarjeta no es válida para puntos.',
      ],
      2009 => [
        'http_code' => 412,
        'message' => 'El código de seguridad de la tarjeta no es válido.',
      ],

      // Tarjetas
      3001 => [
        'http_code' => 422,
        'message' => 'La tarjeta fue declinada.',
      ],
      3002 => [
        'http_code' => 422,
        'message' => 'La tarjeta ha expirado.',
      ],
      3003 => [
        'http_code' => 422,
        'message' => 'La tarjeta no tiene fondos suficientes.',
      ],
      3004 => [
        'http_code' => 422,
        'message' => 'Tarjeta declinada.',
      ],
      3005 => [
        'http_code' => 422,
        'message' => 'Tarjeta declinada.',
      ],
      3006 => [
        'http_code' => 422,
        'message' => 'La operación no está permitida para este cliente o transacción.',
      ],
      3008 => [
        'http_code' => 422,
        'message' => 'La tarjeta no es soportada para transacciones en línea.',
      ],
      3009 => [
        'http_code' => 422,
        'message' => 'Tarjeta declinada.',
      ],
      3010 => [
        'http_code' => 422,
        'message' => 'El banco ha restringido la tarjeta.',
      ],
      3011 => [
        'http_code' => 422,
        'message' => 'El banco solicitó retener la tarjeta. Contacte a su banco.',
      ],
      3012 => [
        'http_code' => 422,
        'message' => 'Se requiere autorización del banco para realizar este pago.',
      ],

      // Cuentas
      4001 => [
        'http_code' => 422,
        'message' => 'La cuenta de Openpay no tiene fondos suficientes.',
      ],

      default => null,
    };
  }

  public static function default(): array {
    return [
      'http_code' => 500,
      'message' => 'Transacción fallida. Comuníquese con su banco, verifique sus datos e inténtelo nuevamente.',
    ];
  }
}