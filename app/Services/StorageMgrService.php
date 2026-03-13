<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StorageMgrService
{
  public static function syncPath(?string $current_path, ?UploadedFile $upload, string $disk_name): ?string
  {
    $disk = Storage::disk($disk_name);

    if ($upload) {
      $name = self::makeStoredName($upload);

      $disk->putFileAs('', $upload, $name);

      if (!is_null($current_path)) {
        $disk->delete($current_path);
      }

      return $name;
    }

    if (!is_null($current_path)) {
      $disk->delete($current_path);
    }

    return null;
  }

  private static function makeStoredName(UploadedFile $upload, int $len = 40): string
  {
    $ext = strtolower($upload->getClientOriginalExtension() ?: $upload->extension() ?: 'bin');
    return Str::random($len) . '.' . $ext;
  }

  public static function getBase64(?string $stored_name, string $disk_name): ?array
  {
    $stored_name = trim((string) $stored_name);

    if ($stored_name === '') {
      return null;
    }

    $disk = Storage::disk($disk_name);

    if (!$disk->exists($stored_name)) {
      return null;
    }

    $content = $disk->get($stored_name);

    if ($content === false || $content === '') {
      return null;
    }

    $ext = strtolower(pathinfo($stored_name, PATHINFO_EXTENSION));
    $mime = (string) ($disk->mimeType($stored_name) ?? '');

    return [
      'content' => base64_encode($content),
      'mime' => $mime !== '' ? $mime : null,
      'name' => $stored_name,
      'ext' => $ext !== '' ? $ext : null,
    ];
  }
}