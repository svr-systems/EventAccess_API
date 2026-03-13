<?php

namespace App\Support;

class Input
{
  public static function trimOrNull($val): ?string
  {
    $v = trim((string) $val);

    if ($v === '' || self::isNullLike($v)) {
      return null;
    }

    return $v;
  }

  public static function toLower($val): ?string
  {
    $v = self::trimOrNull($val);

    return is_null($v) ? null : mb_strtolower($v, 'UTF-8');
  }

  public static function toUpper($val): ?string
  {
    $v = self::trimOrNull($val);

    return is_null($v) ? null : mb_strtoupper($v, 'UTF-8');
  }

  public static function toId($val): ?int
  {
    $v = self::trimOrNull($val);

    if (is_null($v)) {
      return null;
    }

    $id = (int) $v;

    return $id > 0 ? $id : null;
  }

  public static function toInt($val, int $default = 0): int
  {
    $v = self::trimOrNull($val);

    return is_null($v) ? $default : (int) $v;
  }

  public static function toFloat($val, float $default = 0.0): float
  {
    $v = self::trimOrNull($val);

    return is_null($v) ? $default : (float) $v;
  }

  public static function toBool($val, bool $nullable = false): ?bool
  {
    if (is_null($val)) {
      return $nullable ? null : false;
    }

    $v = mb_strtolower(trim((string) $val), 'UTF-8');

    if ($v === '' || self::isNullLike($v) || $v === 'undefined') {
      return $nullable ? null : false;
    }

    return in_array($v, ['1', 'true', 'yes', 'y', 'on'], true);
  }

  public static function toText($val): ?string
  {
    if (is_null($val)) {
      return null;
    }

    $v = trim((string) $val);

    if ($v === '') {
      return null;
    }

    $v_l = mb_strtolower($v, 'UTF-8');

    return ($v_l === 'null' || $v_l === 'undefined') ? null : $v;
  }

  public static function isEmpty($val): bool
  {
    return is_null(self::toText($val));
  }

  private static function isNullLike(string $v): bool
  {
    return mb_strtolower(trim($v), 'UTF-8') === 'null';
  }
}