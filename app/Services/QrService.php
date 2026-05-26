<?php
namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class QrService
{
  public static function makeEncryptedBase64(string $code, string $prefix = 'ticket'): ?string
  {
    if (trim($code) === '') {
      return null;
    }

    $encrypted = Crypt::encryptString($code);

    $file_name = $prefix . '_' . uniqid() . '.png';
    $disk = Storage::disk('temp');
    $path = $disk->path($file_name);

    try {
      \QrCode::format('png')
        ->size(512)
        ->generate($encrypted, $path);

      if (!file_exists($path)) {
        return null;
      }

      $base64 = base64_encode(file_get_contents($path));

      return 'data:image/png;base64,' . $base64;
    } finally {
      if ($disk->exists($file_name)) {
        $disk->delete($file_name);
      }
    }
  }
}