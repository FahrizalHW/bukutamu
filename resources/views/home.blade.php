@extends('layouts.base')

@section('title', 'Buku Tamu Digital SMKN 4 Tanjungpinang')

@php
  $heroImage = 'assets/images/backgrounds/smkn4-tanjungpinang-hero.png';
@endphp

@section('content')
<div class="home-page">
  <header class="public-nav">
    <div class="home-nav-inner">
      <a href="{{ route('home') }}" class="public-brand" aria-label="Buku Tamu Digital SMKN 4 Tanjungpinang">
        <span class="public-brand-mark">
          <img src="{{ asset('assets/images/logos/smkn4tpi.png') }}" alt="" width="46" height="46">
        </span>
        <span class="public-brand-copy">
          <strong>Buku Tamu Digital</strong>
          <small>SMKN 4 Tanjungpinang</small>
        </span>
      </a>

      @auth
        @if(auth()->user()->role === \App\Models\User::ROLE_OPERATOR)
          <a href="{{ route('reception.index') }}" class="home-admin-link">
            <i class="ti ti-users" aria-hidden="true"></i>
            <span>Penerimaan</span>
          </a>
        @elseif(auth()->user()->role === \App\Models\User::ROLE_SUPERADMIN)
          <a href="{{ route('dashboard.index') }}" class="home-admin-link">
            <i class="ti ti-layout-dashboard" aria-hidden="true"></i>
            <span>Dashboard</span>
          </a>
        @endif
      @else
        <a href="{{ route('login') }}" class="home-admin-link">
          <i class="ti ti-user-shield" aria-hidden="true"></i>
          <span>Masuk Petugas</span>
        </a>
      @endauth
    </div>
  </header>

  <main class="home-hero">
    <img src="{{ asset($heroImage) }}"
      alt="Gedung SMKN 4 Tanjungpinang"
      class="home-hero-image">
    <div class="home-overlay" aria-hidden="true"></div>

    <section class="home-copy" aria-labelledby="home-title">
      <h1 id="home-title">Buku Tamu Digital</h1>
      <p class="home-intro">Selamat datang. Pengunjung dapat memindai QR yang tersedia di meja penerima untuk mencatat kunjungan.</p>
      <a href="{{ auth()->check() ? (auth()->user()->role === \App\Models\User::ROLE_SUPERADMIN ? route('dashboard.index') : route('reception.index')) : route('login') }}" class="home-primary-action">
        <i class="ti ti-login" aria-hidden="true"></i>
        <span>{{ auth()->check() ? 'Buka Aplikasi' : 'Masuk Petugas' }}</span>
      </a>
    </section>
  </main>
</div>
@endsection
