@extends('email.scaffold.Main')

@section('content')
  <div>
    <h2 class="font-weight-light">Contraseña restablecida</h2>

    <p class="text">
      Hola, {{ e($data['full_name'] ?? '') }}.
      <br><br>
      Tu contraseña de <strong>EmailPro</strong> fue restablecida correctamente.
      Ya puedes iniciar sesión con tu correo y tu nueva contraseña.
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