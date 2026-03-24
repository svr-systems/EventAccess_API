<?php

namespace App\Models;

use App\Support\DisplayId;
use App\Support\Input;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Validator;

class BuyerUser extends Model {
  public $timestamps = false;

  /**
   * ===========================================
   * CONVERSIONES DE TIPO
   * ===========================================
   */
  protected $casts = [
    'is_active' => 'boolean'
  ];

  /**
   * ===========================================
   * ACCESSORES ATRIBUTOS
   * ===========================================
   */
  protected $appends = [
    'display_id',
  ];

  public function user(): BelongsTo {
    return $this->belongsTo(User::class);
  }

  /**
   * ===========================================
   * ACCESSORES
   * ===========================================
   */
  public function getDisplayIdAttribute(): string {
    return DisplayId::make('U', $this->id, 4);
  }

  /**
   * ===========================================
   * VALIDACIONES
   * ===========================================
   */
  public static function validData(array $data) {
    $rules = [
      'buyer_id' => [
        'required',
        'integer',
        'exists:buyers,id',
      ],

      'user_id' => [
        'required',
        'integer',
        'exists:users,id',
        function ($attribute, $value, $fail) use ($data) {

          // 🔥 Evitar duplicados manualmente (además del unique)
          $exists = DB::table('buyer_users')
            ->where('buyer_id', $data['buyer_id'] ?? null)
            ->where('user_id', $value)
            ->exists();

          if ($exists) {
            $fail('Este usuario ya está asignado a este comprador.');
          }
        }
      ],
    ];

    $msgs = [
      'buyer_id.required' => 'El comprador es obligatorio.',
      'buyer_id.integer' => 'El comprador debe ser un identificador válido.',
      'buyer_id.exists' => 'El comprador seleccionado no existe.',

      'user_id.required' => 'El usuario es obligatorio.',
      'user_id.integer' => 'El usuario debe ser un identificador válido.',
      'user_id.exists' => 'El usuario seleccionado no existe.',
    ];

    return Validator::make($data, $rules, $msgs);
  }

  /**
   * ===========================================
   * CONSULTAS
   * ===========================================
   */
  public static function getItems(Request $request) {
    $is_active = $request->query('is_active', 1);

    $items = self::query();

    $items->select([
      'buyer_users.id',
      // 'buyer_users.is_active',
      'buyer_users.buyer_id',
      'buyer_users.user_id',
    ]);

    // $items->where('buyer_users.is_active', (bool) ((int) $is_active));
    $items->where('buyer_users.buyer_id', $request->buyer_id);

    $items->with([
      'user',
    ]);

    return $items->get();
  }

  public static function getItem($id, Request $request = null) {
    $item = self::query();

    $item->select(['buyer_users.*']);

    $item->with([
      'user',
    ]);

    $item->whereKey((int) $id);

    $item = $item->first();

    if (is_null($item)) {
      return null;
    }

    return $item;
  }

  /**
   * ===========================================
   * GUARDADO DE DATOS
   * ===========================================
   */
  public static function saveData(self $item, array $data): self {
    $item->buyer_id = Input::toId(data_get($data, 'buyer_id'));
    $item->user_id = Input::toId(data_get($data, 'user_id'));

    $item->save();

    return $item;
  }
}
