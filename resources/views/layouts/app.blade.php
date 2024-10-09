<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Buku Tamu</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset ('assets/images/logos/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset ('assets/css/styles.min.css') }}" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    @include('layouts.__sidebar')
    <!--  Main wrapper -->
    <div class="body-wrapper">
      @include('layouts.__navbar')
      @yield('content')
    </div>
  </div>
  <script src="{{ asset ('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset ('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset ('assets/js/sidebarmenu.js') }}"></script>
  <script src="{{ asset ('assets/js/app.min.js') }}"></script>
  <script src="{{ asset ('assets/libs/simplebar/dist/simplebar.js') }}"></script>

  <script src="{{ asset ('assets/js/webcam.min.js') }}"></script>
  @stack('scripts')
  <!-- Datatables JS -->
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.datatables').DataTable({
        // Konfigurasi lainnya
        "searching": true,
        "paging": true,
        "info": true,
        "autoWidth": true,
      });
    });
  </script>  
</body>

</html>