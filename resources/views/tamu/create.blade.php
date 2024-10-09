@extends('layouts.app')

@section('content')
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
<div class="container-fluid">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Forms</h5>
        <form method="POST" action="{{route('tamu.store')}}" enctype="multipart/form-data">
          @csrf
          <div class="row justify-content-center">
            <div class="col-md-12">
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
                      <label for="nama" class="form-label">Nama</label>
                      <input type="text" name="nama_tamu" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                      <label for="phone" class="form-label">No HP</label>
                      <input type="text" name="nohp" class="form-control">
                    </div>
                    <div class="col-md-12">
                      <label for="gender" class="form-label">Jenis Kelamin:</label>
                      <select id="gender" name="jenis_kelamin" class="form-select">
                        <option value="" hidden selected>Pilih Jenis Kelamin</option>
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                      </select>
                    </div>
                    <div class="col-md-12">
                      <label for="institution" class="form-label">Asal Instansi:</label>
                      <input type="text" name="asal" class="form-control">
                    </div>
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