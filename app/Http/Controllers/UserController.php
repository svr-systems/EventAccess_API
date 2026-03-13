<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasActiveToggle;
use App\Models\User;
use App\Services\EmailService;
use App\Support\Input;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserController extends Controller {
  use HasActiveToggle;

  /**
   * ===========================================
   * CONFIG
   * ===========================================
   */
  private const RECOVER_TTL_MINUTES = 5;

  /**
   * ===========================================
   * HELPERS
   * ===========================================
   */
  private function decryptUserId(string $token): ?int {
    try {
      $id = (int) Crypt::decryptString($token);
      return $id > 0 ? $id : null;
    } catch (Throwable $err) {
      return null;
    }
  }

  private function getRecoverAt($value): Carbon {
    return $value instanceof Carbon ? $value : Carbon::parse($value);
  }

  /**
   * ===========================================
   * CRUD (AUTH)
   * ===========================================
   */
  public function index(Request $request) {
    try {
      return $this->rsp(200, 'Registros retornados correctamente', [
        'items' => User::getItems($request),
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function show(string $id, Request $request) {
    try {
      $item = User::getItem($id, $request);

      if (is_null($item)) {
        return $this->rsp(404, 'Registro no encontrado');
      }

      return $this->rsp(200, 'Registro retornado correctamente', [
        'item' => $item,
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function store(Request $request) {
    return $this->storeUpdate(null, $request);
  }

  public function update(string $id, Request $request) {
    return $this->storeUpdate($id, $request);
  }

  public function destroy(string $id, Request $request) {
    return $this->setActive(User::class, $id, $request, false);
  }

  public function activate(string $id, Request $request) {
    return $this->setActive(User::class, $id, $request, true);
  }

  protected function storeUpdate(?string $id, Request $request) {
    DB::beginTransaction();

    try {
      $store_mode = is_null($id);

      $email = Input::toLower($request->email);

      $valid = User::validEmail(['email' => $email], $id);
      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }

      $valid = User::validData($request->all());
      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }

      $email_current = null;

      if ($store_mode) {
        $item = new User();
        $item->created_by_id = $request->user()->id;
        $item->updated_by_id = $request->user()->id;
      } else {
        $item = User::find((int) $id);

        if (is_null($item)) {
          DB::rollBack();
          return $this->rsp(404, 'Registro no encontrado');
        }

        $email_current = $item->email;
        $item->updated_by_id = $request->user()->id;
      }

      $payload = $request->all();
      $payload['email'] = $email;
      $payload['avatar_doc'] = $request->file('avatar_doc');

      $item = User::saveData($item, $payload);

      $must_confirm = $store_mode || (!is_null($email_current) && $email_current !== $item->email);

      if ($must_confirm) {
        $item->email_verified_at = null;
        $item->save();

        DB::afterCommit(function () use ($item) {
          EmailService::userAccountConfirmation(
            [$item->email],
            [
              'id' => $item->id,
              'full_name' => $item->full_name,
            ]
          );
        });
      }

      DB::commit();

      return $this->rsp(
        $store_mode ? 201 : 200,
        'Registro ' . ($store_mode ? 'agregado' : 'editado') . ' correctamente',
        $store_mode ? ['item' => ['id' => $item->id]] : null
      );
    } catch (Throwable $err) {
      DB::rollBack();
      return $this->rsp(500, null, $err);
    }
  }

  /**
   * ===========================================
   * PÚBLICO: CONFIRMACIÓN DE CUENTA
   * ===========================================
   */
  public function accountConfirmShow(string $token, Request $request) {
    try {
      $user_id = $this->decryptUserId($token);

      if (is_null($user_id)) {
        return $this->rsp(404, 'Acción no disponible');
      }

      $item = User::query()
        ->select([
          'users.id',
          'users.is_active',
          'users.name',
          'users.paternal_surname',
          'users.maternal_surname',
          'users.email',
          'users.email_verified_at',
        ])
        ->whereKey($user_id)
        ->first();

      if (is_null($item)) {
        return $this->rsp(404, 'Acción no disponible');
      }

      if (!$item->is_active || !is_null($item->email_verified_at)) {
        return $this->rsp(422, 'La cuenta ya está confirmada y/o la acción no es procesable');
      }

      return $this->rsp(200, 'Registro retornado correctamente', [
        'item' => [
          'email' => $item->email,
          'full_name' => $item->full_name,
        ],
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function accountConfirm(string $token, Request $request) {
    DB::beginTransaction();

    try {
      $valid = User::validPassword($request->all());

      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }

      $user_id = $this->decryptUserId($token);

      if (is_null($user_id)) {
        DB::rollBack();
        return $this->rsp(404, 'Acción no disponible');
      }

      $item = User::find($user_id);

      if (is_null($item) || !$item->is_active) {
        DB::rollBack();
        return $this->rsp(422, 'La acción no es procesable');
      }

      if (!is_null($item->email_verified_at)) {
        DB::rollBack();
        return $this->rsp(422, 'La cuenta ya está confirmada');
      }

      $item->email_verified_at = now();
      $item->password = Hash::make(trim((string) $request->password));
      $item->save();

      DB::afterCommit(function () use ($item) {
        EmailService::userAccountConfirm(
          [$item->email],
          [
            'email' => $item->email,
            'full_name' => $item->full_name,
          ]
        );
      });

      DB::commit();

      return $this->rsp(200, 'Cuenta confirmada correctamente');
    } catch (Throwable $err) {
      DB::rollBack();
      return $this->rsp(500, null, $err);
    }
  }

  /**
   * ===========================================
   * PÚBLICO: RECUPERACIÓN / RESET DE CONTRASEÑA
   * ===========================================
   */
  public function passwordRecover(Request $request) {
    DB::beginTransaction();

    try {
      $email = Input::toLower($request->email);

      $valid = User::validRecoverEmail(['email' => $email]);

      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }

      $item = User::getItemByEmail($email);

      $ok_message = 'Si el correo existe, recibirás un mensaje con instrucciones para restablecer tu contraseña.';

      if (is_null($item) || !$item->is_active || is_null($item->email_verified_at)) {
        DB::rollBack();
        return $this->rsp(200, $ok_message);
      }

      if (!is_null($item->password_recover_at)) {
        $recover_at = $this->getRecoverAt($item->password_recover_at);

        if ($recover_at->copy()->addMinutes(self::RECOVER_TTL_MINUTES)->isFuture()) {
          DB::rollBack();
          return $this->rsp(200, $ok_message);
        }
      }

      $item->password_recover_at = now();
      $item->save();

      DB::afterCommit(function () use ($item) {
        EmailService::userPasswordRecover(
          [$item->email],
          [
            'id' => $item->id,
            'email' => $item->email,
            'full_name' => $item->full_name,
          ]
        );
      });

      DB::commit();

      return $this->rsp(200, $ok_message);
    } catch (Throwable $err) {
      DB::rollBack();
      return $this->rsp(500, null, $err);
    }
  }

  public function passwordResetShow(string $token, Request $request) {
    try {
      $user_id = $this->decryptUserId($token);

      if (is_null($user_id)) {
        return $this->rsp(404, 'Acción no disponible');
      }

      $item = User::query()
        ->select([
          'users.id',
          'users.is_active',
          'users.name',
          'users.paternal_surname',
          'users.maternal_surname',
          'users.email',
          'users.email_verified_at',
          'users.password_recover_at',
        ])
        ->whereKey($user_id)
        ->first();

      if (is_null($item)) {
        return $this->rsp(404, 'Acción no disponible');
      }

      if (
        !$item->is_active ||
        is_null($item->email_verified_at) ||
        is_null($item->password_recover_at)
      ) {
        return $this->rsp(422, 'La acción no es procesable');
      }

      $recover_at = $this->getRecoverAt($item->password_recover_at);

      if ($recover_at->copy()->addMinutes(self::RECOVER_TTL_MINUTES)->isPast()) {
        return $this->rsp(422, 'El enlace de recuperación ha expirado. Solicita uno nuevo.');
      }

      return $this->rsp(200, 'Registro retornado correctamente', [
        'item' => [
          'email' => $item->email,
          'full_name' => $item->full_name,
        ],
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function passwordReset(string $token, Request $request) {
    DB::beginTransaction();

    try {
      $valid = User::validPassword($request->all());

      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }

      $user_id = $this->decryptUserId($token);

      if (is_null($user_id)) {
        DB::rollBack();
        return $this->rsp(404, 'Acción no disponible');
      }

      $item = User::find($user_id);

      if (
        is_null($item) ||
        !$item->is_active ||
        is_null($item->email_verified_at) ||
        is_null($item->password_recover_at)
      ) {
        DB::rollBack();
        return $this->rsp(422, 'La acción no es procesable');
      }

      $recover_at = $this->getRecoverAt($item->password_recover_at);

      if ($recover_at->copy()->addMinutes(self::RECOVER_TTL_MINUTES)->isPast()) {
        DB::rollBack();
        return $this->rsp(422, 'El enlace de recuperación ha expirado. Solicita uno nuevo.');
      }

      $item->password = Hash::make(trim((string) $request->password));
      $item->password_recover_at = null;
      $item->save();

      DB::afterCommit(function () use ($item) {
        EmailService::userPasswordReset(
          [$item->email],
          [
            'email' => $item->email,
            'full_name' => $item->full_name,
          ]
        );
      });

      DB::commit();

      return $this->rsp(200, 'Contraseña restablecida correctamente');
    } catch (Throwable $err) {
      DB::rollBack();
      return $this->rsp(500, null, $err);
    }
  }

  /**
   * ===========================================
   * PÚBLICO: Nuevo usuario asistente
   * ===========================================
   */

  public function publicStore(Request $request) {
    $request->request->add(['role_id' => 5]);
    $user = User::where('email',$request->email)->first();
    $id = null;
    if($user){
      $id = $user->id;
    }
    return $this->publicStoreUpdate($id, $request);
  }

  public function publicUpdate(string $id, Request $request) {
    return $this->publicStoreUpdate($id, $request);
  }

  protected function PublicStoreUpdate(?string $id, Request $request) {
    DB::beginTransaction();

    try {
      $store_mode = is_null($id);

      $email = Input::toLower($request->email);

      $valid = User::validEmail(['email' => $email], $id);
      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }

      $valid = User::validData($request->all(), '5');
      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }

      $email_current = null;

      if ($store_mode) {
        $item = new User();
      } else {
        $item = User::find((int) $id);

        if (is_null($item)) {
          DB::rollBack();
          return $this->rsp(404, 'Registro no encontrado');
        }

        $email_current = $item->email;
      }

      $payload = $request->all();
      $payload['email'] = $email;
      $payload['avatar_doc'] = $request->file('avatar_doc');

      $item = User::saveData($item, $payload);

      $must_confirm = $store_mode || (!is_null($email_current) && $email_current !== $item->email);

      if ($must_confirm) {
        $item->email_verified_at = null;
        $item->save();

        DB::afterCommit(function () use ($item) {
          EmailService::userAccountConfirmation(
            [$item->email],
            [
              'id' => $item->id,
              'full_name' => $item->full_name,
            ]
          );
        });
      }

      DB::commit();

      return $this->rsp(
        $store_mode ? 201 : 200,
        'Registro ' . ($store_mode ? 'agregado' : 'editado') . ' correctamente',
        ['item' => ['id' => $item->id]]
      );
    } catch (Throwable $err) {
      DB::rollBack();
      return $this->rsp(500, null, $err);
    }
  }
}
