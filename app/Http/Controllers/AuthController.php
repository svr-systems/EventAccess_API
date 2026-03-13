<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\Input;
use App\Support\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class AuthController extends Controller
{
  public function login(Request $request)
  {
    try {
      $email = Input::toLower($request->email);
      $password = Input::trimOrNull($request->password);

      if (is_null($email) || is_null($password)) {
        $errors = [];

        if (is_null($email))
          $errors['email'] = ['El email es requerido'];
        if (is_null($password))
          $errors['password'] = ['La contraseña es requerida'];

        return $this->rsp(422, 'Datos de acceso inválidos', null, $errors ?: null);
      }

      $user = User::query()
        ->where('email', $email)
        ->first();

      if (is_null($user)) {
        return $this->rsp(422, 'Datos de acceso inválidos', null);
      }

      if (!$user->is_active) {
        return $this->rsp(422, 'Tu cuenta está inactiva. Contacta al administrador.', null);
      }

      if (is_null($user->email_verified_at)) {
        return $this->rsp(422, 'Tu cuenta no está verificada. Revisa tu correo para confirmar.', null);
      }

      if (!Auth::attempt(['email' => $email, 'password' => $password])) {
        return $this->rsp(422, 'Datos de acceso inválidos', null);
      }

      $auth_user = Auth::user();
      $auth_user->load(['role:id,name']);

      $user_data = [
        'id' => $auth_user->id,
        'role_id' => $auth_user->role_id,
        'role' => $auth_user->role ? [
          'name' => $auth_user->role->name,
        ] : null,
        'full_name' => Person::fullName($auth_user),
        'email' => $auth_user->email,
      ];

      return $this->rsp(200, 'Datos de acceso válidos', [
        'auth' => [
          'token' => $auth_user->createToken('passportToken')->accessToken,
          'user' => $user_data,
        ],
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function logout(Request $request)
  {
    try {
      $token = $request->user()?->token();

      if (!is_null($token)) {
        $token->revoke();
      }

      return $this->rsp(200, 'Sesión finalizada correctamente');
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }
}
