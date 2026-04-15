@extends('email.scaffold.Main')

@section('content')
  <div>
    <h2 class="font-weight-light">Cancelación de solicitud de reunión</h2>

    <p class="text">
      Estimado(a),
    </p>

    <p class="text">
      Le informamos que la solicitud de reunión realizada por <strong>{{ $data['company_name'] }}</strong> ha sido cancelada.
    </p>

    <p class="text">
      Por lo tanto, ya no será necesario considerar esta solicitud dentro de su agenda.
    </p>

    <p class="text">
      Agradecemos su disposición y quedamos atentos a futuras oportunidades de colaboración.
    </p>

    <br>

    <p class="text">
      Atentamente, <br>
      <strong>Equipo de coordinación</strong>
    </p>
  </div>
@endsection