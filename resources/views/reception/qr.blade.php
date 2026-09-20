@extends('layouts.reception')

@section('title', 'QR Tamu Mandiri')

@section('content')
<div class="page-heading">
  <div>
    <p class="text-primary fw-semibold mb-1">Jalur mandiri</p>
    <h1>QR Buku Tamu</h1>
  </div>
  <a href="{{ route('reception.index') }}" class="btn btn-light">Kembali</a>
</div>

<section class="qr-display-card" aria-labelledby="qr-display-title">
  <div class="qr-display-copy">
    <span id="qr-connection-status" class="badge bg-secondary">Menghubungkan</span>
    <h2 id="qr-display-title">Pindai untuk mengisi buku tamu</h2>
    <p>Gunakan kamera ponsel, lalu lengkapi data dan foto kunjungan. QR berubah otomatis demi keamanan.</p>
    <div class="qr-countdown" aria-live="polite">
      QR diperbarui dalam <strong id="qr-countdown">--</strong> detik
    </div>
    <button id="qr-refresh-button" type="button" class="btn btn-outline-primary mt-3">
      <i class="ti ti-refresh me-1"></i> Perbarui sekarang
    </button>
  </div>
  <div class="qr-code-frame">
    <div id="guestbook-qr" aria-label="QR menuju form buku tamu mandiri"></div>
    <div id="qr-loading" class="qr-loading">Menyiapkan QR…</div>
  </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/qrcode.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const qrElement = document.getElementById('guestbook-qr');
  const loadingElement = document.getElementById('qr-loading');
  const statusElement = document.getElementById('qr-connection-status');
  const countdownElement = document.getElementById('qr-countdown');
  const refreshButton = document.getElementById('qr-refresh-button');
  const refreshUrl = @json(route('reception.qr.token'));
  let expiresAt = 0;
  let refreshing = false;

  function setStatus(text, className) {
    statusElement.className = 'badge ' + className;
    statusElement.textContent = text;
  }

  function renderQr(url) {
    qrElement.innerHTML = '';
    new QRCode(qrElement, {
      text: url,
      width: 320,
      height: 320,
      colorDark: '#071122',
      colorLight: '#ffffff',
      correctLevel: QRCode.CorrectLevel.M
    });
    loadingElement.classList.add('d-none');
  }

  async function refreshQr() {
    if (refreshing) return;
    refreshing = true;
    refreshButton.disabled = true;
    setStatus('Memperbarui', 'bg-warning text-dark');

    try {
      const response = await fetch(refreshUrl, {
        headers: { 'Accept': 'application/json' },
        credentials: 'same-origin',
        cache: 'no-store'
      });
      if (!response.ok) throw new Error('QR tidak dapat diperbarui.');

      const data = await response.json();
      expiresAt = new Date(data.expires_at).getTime();
      renderQr(data.url);
      setStatus('Aktif', 'bg-success');
    } catch (error) {
      setStatus('Koneksi terganggu', 'bg-danger');
    } finally {
      refreshing = false;
      refreshButton.disabled = false;
    }
  }

  setInterval(function () {
    if (!expiresAt) return;
    const seconds = Math.max(0, Math.ceil((expiresAt - Date.now()) / 1000));
    countdownElement.textContent = seconds;
    if (seconds === 0) {
      setStatus('QR kedaluwarsa', 'bg-danger');
      qrElement.innerHTML = '';
      loadingElement.textContent = 'Memperbarui QR…';
      loadingElement.classList.remove('d-none');
    }
  }, 1000);

  refreshButton.addEventListener('click', refreshQr);
  refreshQr();
  setInterval(refreshQr, 45000);
});
</script>
@endpush
