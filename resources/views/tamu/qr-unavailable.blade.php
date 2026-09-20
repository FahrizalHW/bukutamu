@extends('layouts.base')

@section('title', 'QR Tidak Berlaku')

@section('content')
<main class="guestbook-message-page">
  <section class="guestbook-message-card" role="alert">
    <span class="guestbook-message-icon guestbook-message-warning"><i class="ti ti-qrcode-off"></i></span>
    <p class="kiosk-eyebrow fw-semibold mb-2">Akses form berakhir</p>
    <h1>QR tidak lagi berlaku</h1>
    <p>Silakan kembali ke meja penerima dan pindai QR terbaru untuk membuka form buku tamu.</p>
    <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke beranda</a>
  </section>
</main>
@endsection
