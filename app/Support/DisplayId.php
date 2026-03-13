<?php

namespace App\Support;

class DisplayId
{
  public static function make(string $prefix, int|string|null $id, int $pad = 4): string
  {
    $n = (int) ($id ?? 0);
    return $prefix . '-' . str_pad((string) $n, $pad, '0', STR_PAD_LEFT);
  }
}