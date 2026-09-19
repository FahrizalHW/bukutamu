@extends('layouts.base')

@section('title', 'Buku Tamu SMKN 4 Tanjungpinang')

@section('content')
<div class="home-shell">
  <header class="public-nav">
    <a href="{{ route('home') }}" class="public-brand">
      <img src="{{ asset('assets/images/logos/smkn4tpi.png') }}" alt="Logo SMKN 4" width="44" height="44">
      <span>Buku Tamu</span>
    </a>
    <nav class="d-flex align-items-center gap-2">
      @auth
        <a href="{{ route('rekap.index') }}" class="btn btn-light btn-sm">
          <i class="ti ti-layout-dashboard me-1"></i>Admin
        </a>
      @else
        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
          <i class="ti ti-login me-1"></i>Login
        </a>
      @endauth
    </nav>
  </header>

  <main class="home-hero">
    <img src="{{ asset('assetsform/img/empty-classroom-due-coronavirus-pandemic.jpg') }}"
      alt="Ruang kelas SMKN 4 Tanjungpinang" class="home-hero-image">
    <div class="home-overlay"></div>
    <div class="home-copy">
      <p class="home-kicker">Selamat datang di</p>
      <h1>SMKN 4 Tanjungpinang</h1>
      <p>Silakan catat kunjungan Anda melalui buku tamu digital sekolah.</p>
      <a href="{{ route('tamu.create') }}" class="btn btn-success btn-lg">
        <i class="ti ti-user-plus me-2"></i>Isi Buku Tamu
      </a>
    </div>
  </main>
</div>
@endsection
