<?php

namespace App\Models;

use App\Services\StorageMgrService;
use App\Support\DisplayId;
use App\Support\Input;
use App\Support\Person;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * ===========================================
   * OCULTOS
   * ===========================================
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * ===========================================
   * CONVERSIONES DE TIPO
   * ===========================================
   */
  protected $casts = [
    'is_active' => 'boolean',
    'created_at' => 'datetime:Y-m-d H:i:s',
    'updated_at' => 'datetime:Y-m-d H:i:s',
    'email_verified_at' => 'datetime:Y-m-d H:i:s',
    'password_recover_at' => 'datetime:Y-m-d H:i:s',
  ];

  /**
   * ===========================================
   * ACCESSORES ATRIBUTOS
   * ===========================================
   */
  protected $appends = [
    'full_name',
    'display_id',
  ];

  /**
   * ===========================================
   * RELACIONES
   * ===========================================
   */
  public function role(): BelongsTo
  {
    return $this->belongsTo(Role::class);
  }

  public function created_by(): BelongsTo
  {
    return $this->belongsTo(self::class, 'created_by_id');
  }

  public function updated_by(): BelongsTo
  {
    return $this->belongsTo(self::class, 'updated_by_id');
  }

  /**
   * ===========================================
   * ACCESSORES
   * ===========================================
   */
  public function getDisplayIdAttribute(): string
  {
    return DisplayId::make('U', $this->id, 4);
  }

  public function getFullNameAttribute(): string
  {
    return Person::fullName($this);
  }

  /**
   * ===========================================
   * VALIDACIONES
   * ===========================================
   */
  public static function validData(array $data, $roles = '1,2')
  {
    $rules = [
      'name' => ['required', 'string', 'min:2', 'max:50'],
      'paternal_surname' => ['required', 'string', 'min:2', 'max:25'],
      'maternal_surname' => ['nullable', 'string', 'min:2', 'max:25'],
      'phone' => ['nullable', 'string', 'regex:/^\d{10}$/'],
      'avatar_doc' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
    ];

    $rules['role_id'] = ['required', 'in:' . $roles];

    $msgs = [
      'phone.regex' => 'El teléfono debe contener 10 dígitos',
      'avatar_doc.image' => 'La fotografía debe ser una imagen válida',
      'avatar_doc.mimes' => 'La fotografía debe ser JPG o PNG',
      'avatar_doc.max' => 'La fotografía no debe exceder 2MB',
    ];

    return Validator::make($data, $rules, $msgs);
  }

  public static function validEmail(array $data, $id = null)
  {
    $unique = Rule::unique('users', 'email');

    if (!is_null($id)) {
      $unique->ignore((int) $id);
    }

    $rules = [
      'email' => [
        'required',
        'string',
        'min:2',
        'max:65',
        'email:rfc',
        $unique,
      ],
    ];

    $msgs = [
      'email.unique' => 'El E-mail ya ha sido registrado',
      'email.email' => 'Formato de correo inválido',
    ];

    return Validator::make($data, $rules, $msgs);
  }

  public static function validRecoverEmail(array $data)
  {
    return Validator::make($data, [
      'email' => ['required', 'string', 'max:65', 'email:rfc'],
    ], [
      'email.email' => 'Formato de correo inválido',
    ]);
  }

  public static function validPassword(array $data)
  {
    $rules = [
      'password' => [
        'required',
        'string',
        'min:8',
        'max:20',
        'regex:/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@$%*])/',
      ],
    ];

    $msgs = [
      'password.regex' => 'La contraseña no cumple con el formato requerido',
    ];

    return Validator::make($data, $rules, $msgs);
  }

  /**
   * ===========================================
   * CONSULTAS
   * ===========================================
   */
  public static function getItems(Request $request)
  {
    $is_active = $request->query('is_active', 1);

    $items = self::query();

    $items->select([
      'users.id',
      'users.is_active',
      'users.role_id',
      'users.name',
      'users.paternal_surname',
      'users.maternal_surname',
      'users.email',
      'users.email_verified_at',
    ]);

    $items->with(['role:id,name']);

    if ($is_active !== null && $is_active !== '') {
      $items->where('users.is_active', (bool) ((int) $is_active));
    }

    $items
      ->orderBy('users.name')
      ->orderBy('users.paternal_surname')
      ->orderBy('users.maternal_surname');

    return $items->get();
  }

  public static function getItem($id, Request $request = null)
  {
    $item = self::query();

    $item->select(['users.*']);

    $item->with([
      'role:id,name',
      'created_by:id,email',
      'updated_by:id,email',
    ]);

    $item->whereKey((int) $id);

    $item = $item->first();

    if (is_null($item)) {
      return null;
    }

    $item->avatar_b64 = StorageMgrService::getBase64($item->avatar_path, 'User');
    $item->avatar_doc = null;

    return $item;
  }

  /**
   * ===========================================
   * GUARDADO DE DATOS
   * ===========================================
   */
  public static function saveData(self $item, array $data): self
  {
    $avatar_doc = data_get($data, 'avatar_doc');

    $item->role_id = Input::toId(data_get($data, 'role_id'));
    $item->name = Input::toUpper(data_get($data, 'name'));
    $item->paternal_surname = Input::toUpper(data_get($data, 'paternal_surname'));
    $item->maternal_surname = Input::toUpper(data_get($data, 'maternal_surname'));
    $item->email = Input::toLower(data_get($data, 'email'));
    $item->phone = Input::trimOrNull(data_get($data, 'phone'));
    $item->avatar_path = StorageMgrService::syncPath(
      $item->avatar_path,
      $avatar_doc instanceof UploadedFile ? $avatar_doc : null,
      'User'
    );

    $item->save();

    return $item;
  }

  /**
   * ===========================================
   * FUNCIONES ESPECÍFICAS
   * ===========================================
   */
  public static function getItemByEmail($email, Request $request = null)
  {
    $item = self::query();

    $item->select(['users.*']);

    $item->with([
      'role:id,name',
      'created_by:id,email',
      'updated_by:id,email',
    ]);

    $item->where('users.email', (string) $email);

    return $item->first();
  }
}