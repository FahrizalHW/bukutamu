<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Buku Tamu &mdash; SMK Negeri 4 Tanjungpinang</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <!-- Logo positioned in the center -->
                <img src="{{ asset('assets/images/logos/smkn4tpi.png') }}" width="80" alt="" class="d-block mx-auto mb-4">
                <p class="text-center">Buku Tamu SMK Negeri 4 Tanjungpinang</p>

                <!-- Formulir register -->
                <form action="{{ route('postRegister') }}" method="POST">
                  @csrf
                  <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" required>
                  </div>
                  <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                  </div>
                  <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" name="password_confirmation" required>
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Daftar</button>
                </form>

                <!-- Link login -->
                <div class="d-flex align-items-center justify-content-center">
                  <p class="fs-4 mb-0 fw-bold">Sudah punya akun?</p>
                  <a class="text-primary fw-bold ms-2" href="{{ route('login') }}">Masuk</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>