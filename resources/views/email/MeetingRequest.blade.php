@extends('email.scaffold.Main')

@section('content')
  <div>
    <h2 class="font-weight-light">Nueva solicitud de reunión</h2>

    <p class="text">
      Estimado(a),
    </p>

    <p class="text">
      Le informamos que <strong>{{ $data['company_name'] }}</strong> ha solicitado una reunión con su empresa.
    </p>

    <p class="text">
      La solicitud fue realizada por <strong>{{ $data['supplier_user'] }}</strong>, quien ha manifestado su interés en establecer contacto con usted.
    </p>

    <p class="text">
      Le recomendamos revisar esta solicitud a la brevedad para dar el seguimiento correspondiente.
    </p>

    <p class="text">
      Agradecemos su atención y quedamos a su disposición para cualquier aclaración.
    </p>

    <br>

    <p class="text">
      Atentamente, <br>
      <strong>Equipo de coordinación</strong>
    </p>
  </div>
@endsection