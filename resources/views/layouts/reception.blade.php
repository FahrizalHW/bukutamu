<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Penerimaan') - Buku Tamu</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/bukutamu.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/guestbook-qr.css') }}">
  @stack('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/reception.css') }}">
</head>
<body class="public-body">
  <header class="kiosk-header">
    <a href="{{ route('reception.index') }}" class="public-brand text-dark">
      <img src="{{ asset('assets/images/logos/smkn4tpi.png') }}" alt="Logo SMKN 4" width="42" height="42">
      <span>Penerimaan Buku Tamu</span>
    </a>
    <nav class="kiosk-header-actions" aria-label="Navigasi penerimaan">
      @if(auth()->user()->role === \App\Models\User::ROLE_SUPERADMIN)
        <a href="{{ route('dashboard.index') }}" class="kiosk-header-link">Dashboard</a>
      @else
        <a href="{{ route('reception.index') }}" class="kiosk-header-link">Penerimaan</a>
      @endif
      <form action="{{ route('logout') }}" method="POST" class="m-0">
        @csrf
        <button type="submit" class="btn btn-link kiosk-header-link p-0 border-0">Keluar</button>
      </form>
    </nav>
  </header>
  <main class="kiosk-main reception-main">
    @yield('content')
  </main>
  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  @stack('scripts')
</body>
</html>
