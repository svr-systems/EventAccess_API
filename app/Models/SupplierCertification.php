<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierCertification extends Model {
  
  public function certification(): BelongsTo {
    return $this->belongsTo(Certification::class, 'certification_id');
  }
  public $timestamps = false;

  public static function deactivateBySupplier(int $supplier_id): int {
    return self::query()
      ->where('supplier_id', $supplier_id)
      ->where('is_active', true)
      ->update([
        'is_active' => false,
      ]);
  }
}
