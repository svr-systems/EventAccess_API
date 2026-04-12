<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Municipality extends Model {
  use HasFactory;
  public $timestamps = false;

  public function state(): BelongsTo {
    return $this->belongsTo(State::class, 'state_id');
  }

  static public function getItems($req) {
    $items = Municipality::
      where('is_active', true)->
      where('state_id', $req->state_id)->
      orderBy("name")->
      get();

    return $items;
  }
}
