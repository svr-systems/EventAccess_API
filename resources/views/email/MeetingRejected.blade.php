@extends('email.scaffold.Main')

@section('content')
  <div>
    <h2 class="font-weight-light">Cancelación de reunión</h2>

    <p class="text">
      Estimado(a),
    </p>

    <p class="text">
      Por medio del presente, le informamos que la reunión previamente agendada con <strong>{{ $data['company_name'] }}</strong> ha sido cancelada.
    </p>

    <p class="text">
      A continuación, le compartimos los detalles de la reunión cancelada:
    </p>

    <p class="text">
      <strong>Fecha:</strong> {{ $data['date'] }} <br>
      <strong>Horario:</strong> {{ $data['start_time'] }} - {{ $data['end_time'] }}
    </p>

    <p class="text">
      Agradecemos su comprensión ante cualquier inconveniente que esta situación pudiera ocasionar.
    </p>

    <p class="text">
      Quedamos a su disposición para futuras oportunidades de colaboración.
    </p>

    <br>

    <p class="text">
      Atentamente, <br>
      <strong>Equipo de coordinación</strong>
    </p>
  </div>
@endsection