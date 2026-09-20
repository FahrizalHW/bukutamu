@extends('layouts.base')

@section('title', 'Kunjungan Tersimpan')

@section('content')
<main class="guestbook-message-page">
  <section class="guestbook-message-card">
    <span class="guestbook-message-icon guestbook-message-success"><i class="ti ti-circle-check"></i></span>
    <p class="kiosk-eyebrow fw-semibold mb-2">Pencatatan selesai</p>
    <h1>Data kunjungan tersimpan</h1>
    <p>Terima kasih. Silakan tunjukkan halaman ini kepada petugas bila diperlukan.</p>
    <a href="{{ route('home') }}" class="btn btn-primary">Selesai</a>
  </section>
</main>
@endsection
