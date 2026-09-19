@extends('layouts.base')

@section('title', 'Form Buku Tamu')

@section('content')
<header class="kiosk-header">
  <a href="{{ route('home') }}" class="public-brand text-dark">
    <img src="{{ asset('assets/images/logos/smkn4tpi.png') }}" alt="Logo SMKN 4" width="42" height="42">
    <span>Buku Tamu SMKN 4</span>
  </a>
  <div class="kiosk-header-actions">
    <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm">Beranda</a>
    @if(auth()->user()->role === \App\Models\User::ROLE_GUEST)
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-outline-primary btn-sm">
          <i class="ti ti-logout me-1" aria-hidden="true"></i>Keluar
        </button>
      </form>
    @endif
  </div>
</header>

<main class="kiosk-main">
  <div class="kiosk-heading">
    <div>
      <p class="kiosk-eyebrow fw-semibold mb-1">Pencatatan kunjungan</p>
      <h1>Form Buku Tamu</h1>
    </div>
    <span class="kiosk-date">{{ now()->translatedFormat('d F Y') }}</span>
  </div>

  @if(session('success'))
    <div class="alert alert-success d-flex align-items-center gap-2" role="alert">
      <i class="ti ti-circle-check fs-6"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger">
      <strong>Data belum dapat disimpan.</strong>
      <ul class="mb-0 mt-2">
        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
      </ul>
    </div>
  @endif

  <form id="guest-form" method="POST" action="{{ route('tamu.store') }}" class="kiosk-form">
    @csrf
    <section class="camera-panel" aria-labelledby="camera-title">
      <div class="section-heading">
        <div>
          <span class="step-number">1</span>
          <h2 id="camera-title">Foto pengunjung</h2>
        </div>
        <span id="camera-status" class="badge bg-secondary">Menyiapkan kamera</span>
      </div>
      <div class="camera-stage">
        <div id="my_camera" class="camera-live"></div>
        <div id="results" class="camera-result">
          <i class="ti ti-camera fs-8 text-muted"></i>
          <span>Foto belum diambil</span>
        </div>
      </div>
      <input type="hidden" name="gambar" id="gambar" value="{{ old('gambar') }}">
      <div class="camera-actions">
        <button type="button" id="capture-button" class="btn btn-primary">
          <i class="ti ti-camera me-2"></i>Ambil Foto
        </button>
        <button type="button" id="reset-camera-button" class="btn btn-outline-primary d-none">
          <i class="ti ti-refresh me-2"></i>Ambil Ulang
        </button>
      </div>
      @error('gambar')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
    </section>

    <section class="details-panel" aria-labelledby="details-title">
      <div class="section-heading">
        <div>
          <span class="step-number">2</span>
          <h2 id="details-title">Data kunjungan</h2>
        </div>
      </div>
      <div class="row g-3">
        <div class="col-md-6">
          <label for="nama_tamu" class="form-label">Nama lengkap</label>
          <input id="nama_tamu" type="text" name="nama_tamu"
            class="form-control @error('nama_tamu') is-invalid @enderror"
            value="{{ old('nama_tamu') }}" maxlength="255" required>
          @error('nama_tamu')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
          <label for="nohp" class="form-label">Nomor HP</label>
          <input id="nohp" type="tel" name="nohp"
            class="form-control @error('nohp') is-invalid @enderror"
            value="{{ old('nohp') }}" maxlength="15" required>
          @error('nohp')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
          <label for="asal" class="form-label">Asal instansi</label>
          <input id="asal" type="text" name="asal"
            class="form-control @error('asal') is-invalid @enderror"
            value="{{ old('asal') }}" maxlength="255" required>
          @error('asal')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
          <label for="jenis_kelamin" class="form-label">Jenis kelamin</label>
          <select id="jenis_kelamin" name="jenis_kelamin"
            class="form-select @error('jenis_kelamin') is-invalid @enderror">
            <option value="">Pilih jenis kelamin</option>
            <option value="L" @selected(old('jenis_kelamin') === 'L')>Laki-laki</option>
            <option value="P" @selected(old('jenis_kelamin') === 'P')>Perempuan</option>
          </select>
          @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
          <label for="tujuan" class="form-label">Tujuan kunjungan</label>
          <input id="tujuan" type="text" name="tujuan"
            class="form-control @error('tujuan') is-invalid @enderror"
            value="{{ old('tujuan') }}" maxlength="100" required>
          @error('tujuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
          <label for="keterangan" class="form-label">Keterangan <span class="text-muted">(opsional)</span></label>
          <textarea id="keterangan" name="keterangan" rows="3" maxlength="255"
            class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
          @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
      </div>
      <button id="submit-button" type="submit" class="btn btn-primary btn-lg w-100 mt-4">
        <i class="ti ti-device-floppy me-2"></i>Simpan Kunjungan
      </button>
    </section>
  </form>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('guest-form');
  const imageInput = document.getElementById('gambar');
  const result = document.getElementById('results');
  const status = document.getElementById('camera-status');
  const captureButton = document.getElementById('capture-button');
  const resetCameraButton = document.getElementById('reset-camera-button');
  const submitButton = document.getElementById('submit-button');
  const cameraStage = document.querySelector('.camera-stage');
  const measuredWidth = Math.round(cameraStage.getBoundingClientRect().width);
  const previewWidth = measuredWidth > 0 ? measuredWidth : 320;
  const previewHeight = Math.round(previewWidth * 3 / 4);

  Webcam.set({
    width: previewWidth,
    height: previewHeight,
    dest_width: 960,
    dest_height: 720,
    image_format: 'jpeg',
    jpeg_quality: 90,
    constraints: { facingMode: 'user' }
  });

  Webcam.on('live', function () {
    status.className = 'badge bg-primary';
    status.textContent = 'Kamera siap';
    captureButton.disabled = false;
  });

  Webcam.on('error', function () {
    status.className = 'badge bg-danger';
    status.textContent = 'Kamera tidak tersedia';
    captureButton.disabled = true;
  });

  captureButton.disabled = true;
  Webcam.attach('#my_camera');

  captureButton.addEventListener('click', function () {
    const video = document.querySelector('#my_camera video');

    if (!video || !video.videoWidth || !video.videoHeight) {
      status.className = 'badge bg-danger';
      status.textContent = 'Kamera belum siap';
      return;
    }

    const outputWidth = 960;
    const outputHeight = 720;
    const outputRatio = outputWidth / outputHeight;
    const sourceRatio = video.videoWidth / video.videoHeight;
    let sourceWidth = video.videoWidth;
    let sourceHeight = video.videoHeight;
    let sourceX = 0;
    let sourceY = 0;

    if (sourceRatio > outputRatio) {
      sourceWidth = video.videoHeight * outputRatio;
      sourceX = (video.videoWidth - sourceWidth) / 2;
    } else {
      sourceHeight = video.videoWidth / outputRatio;
      sourceY = (video.videoHeight - sourceHeight) / 2;
    }

    const canvas = document.createElement('canvas');
    canvas.width = outputWidth;
    canvas.height = outputHeight;
    canvas.getContext('2d').drawImage(
      video,
      sourceX,
      sourceY,
      sourceWidth,
      sourceHeight,
      0,
      0,
      outputWidth,
      outputHeight
    );

    const dataUri = canvas.toDataURL('image/jpeg', 0.9);
    imageInput.value = dataUri;
    result.innerHTML = '<img src="' + dataUri + '" alt="Foto pengunjung">';
    status.className = 'badge bg-primary';
    status.textContent = 'Foto siap';
    captureButton.classList.add('d-none');
    resetCameraButton.classList.remove('d-none');
  });

  resetCameraButton.addEventListener('click', function () {
    imageInput.value = '';
    result.innerHTML = '<i class="ti ti-camera fs-8 text-muted"></i><span>Foto belum diambil</span>';
    status.className = 'badge bg-primary';
    status.textContent = 'Kamera siap';
    resetCameraButton.classList.add('d-none');
    captureButton.classList.remove('d-none');
    captureButton.focus();
  });

  form.addEventListener('submit', function (event) {
    if (!imageInput.value) {
      event.preventDefault();
      status.className = 'badge bg-danger';
      status.textContent = 'Ambil foto terlebih dahulu';
      captureButton.focus();
      return;
    }

    submitButton.disabled = true;
    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan';
  });
});
</script>
@endpush
