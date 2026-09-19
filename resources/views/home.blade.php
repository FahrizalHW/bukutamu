@extends('layouts.base')

@section('title', 'Buku Tamu SMKN 4 Tanjungpinang')

@php
  $heroImage = 'assets/images/backgrounds/smkn4-tanjungpinang-hero.png';
@endphp

@section('content')
<div class="home-page">
  <header class="public-nav">
    <div class="home-nav-inner">
      <a href="{{ route('home') }}" class="public-brand" aria-label="Buku Tamu SMKN 4 Tanjungpinang">
        <span class="public-brand-mark">
          <img src="{{ asset('assets/images/logos/smkn4tpi.png') }}" alt="" width="46" height="46">
        </span>
        <span class="public-brand-copy">
          <strong>Buku Tamu</strong>
          <small>SMKN 4 Tanjungpinang</small>
        </span>
      </a>

      @auth
        <a href="{{ route('rekap.index') }}" class="home-admin-link">
          <i class="ti ti-layout-dashboard" aria-hidden="true"></i>
          <span>Dashboard</span>
        </a>
      @else
        <a href="{{ route('login') }}" class="home-admin-link">
          <i class="ti ti-user-shield" aria-hidden="true"></i>
          <span>Admin</span>
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
      <p class="home-intro">Selamat datang. Silakan catat kunjungan Anda untuk membantu kami memberikan pelayanan yang lebih baik.</p>
      <a href="{{ route('tamu.create') }}" class="home-primary-action">
        <i class="ti ti-user-plus" aria-hidden="true"></i>
        <span>Isi Buku Tamu</span>
      </a>
    </section>
  </main>
</div>
@endsection
