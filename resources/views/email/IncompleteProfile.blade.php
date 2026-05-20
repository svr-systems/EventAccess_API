@extends('email.scaffold.Main')

@section('content')
@extends('email.scaffold.Main')

@section('content')

  <div>
    <h2 class="font-weight-light">Perfil pendiente de completar</h2>

    <p class="text">
      Estimado(a) {{ $data['user_name'] }},
    </p>

    <p class="text">
      Hemos detectado que su perfil de {{ $data['profile_type'] }} aún no ha sido completado correctamente.
    </p>

    <p class="text">
      Para poder acceder al 100% de las funcionalidades y servicios disponibles dentro de la plataforma,
      es necesario concluir el proceso de validación de su perfil.
    </p>

    <p class="text">
      Le recomendamos ingresar al sistema y verificar que toda la información requerida haya sido capturada correctamente,
      especialmente sus datos fiscales y de validación.
    </p>

    <p class="text">
      Mientras el proceso de validación permanezca incompleto, algunas funcionalidades podrían no estar disponibles.
    </p>

    <p class="text">
      Si requiere apoyo o tiene alguna duda durante el proceso, nuestro equipo estará disponible para asistirle.
    </p>

    <br>

    <p class="text">
      Atentamente, <br>
      <strong>Equipo de coordinación</strong>
    </p>

  </div>
@endsection