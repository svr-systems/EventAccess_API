<?php

namespace App\Models;

use App\Services\StorageMgrService;
use App\Support\DisplayId;
use App\Support\Input;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Validator;

class Supplier extends Model {
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

  public function supplier_certifications(): HasMany {
    return $this->hasMany(SupplierCertification::class, 'supplier_id')
      ->where('is_active', true);
  }

  public function municipality(): BelongsTo {
    return $this->belongsTo(Municipality::class, 'municipality_id');
  }

  /**
   * ===========================================
   * ACCESSORES
   * ===========================================
   */
  public function getDisplayIdAttribute(): string {
    return DisplayId::make('U', $this->id, 4);
  }

  public function appendLogoBase64() {
    $this->logo_b64 = StorageMgrService::getBase64($this->logo_path, 'Supplier');

    return $this;
  }

  /**
   * ===========================================
   * VALIDACIONES
   * ===========================================
   */
  public static function validData(array $data) {
    $rules = [
      'name' => ['required', 'string', 'min:2', 'max:100'],

      // 'logo_path' => ['nullable', 'string', 'max:50'],
      'phone' => ['nullable', 'regex:/^\d{10}$/'],
      'website_url' => ['nullable', 'url', 'max:150'],
      'description' => ['nullable', 'string'],

      'address' => ['required', 'string', 'max:150'],
      'municipality_id' => ['required', 'exists:municipalities,id'],
      'zip' => ['required', 'regex:/^\d{5}$/'],

      'fiscal_code' => ['required', 'regex:/^[A-ZÑ&]{3,4}\d{6}[A-Z0-9]{3}$/i'],
      'fiscal_name' => ['required', 'string', 'max:150'],
      'fiscal_zip' => ['required', 'regex:/^\d{5}$/'],

      'fiscal_regime_id' => ['required', 'exists:fiscal_regimes,id'],
      'cfdi_usage_id' => ['required', 'exists:cfdi_usages,id'],

      // 'tax_certificate_path' => ['nullable', 'string', 'max:50'],
      // 'positive_opinion_path' => ['nullable', 'string', 'max:50'],
    ];

    $msgs = [
      'name.required' => 'El nombre es obligatorio.',
      'name.string' => 'El nombre debe ser un texto válido.',
      'name.min' => 'El nombre debe tener al menos 2 caracteres.',
      'name.max' => 'El nombre no puede tener más de 100 caracteres.',

      // 'logo_path.string' => 'El logotipo debe ser una ruta válida.',
      // 'logo_path.max' => 'El logotipo no puede exceder 50 caracteres.',

      'phone.regex' => 'El teléfono debe contener exactamente 10 dígitos.',

      'website_url.url' => 'El sitio web debe ser una URL válida.',
      'website_url.max' => 'El sitio web no puede exceder 150 caracteres.',

      'description.string' => 'La descripción debe ser un texto válido.',

      'address.string' => 'La dirección debe ser un texto válido.',
      'address.max' => 'La dirección no puede exceder 150 caracteres.',

      'municipality_id.exists' => 'El municipio seleccionado no es válido.',

      'zip.regex' => 'El código postal debe contener exactamente 5 dígitos.',

      'fiscal_code.string' => 'El RFC debe ser un texto válido.',
      'fiscal_code.size' => 'El RFC debe tener exactamente 13 caracteres.',
      'fiscal_code.regex' => 'El RFC no tiene un formato válido.',

      'fiscal_name.string' => 'La razón social debe ser un texto válido.',
      'fiscal_name.max' => 'La razón social no puede exceder 150 caracteres.',

      'fiscal_zip.regex' => 'El código postal fiscal debe contener exactamente 5 dígitos.',

      'fiscal_regime_id.exists' => 'El régimen fiscal seleccionado no es válido.',
      'cfdi_usage_id.exists' => 'El uso de CFDI seleccionado no es válido.',

      // 'tax_certificate_path.string' => 'La constancia fiscal debe ser una ruta válida.',
      // 'tax_certificate_path.max' => 'La constancia fiscal no puede exceder 50 caracteres.',

      // 'positive_opinion_path.string' => 'La opinión positiva debe ser una ruta válida.',
      // 'positive_opinion_path.max' => 'La opinión positiva no puede exceder 50 caracteres.',
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

    $items->select(['suppliers.*']);

    $items->where('suppliers.is_active', (bool) ((int) $is_active));


    // if ($request->user()->role_id === 3 || $request->user()->role_id === 4) {
    $items->join('supplier_users', 'supplier_users.supplier_id', 'suppliers.id');
    $items->where('supplier_users.user_id', $request->user()->id);
    // }

    return $items->get();
  }

  public static function getItem(Request $request) {
    $item = self::query();

    $item->select(['suppliers.*']);

    $item->with([
      'created_by:id,email',
      'updated_by:id,email',
      'supplier_certifications:id,supplier_id,is_active,certification_id',
      'municipality:id,name,state_id',
      'municipality.state:id,name',
    ]);

    $item->join('supplier_users', 'supplier_users.supplier_id', 'suppliers.id');

    $item->where('supplier_users.user_id', '=', $request->user()->id);

    $item = $item->first();

    if (is_null($item)) {
      return null;
    }


    $item->tax_certificate_b64 = StorageMgrService::getBase64($item->tax_certificate_path, 'Supplier');
    $item->tax_certificate_doc = null;

    $item->positive_opinion_b64 = StorageMgrService::getBase64($item->positive_opinion_path, 'Supplier');
    $item->positive_opinion_doc = null;

    return $item;
  }

  /**
   * ===========================================
   * GUARDADO DE DATOS
   * ===========================================
   */
  public static function saveData(self $item, array $data): self {
    $logo_doc = data_get($data, 'logo_doc');
    $tax_certificate_doc = data_get($data, 'tax_certificate_doc');
    $positive_opinion_doc = data_get($data, 'positive_opinion_doc');

    $item->name = Input::toUpper(data_get($data, 'name'));

    $item->phone = Input::onlyDigitsOrNull(data_get($data, 'phone'), 10);
    $item->website_url = Input::trimOrNull(data_get($data, 'website_url'));
    $item->description = Input::toText(data_get($data, 'description'));
    $item->address = Input::toText(data_get($data, 'address'));

    $item->municipality_id = Input::toId(data_get($data, 'municipality_id'));
    $item->zip = Input::onlyDigitsOrNull(data_get($data, 'zip'), 5);

    $item->fiscal_code = Input::toUpper(data_get($data, 'fiscal_code'));
    $item->fiscal_name = Input::toUpper(data_get($data, 'fiscal_name'));
    $item->fiscal_zip = Input::onlyDigitsOrNull(data_get($data, 'fiscal_zip'), 5);

    $item->fiscal_regime_id = Input::toId(data_get($data, 'fiscal_regime_id'));
    $item->cfdi_usage_id = Input::toId(data_get($data, 'cfdi_usage_id'));

    $item->logo_path = StorageMgrService::syncPath(
      $item->logo_path,
      $logo_doc instanceof UploadedFile ? $logo_doc : null,
      'Supplier'
    );

    $item->tax_certificate_path = StorageMgrService::syncPath(
      $item->tax_certificate_path,
      $tax_certificate_doc instanceof UploadedFile ? $tax_certificate_doc : null,
      'Supplier'
    );

    $item->positive_opinion_path = StorageMgrService::syncPath(
      $item->positive_opinion_path,
      $positive_opinion_doc instanceof UploadedFile ? $positive_opinion_doc : null,
      'Supplier'
    );

    $item->save();

    return $item;
  }
}
