<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Buku Tamu Digital SMKN 4 Tanjungpinang')</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/bukutamu.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/guestbook-qr.css') }}">
  @stack('styles')
</head>
<body class="public-body">
  @yield('content')
  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/webcam.min.js') }}"></script>
  @stack('scripts')
</body>
</html>
