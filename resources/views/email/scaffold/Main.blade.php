<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name') }}</title>

  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #1A1A1A;
      color: #BCBCBC;
      font-family: Arial, Helvetica, sans-serif;
    }

    .wrapper {
      width: 100%;
      padding: 24px 0;
    }

    .content-box {
      width: 92%;
      max-width: 680px;
      margin: 0 auto;
      padding: 32px 24px;
      border-radius: 14px;
      background-color: #1E1E1E;
      box-shadow: 0px 5px 25px 10px #151515;
      text-align: center;
    }

    .font-weight-light {
      font-weight: 300 !important;
    }

    .button {
      display: inline-block;
      cursor: pointer;
      font-weight: bold;
      padding: 10px 14px;
      border-radius: 6px;
      box-shadow: 0px 3px 1px -2px rgba(0, 0, 0, 0.2),
        0px 2px 2px 0px rgba(0, 0, 0, 0.14),
        0px 1px 5px 0px rgba(0, 0, 0, 0.12);
    }

    .button_success {
      background-color: #4caf50 !important;
      border-color: #4caf50 !important;
    }

    .button_info {
      background-color: #2196f3 !important;
      border-color: #2196f3 !important;
    }

    .text {
      font-size: 13px;
      line-height: 1.5;
      padding-top: 6px;
      margin: 0;
    }

    .text_sub,
    .contact {
      font-size: 11px;
      line-height: 1.5;
      padding-top: 12px;
      margin: 0;
    }

    .footer {
      font-size: 9px;
      line-height: 1.4;
      padding-top: 24px;
      margin: 0;
    }

    a {
      color: inherit;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    .logo {
      display: block;
      margin: 0 auto 18px auto;
      height: 72px;
    }
  </style>
</head>

<body>
  @php
    $logo_path = storage_path('app/public/logo.png');
    $logo_b64 = file_exists($logo_path)
      ? base64_encode(file_get_contents($logo_path))
      : null;
  @endphp

  <div class="wrapper">
    <div class="content-box">
      @if ($logo_b64)
        <img src="data:image/png;base64,{{ $logo_b64 }}" class="logo" alt="{{ config('app.name') }}">
      @endif

      @yield('content')

      @include('email.scaffold.Contact')
      @include('email.scaffold.Footer')
    </div>
  </div>
</body>

</html>