@extends('layouts.reception')

@section('title', 'Penerimaan')

@section('content')
<div class="kiosk-heading">
  <div>
    <p class="kiosk-eyebrow fw-semibold mb-1">Meja penerimaan</p>
    <h1>Pilih jalur pencatatan tamu</h1>
  </div>
  <span class="kiosk-date">{{ now()->translatedFormat('d F Y') }}</span>
</div>

<section class="reception-action-grid" aria-label="Pilihan jalur penerimaan">
  <a href="{{ route('reception.qr.index') }}" class="reception-action-card reception-action-primary">
    <span class="reception-action-icon"><i class="ti ti-qrcode"></i></span>
    <span>
      <strong>Tampilkan QR Mandiri</strong>
      <small>Untuk banyak pengunjung yang mengisi melalui ponsel masing-masing.</small>
    </span>
    <i class="ti ti-arrow-right"></i>
  </a>
  <a href="{{ route('tamu.create') }}" class="reception-action-card">
    <span class="reception-action-icon"><i class="ti ti-device-desktop"></i></span>
    <span>
      <strong>Isi melalui Kiosk</strong>
      <small>Untuk pengunjung yang memerlukan bantuan operator atau tidak membawa ponsel.</small>
    </span>
    <i class="ti ti-arrow-right"></i>
  </a>
</section>
@endsection
