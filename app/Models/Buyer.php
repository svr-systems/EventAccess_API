<?php

namespace App\Models;

use App\Services\StorageMgrService;
use App\Support\DisplayId;
use App\Support\Input;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Validator;

class Buyer extends Model {
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

  /**
   * ===========================================
   * VALIDACIONES
   * ===========================================
   */
  public static function validData(array $data) {
    $rules = [
      'name' => ['required', 'string', 'min:2', 'max:60'],

      'phone' => ['nullable', 'regex:/^\d{10}$/'],
      'website_url' => ['nullable', 'url', 'max:150'],
      'description' => ['nullable', 'string'],

      'address' => ['nullable', 'string', 'max:150'],
      'municipality_id' => ['nullable', 'exists:municipalities,id'],
      'zip' => ['nullable', 'regex:/^\d{5}$/'],

    ];

    $msgs = [
      'name.required' => 'El nombre es obligatorio.',
      'name.string' => 'El nombre debe ser un texto válido.',
      'name.min' => 'El nombre debe tener al menos 2 caracteres.',
      'name.max' => 'El nombre no puede tener más de 100 caracteres.',

      'phone.regex' => 'El teléfono debe contener exactamente 10 dígitos.',

      'website_url.url' => 'El sitio web debe ser una URL válida.',
      'website_url.max' => 'El sitio web no puede exceder 150 caracteres.',

      'description.string' => 'La descripción debe ser un texto válido.',

      'address.string' => 'La dirección debe ser un texto válido.',
      'address.max' => 'La dirección no puede exceder 150 caracteres.',

      'municipality_id.exists' => 'El municipio seleccionado no es válido.',

      'zip.regex' => 'El código postal debe contener exactamente 5 dígitos.',
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
      'buyers.*',
    ]);

    $items->where('buyers.is_active', (bool) ((int) $is_active));


    // if ($request->user()->role_id === 3 || $request->user()->role_id === 4) {
    $items->join('buyer_users', 'buyer_users.buyer_id', 'buyers.id');
    $items->where('buyer_users.user_id', $request->user()->id);
    // }

    return $items->get();
  }

  public static function getItem(Request $request = null) {
    $item = self::query();

    $buyer_user = BuyerUser::getFirstByUser($request->user()->id);

    $item->select(['buyers.*']);

    $item->with([
      'created_by:id,email',
      'updated_by:id,email',
      'municipality:id,name,state_id',
      'municipality.state:id,name',
    ]);

    $item->whereKey($buyer_user->buyer_id);

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
    $logo_doc = data_get($data, 'logo_doc');

    $item->name = Input::toUpper(data_get($data, 'name'));

    $item->phone = Input::onlyDigitsOrNull(data_get($data, 'phone'), 10);
    $item->website_url = Input::trimOrNull(data_get($data, 'website_url'));
    $item->description = Input::toText(data_get($data, 'description'));
    $item->address = Input::toText(data_get($data, 'address'));

    $item->municipality_id = Input::toId(data_get($data, 'municipality_id'));
    $item->zip = Input::onlyDigitsOrNull(data_get($data, 'zip'), 5);

    $item->logo_path = StorageMgrService::syncPath(
      $item->logo_path,
      $logo_doc instanceof UploadedFile ? $logo_doc : null,
      'Buyer'
    );

    $item->save();

    return $item;
  }
}
