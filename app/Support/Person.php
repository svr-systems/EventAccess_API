<?php

namespace App\Support;

class Person
{
  public static function fullName(array|object|null $data): string
  {
    $name = self::get($data, 'name');
    $paternal_surname = self::get($data, 'paternal_surname');
    $maternal_surname = self::get($data, 'maternal_surname');

    $parts = array_filter([$name, $paternal_surname, $maternal_surname], fn($v) => $v !== '');

    return implode(' ', $parts);
  }

  private static function get(array|object|null $data, string $key): string
  {
    if (is_null($data)) {
      return '';
    }

    $val = is_array($data)
      ? ($data[$key] ?? '')
      : ($data->{$key} ?? '');

    return trim((string) $val);
  }
}