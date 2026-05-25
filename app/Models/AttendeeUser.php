<?php

namespace App\Models;

use App\Support\Input;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Validator;

class AttendeeUser extends Model {
  public $timestamps = false;
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
  public function fiscal_regime(): BelongsTo {
    return $this->belongsTo(FiscalRegime::class, 'fiscal_regime_id');
  }
  
  public function cfdi_usage(): BelongsTo {
    return $this->belongsTo(CfdiUsage::class, 'cfdi_usage_id');
  }

  public static function validData(array $data) {
    $rules = [
      'fiscal_code' => ['required', 'string', 'min:12', 'max:13'],
      'fiscal_name' => ['required', 'string', 'min:2', 'max:150'],
      'fiscal_zip' => ['required', 'string', 'size:5'],

      'fiscal_regime_id' => ['required', 'integer', 'exists:fiscal_regimes,id'],
      'cfdi_usage_id' => ['required', 'integer', 'exists:cfdi_usages,id'],
    ];

    $msgs = [
      'fiscal_code.required' => 'El RFC es obligatorio',
      'fiscal_code.min' => 'El RFC debe tener al menos 12 caracteres',
      'fiscal_code.max' => 'El RFC no puede tener más de 13 caracteres',

      'fiscal_name.required' => 'La razón social es obligatoria',
      'fiscal_name.min' => 'La razón social debe tener al menos 2 caracteres',
      'fiscal_name.max' => 'La razón social no puede tener más de 150 caracteres',

      'fiscal_zip.required' => 'El código postal fiscal es obligatorio',
      'fiscal_zip.size' => 'El código postal fiscal debe tener 5 dígitos',

      'fiscal_regime_id.required' => 'El régimen fiscal es obligatorio',
      'fiscal_regime_id.exists' => 'El régimen fiscal seleccionado no existe',

      'cfdi_usage_id.required' => 'El uso de CFDI es obligatorio',
      'cfdi_usage_id.exists' => 'El uso de CFDI seleccionado no existe',
    ];

    return Validator::make($data, $rules, $msgs);
  }

  public static function getItem(Request $request) {
    $item = self::query();

    $item->select(['attendee_users.*']);

    $item->with([
      'fiscal_regime:id,name',
      'cfdi_usage:id,name',
    ]);

    $item->where('attendee_users.user_id', '=', $request->user()->id);

    $item = $item->first();

    if (is_null($item)) {
      return null;
    }

    return $item;
  }

  public static function saveData(self $item, array $data): self {
    $item->fiscal_code = Input::toUpper(data_get($data, 'fiscal_code'));
    $item->fiscal_name = Input::toUpper(data_get($data, 'fiscal_name'));
    $item->fiscal_zip = Input::onlyDigitsOrNull(data_get($data, 'fiscal_zip'), 5);

    $item->fiscal_regime_id = Input::toId(data_get($data, 'fiscal_regime_id'));
    $item->cfdi_usage_id = Input::toId(data_get($data, 'cfdi_usage_id'));

    $item->save();

    return $item;
  }
}
