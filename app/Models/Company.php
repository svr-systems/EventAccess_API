<?php

namespace App\Models;

use App\Services\StorageMgrService;
use App\Support\DisplayId;
use App\Support\Input;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\HasApiTokens;

class Company extends Authenticatable {
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * ===========================================
   * CONVERSIONES DE TIPO
   * ===========================================
   */
  protected $casts = [
    'is_active' => 'boolean',
    'created_at' => 'datetime:Y-m-d H:i:s',
    'updated_at' => 'datetime:Y-m-d H:i:s',
  ];

  /**
   * ===========================================
   * ACCESSORES ATRIBUTOS
   * ===========================================
   */
  protected $appends = [
    'display_id',
  ];

  public function created_by(): BelongsTo {
    return $this->belongsTo(User::class, 'created_by_id');
  }

  public function updated_by(): BelongsTo {
    return $this->belongsTo(User::class, 'updated_by_id');
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
      'name' => ['required', 'string', 'min:2', 'max:60'],
      'slug' => ['nullable', 'string', 'min:2', 'max:30'],
      'description' => ['nullable', 'string', 'min:2'],
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
      'companies.id',
      'companies.is_active',
      'companies.name',
      'companies.slug',
      'companies.logo_path',
      'companies.description',
    ]);

    $items->where('companies.is_active', (bool) ((int) $is_active));
    

    if($request->user()->role_id === 3 || $request->user()->role_id === 4){
      $items->join('company_users','company_users.company_id', 'companies.id');
      $items->where('company_users.user_id', $request->user()->id);
    }

    return $items->get();
  }

  public static function getItem($id, Request $request = null) {
    $item = self::query();

    $item->select(['companies.*']);

    $item->with([
      'created_by:id,email',
      'updated_by:id,email',
    ]);

    $item->whereKey((int) $id);

    $item = $item->first();

    if (is_null($item)) {
      return null;
    }

    $item->logo_b64 = StorageMgrService::getBase64($item->logo_path, 'Company');
    $item->logo_doc = null;

    return $item;
  }

  /**
   * ===========================================
   * GUARDADO DE DATOS
   * ===========================================
   */
  public static function saveData(self $item, array $data): self {
    $logo_doc = data_get($data, 'logo_doc');

    $item->name = Input::toUpper(data_get($data, 'name'));
    $item->slug = Input::toUpper(data_get($data, 'slug'));
    $item->description = Input::toUpper(data_get($data, 'description'));
    $item->logo_path = StorageMgrService::syncPath(
      $item->logo_path,
      $logo_doc instanceof UploadedFile ? $logo_doc : null,
      'Company'
    );

    $item->save();

    return $item;
  }
}