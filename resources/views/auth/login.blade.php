<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Admin - Buku Tamu</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/bukutamu.css') }}">
</head>
<body class="auth-body">
  <main class="auth-shell">
    <section class="auth-panel">
      <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none mb-4">
        <img src="{{ asset('assets/images/logos/smkn4tpi.png') }}" width="52" height="52" alt="Logo SMKN 4">
        <span class="fw-bold text-dark">Buku Tamu</span>
      </a>
      <h1 class="auth-title">Login admin</h1>
      <p class="text-muted mb-4">SMKN 4 Tanjungpinang</p>

      @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      <form action="{{ route('login.store') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input id="username" type="text" name="username"
            class="form-control @error('username') is-invalid @enderror"
            value="{{ old('username') }}" autocomplete="username" required autofocus>
          @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
          <label for="password" class="form-label">Password</label>
          <input id="password" type="password" name="password"
            class="form-control @error('password') is-invalid @enderror"
            autocomplete="current-password" required>
          @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-primary w-100">
          <i class="ti ti-login me-2"></i>Masuk
        </button>
      </form>
    </section>
  </main>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
