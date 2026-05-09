@extends('email.scaffold.Main')

@section('content')
  <div>
    @if($data['is_reviewed'])
      <h2 class="font-weight-light">Perfil aprobado</h2>

      <p class="text">
        Estimado(a),
      </p>

      <p class="text">
        Nos complace informarle que su perfil ha sido aprobado correctamente.
      </p>

      <p class="text">
        A partir de este momento podrá operar dentro del sistema sin ningún problema y acceder a las funciones disponibles
        en la plataforma.
      </p>

      <p class="text">
        Agradecemos su interés y confianza en nuestro sistema.
      </p>
    @else
      <h2 class="font-weight-light">Perfil rechazado</h2>

      <p class="text">
        Estimado(a),
      </p>

      <p class="text">
        Le informamos que su perfil no pudo ser aprobado en esta ocasión.
      </p>

      @if(!empty($data['reviewed_comment']))
        <p class="text">
          <strong>Comentarios de revisión:</strong><br>
          <i>{{ $data['reviewed_comment'] }}</i>
        </p>
      @endif

      <p class="text">
        Le solicitamos revisar la información de su perfil y realizar los ajustes pertinentes para continuar con el proceso
        de validación.
      </p>

      <p class="text">
        Puede continuar operando con normalidad dentro del sistema; sin embargo, hasta completar satisfactoriamente el
        proceso de validación, algunas funcionalidades y beneficios de la plataforma podrían no estar disponibles.
      </p>
    @endif

    <p class="text">
      Si tiene alguna duda o requiere apoyo adicional, nuestro equipo estará disponible para asistirle.
    </p>

    <br>

    <p class="text">
      Atentamente, <br>
      <strong>Equipo de coordinación</strong>
    </p>
  </div>
@endsection