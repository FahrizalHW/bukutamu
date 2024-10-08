@extends('layouts.base')

@section('content')

<style>
  body {
    background-color: #B4D6CD; /* Light teal background */
  }

  .card {
    border: none;
    border-radius: 10px;
    background-color: white; /* Card background */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  .card-header {
    background-color: #FFDA76; /* Soft yellow header */
    color: #333; /* Dark text color */
    font-weight: bold;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
  }

  .btn-primary {
    background-color: #FF4E88; /* Bright pink button */
    border-color: #FF4E88; /* Match border color */
  }

  .btn-primary:hover {
    background-color: #FF8C9E; /* Light pink on hover */
    border-color: #FF8C9E;
  }

  label {
    color: #333; /* Dark color for labels */
  }

  .form-control,
  .form-select {
    border-radius: 5px;
    border: 1px solid #FFDA76; /* Soft yellow border */
  }

  .form-control:focus,
  .form-select:focus {
    border-color: #FF4E88; /* Bright pink focus border */
    box-shadow: 0 0 5px rgba(255, 78, 136, 0.5);
  }

  .text-center {
    margin-bottom: 20px; /* Add spacing below the image results */
  }

</style>

<div class="container mt-5">
  <!-- Toast Notification -->
  <div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
      <div class="toast-header">
        <strong class="me-auto">Berhasil!</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        {{ session('success') }} <!-- Ini akan menampilkan pesan sukses -->
      </div>
    </div>
  </div>
  <!-- / Toast Notification -->
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">Buku Tamu</div>
        <form method="POST" action="{{route('tamu.store')}}" enctype="multipart/form-data">
          @csrf
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <h4>Foto</h4>
                <div id="my_camera" class="mb-3"></div> <!-- Elemen untuk webcam -->
                <input type="button" value="Take Snapshot" onClick="take_snapshot()" class="btn btn-warning">
                <input type="hidden" name="gambar" class="image-tag">
                <div id="results" class="mt-3 text-center">Gambar akan muncul di sini</div>
              </div>
              <div class="col-md-6 offset-md-1"> <!-- Add offset to center the inputs -->
                <div class="row g-4">
                  <div class="col-md-12">
                    <label for="name">Nama:</label>
                    <input type="text" id="name" name="nama_tamu" class="form-control" required>
                  </div>
                  <div class="col-md-12">
                    <label for="phone">No HP:</label>
                    <input type="text" id="phone" name="nohp" class="form-control" required>
                  </div>
                  <div class="col-md-12">
                    <label for="gender">Jenis Kelamin:</label>
                    <select id="gender" name="jenis_kelamin" class="form-select" required>
                      <option value="" hidden selected>Pilih Jenis Kelamin</option>
                      <option value="male">Laki-Laki</option>
                      <option value="female">Perempuan</option>
                    </select>
                  </div>
                  <div class="col-md-12">
                    <label for="institution">Asal Instansi:</label>
                    <input type="text" name="asal" class="form-control" required>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Kirim</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
  $(document).ready(function() {
    // Webcam setup
    Webcam.set({
      width: 320,
      height: 240,
      image_format: 'jpeg',
      jpeg_quality: 100
    });
    Webcam.attach('#my_camera'); // Attach webcam to the element

    window.take_snapshot = function() {
      Webcam.snap(function(data_uri) {
        // Display the captured image in the results div with fixed width/height
        $('#results').html('<img src="' + data_uri + '" style="width: 320px; height: 240px;"/>');
        // Set the hidden input field with the image data
        $('.image-tag').val(data_uri);
      });
    }

    // Trigger toast notification if session contains success message
    @if(session('success'))
      var toastEl = document.getElementById('liveToast');
      var toast = new bootstrap.Toast(toastEl);
      toast.show();
    @endif
  });
</script>
@endpush