<?php

namespace App\Models;

use App\Support\DisplayId;
use App\Support\Input;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Http\Request;
use Validator;

class CompanyUser extends Model {
  use HasApiTokens, HasFactory, Notifiable;

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
      'company_id' => ['required', 'numeric'],
    ];

    $msgs = [
      //   'phone.regex' => 'El teléfono debe contener 10 dígitos',
      //   'logo_doc.image' => 'La fotografía debe ser una imagen válida',
      //   'logo_doc.mimes' => 'La fotografía debe ser JPG o PNG',
      //   'logo_doc.max' => 'La fotografía no debe exceder 2MB',
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
      'company_users.id',
      'company_users.is_active',
      'company_users.company_id',
      'company_users.user_id',
    ]);

    $items->where('company_users.is_active', (bool) ((int) $is_active));
    $items->where('company_users.company_id', $request->company_id);

    $items->with([
      'user',
    ]);

    return $items->get();
  }

  public static function getItem($id, Request $request = null) {
    $item = self::query();

    $item->select(['company_users.*']);

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
    $item->company_id = Input::toId(data_get($data, 'company_id'));
    $item->user_id = Input::toId(data_get($data, 'user_id'));

    $item->save();

    return $item;
  }
}
