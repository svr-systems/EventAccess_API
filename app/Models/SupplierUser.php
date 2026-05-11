<?php

namespace App\Models;

use App\Services\StorageMgrService;
use App\Support\DisplayId;
use App\Support\Input;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Validator;

class SupplierUser extends Model {
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

  public function role(): BelongsTo {
    return $this->belongsTo(Role::class, 'role_id');
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
      'supplier_id' => ['required', 'numeric', 'exists:suppliers,id'],
    ];

    $msgs = [
      'supplier_id.required' => 'El proveedor es obligatorio.',
      'supplier_id.numeric' => 'El proveedor debe ser un identificador válido.',
      'supplier_id.exists' => 'El proveedor seleccionado no existe.',
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
    $supplier_user = SupplierUser::getFirstByUser($request->user()->id);

    $items = self::query();

    $items->select([
      'supplier_users.id',
      // 'supplier_users.is_active',
      'supplier_users.supplier_id',
      'supplier_users.user_id',
    ]);

    // $items->where('supplier_users.is_active', (bool) ((int) $is_active));
    $items->where('supplier_users.supplier_id', $supplier_user->supplier_id);

    $items->with([
      'user',
      "user.role:id,name"
    ]);

    return $items->get();
  }

  public static function getItem($id, Request $request = null) {
    $item = self::query();

    $item->select(['supplier_users.*']);

    // $item->with([
    //   'user',
    // ]);

    $item->whereKey((int) $id);

    $item = $item->first();

    if (is_null($item)) {
      return null;
    }

    $item->user = User::getItem($item->user_id);

    $item->user->avatar_b64 = StorageMgrService::getBase64($item->user->avatar_path, 'User');
    $item->user->avatar_doc = null;

    return $item;
  }

  public static function getFirstByUser(int $user_id): ?self {
    return self::query()
      ->where('user_id', $user_id)
      ->first();
  }

  /**
   * ===========================================
   * GUARDADO DE DATOS
   * ===========================================
   */
  public static function saveData(self $item, array $data): self {
    $item->supplier_id = Input::toId(data_get($data, 'supplier_id'));
    $item->user_id = Input::toId(data_get($data, 'user_id'));

    $item->save();

    return $item;
  }
}
