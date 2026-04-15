@extends('email.scaffold.Main')

@section('content')
  <div>
    <h2 class="font-weight-light">Confirmación de reunión</h2>

    <p class="text">
      Estimado(a),
    </p>

    @if($data['is_meeting_request'])
      <p class="text">
        Nos complace informarle que la solicitud de reunión previamente realizada por
        <strong>{{ $data['company_name'] }}</strong> ha sido confirmada exitosamente.
      </p>
    @else
      <p class="text">
        Nos complace informarle que <strong>{{ $data['company_name'] }}</strong> ha agendado una reunión con usted.
      </p>
    @endif

    <p class="text">
      Será atendido(a) por <strong>{{ $data['buyer_user'] }}</strong>, quien estará a su disposición para dar seguimiento
      a los temas de interés.
    </p>

    <p class="text">
      A continuación, le compartimos los detalles de la reunión:
    </p>

    <p class="text">
      <strong>Fecha:</strong> {{ $data['date'] }} <br>
      <strong>Horario:</strong> {{ $data['start_time'] }} - {{ $data['end_time'] }}
    </p>

    <p class="text">
      Le recomendamos presentarse puntualmente para aprovechar al máximo este encuentro.
    </p>

    <p class="text">
      Agradecemos su atención y quedamos a su disposición para cualquier duda o aclaración.
    </p>

    <br>

    <p class="text">
      Atentamente, <br>
      <strong>Equipo de coordinación</strong>
    </p>
  </div>
@endsection