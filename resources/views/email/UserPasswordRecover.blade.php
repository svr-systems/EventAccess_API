@extends('email.scaffold.Main')

@section('content')
  <div>
    <h2 class="font-weight-light">Recuperación de contraseña</h2>

    <p class="text">
      Hola, {{ e($data['full_name'] ?? '') }}.
      <br><br>
      Recibimos una solicitud para restablecer tu contraseña en <strong>EmailPro</strong>.
      Para continuar, haz clic en el siguiente botón:
    </p>

    <p>
      <a href="{{ $data['link'] ?? '' }}" class="button button_info" style="color: white; text-decoration: none;">
        RESTABLECER CONTRASEÑA
      </a>
    </p>

    <p class="text_sub">
      Si tú no solicitaste este cambio, puedes ignorar este mensaje.
    </p>
  </div>
@endsection