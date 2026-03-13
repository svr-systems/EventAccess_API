@extends('email.scaffold.Main')

@section('content')
  <div>
    <h2 class="font-weight-light">Confirmación de cuenta</h2>

    <p class="text">
      Hola, {{ e($data['full_name'] ?? '') }}.
      <br><br>
      Recibimos una solicitud para activar tu acceso a <strong>EmailPro</strong>.
      Para confirmar tu cuenta y continuar, haz clic en el siguiente botón:
    </p>

    <p>
      <a href="{{ $data['link'] ?? '' }}" class="button button_success" style="color: white; text-decoration: none;">
        CONFIRMAR CUENTA
      </a>
    </p>

    <p class="text_sub">
      Si tú no solicitaste esta confirmación, puedes ignorar este mensaje.
    </p>
  </div>
@endsection