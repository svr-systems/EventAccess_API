@extends('email.scaffold.Main')

@section('content')
  <div>
    <h2 class="font-weight-light">Cancelación de reunión</h2>

    <p class="text">
      Estimado(a),
    </p>

    <p class="text">
      Le informamos que la reunión previamente agendada con <strong>{{ $data['company_name'] }}</strong> ha sido cancelada.
    </p>

    <p class="text">
      La reunión estaba programada para ser atendida por <strong>{{ $data['supplier_user'] }}</strong>.
    </p>

    <p class="text">
      A continuación, le compartimos los detalles de la reunión cancelada:
    </p>

    <p class="text">
      <strong>Fecha:</strong> {{ $data['date'] }} <br>
      <strong>Horario:</strong> {{ $data['start_time'] }} - {{ $data['end_time'] }}
    </p>

    <p class="text">
      Lamentamos cualquier inconveniente que esta situación pudiera ocasionar.
    </p>

    <p class="text">
      Le recomendamos mantenerse atento(a) a futuras solicitudes o posibles reagendaciones dentro de la plataforma.
    </p>

    <br>

    <p class="text">
      Atentamente, <br>
      <strong>Equipo de coordinación</strong>
    </p>
  </div>
@endsection