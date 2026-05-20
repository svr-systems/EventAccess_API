<?php

namespace App\Models;

use App\Models\Traits\HasAuditFields;
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
  use HasApiTokens, HasFactory, Notifiable, HasAuditFields;

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
      'slug' => ['nullable', 'string', 'min:2', 'max:30', 'unique:companies,slug'],

      'description' => ['nullable', 'string', 'min:2'],
    ];

    $msgs = [
      'name.required' => 'El nombre es obligatorio',
      'name.max' => 'El nombre no puede tener más de 60 caracteres',

      'slug.unique' => 'El identificador de la compañía ya está en uso',
    ];

    return Validator::make($data, $rules, $msgs);
  }
  public static function validCompanyData(array $data) {
    $rules = [
      'name' => ['required', 'string', 'min:2', 'max:60'],
      'slug' => ['nullable', 'string', 'min:2', 'max:30', 'unique:companies,slug'],

      'description' => ['nullable', 'string', 'min:2'],

      'fiscal_code' => ['required', 'string', 'min:12', 'max:13'],
      'fiscal_name' => ['required', 'string', 'min:2', 'max:75'],
      'fiscal_zip' => ['required', 'string', 'size:5'],

      'fiscal_regime_id' => ['required', 'integer', 'exists:fiscal_regimes,id'],
      'cfdi_usage_id' => ['required', 'integer', 'exists:cfdi_usages,id'],
    ];

    $msgs = [
      'name.required' => 'El nombre es obligatorio',
      'name.max' => 'El nombre no puede tener más de 60 caracteres',

      'slug.unique' => 'El identificador de la compañía ya está en uso',

      'fiscal_code' => 'El nombre es obligatorio',
      'fiscal_code.min' => 'El RFC debe tener al menos 12 caracteres',
      'fiscal_code.max' => 'El RFC no puede tener más de 13 caracteres',

      'fiscal_name.required' => 'El nombre es obligatorio',
      'fiscal_name.max' => 'La razón social no puede tener más de 75 caracteres',

      'fiscal_zip.required' => 'El nombre es obligatorio',
      'fiscal_zip.size' => 'El código postal fiscal debe tener 5 dígitos',

      'fiscal_regime_id.required' => 'El nombre es obligatorio',
      'fiscal_regime_id.exists' => 'El régimen fiscal seleccionado no existe',
      'cfdi_usage_id.required' => 'El nombre es obligatorio',
      'cfdi_usage_id.exists' => 'El uso de CFDI seleccionado no existe',
    ];

    return Validator::make($data, $rules, $msgs);
  }
  public static function validCertificateData(array $data) {
    $rules = [
      'cer_doc' => ['required', 'file', 'max:2048'],
      'key_doc' => ['required', 'file', 'max:2048'],
      'password' => ['required', 'string', 'max:255'],
    ];

    $msgs = [
      'cer_doc.required' => 'El nombre es obligatorio',
      'cer_doc.file' => 'El certificado debe ser un archivo válido',
      // 'cer_doc.mimes' => 'El certificado debe ser un archivo .cer',
      'cer_doc.max' => 'El certificado no debe exceder 2MB',

      'key_doc.required' => 'El nombre es obligatorio',
      'key_doc.file' => 'La llave privada debe ser un archivo válido',
      // 'key_doc.mimes' => 'La llave privada debe ser un archivo .key',
      'key_doc.max' => 'La llave privada no debe exceder 2MB',

      'password.required' => 'El nombre es obligatorio',
      'password.string' => 'La contraseña del certificado debe ser texto',
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
      'companies.fiscal_code',
      'companies.fiscal_name',
      'companies.fiscal_zip',
      'companies.fiscal_regime_id',
      'companies.cfdi_usage_id',
      'companies.fiscal_organization_id',
      'companies.fiscal_certificate_updated_at',
      'companies.fiscal_certificate_expires_at',
      'companies.fiscal_certificate_serial_number',
    ]);

    $items->where('companies.is_active', (bool) ((int) $is_active));


    if ($request->user()->role_id === 3 || $request->user()->role_id === 4) {
      $items->join('company_users', 'company_users.company_id', 'companies.id');
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
    $item->commission_percentage = Input::toFloat(data_get($data, 'commission_percentage'));
    $item->logo_path = StorageMgrService::syncPath(
      $item->logo_path,
      $logo_doc instanceof UploadedFile ? $logo_doc : null,
      'Company'
    );

    $item->save();

    return $item;
  }

  public static function saveCompanyData(self $item, array $data): self {
    $logo_doc = data_get($data, 'logo_doc');

    $item->name = Input::toUpper(data_get($data, 'name'));
    $item->slug = Input::toUpper(data_get($data, 'slug'));
    $item->description = Input::toUpper(data_get($data, 'description'));

    $item->fiscal_code = Input::toUpper(data_get($data, 'fiscal_code'));
    $item->fiscal_name = Input::toUpper(data_get($data, 'fiscal_name'));
    $item->fiscal_zip = Input::onlyDigitsOrNull(data_get($data, 'fiscal_zip'), 5);

    $item->fiscal_regime_id = Input::toId(data_get($data, 'fiscal_regime_id'));
    $item->cfdi_usage_id = Input::toId(data_get($data, 'cfdi_usage_id'));

    $item->fiscal_organization_id = Input::trimOrNull(data_get($data, 'fiscal_organization_id'));

    $item->logo_path = StorageMgrService::syncPath(
      $item->logo_path,
      $logo_doc instanceof UploadedFile ? $logo_doc : null,
      'Company'
    );

    $item->save();

    return $item;
  }

  //COMAPANY

  public static function getCompanyItem(Request $request = null) {

    $company_user = CompanyUser::getFirstByUser($request->user()->id);
    $item = self::query();

    $item->select(['companies.*']);

    $item->with([
      'created_by:id,email',
      'updated_by:id,email',
    ]);

    $item->whereKey((int) $company_user->company_id);

    $item = $item->first();

    if (is_null($item)) {
      return null;
    }

    $item->logo_b64 = StorageMgrService::getBase64($item->logo_path, 'Company');
    $item->logo_doc = null;

    return $item;
  }

}