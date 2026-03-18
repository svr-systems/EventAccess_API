<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Auth;

trait HasAuditFields {
  public static function bootHasAuditFields() {
    static::creating(function ($model) {
      if (Auth::check()) {
        $model->created_by_id = Auth::id();
        $model->updated_by_id = Auth::id();
      }
    });

    static::updating(function ($model) {
      if (Auth::check()) {
        $model->updated_by_id = Auth::id();
      }
    });
  }
}