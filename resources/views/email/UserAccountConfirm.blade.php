@extends('email.scaffold.Main')

@section('content')
  <div>
    <h2 class="font-weight-light">Cuenta confirmada</h2>

    <p class="text">
      Hola, {{ e($data['full_name'] ?? '') }}.
      <br><br>
      Tu cuenta de <strong>EmailPro</strong> ha sido confirmada correctamente.
      Ya puedes iniciar sesión con tu correo y la contraseña que registraste.
    </p>

    <p>
      <a href="{{ $data['link'] ?? '' }}" class="button button_info" style="color: white; text-decoration: none;">
        INICIAR SESIÓN
      </a>
    </p>

    <p class="text_sub">
      Si tú no realizaste esta acción, te recomendamos cambiar tu contraseña o contactar a soporte.
    </p>
  </div>
@endsection