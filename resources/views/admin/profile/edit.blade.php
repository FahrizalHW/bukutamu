@extends('layouts.app')

@section('title', 'Profil Admin')

@section('content')
<div class="page-heading">
  <p class="text-success fw-semibold mb-1">Akun</p>
  <h1>Profil admin</h1>
</div>

<section class="form-surface">
  <form action="{{ route('profile.update') }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="row g-3">
      <div class="col-12">
        <label for="full_name" class="form-label">Nama lengkap</label>
        <input id="full_name" name="full_name"
          class="form-control @error('full_name') is-invalid @enderror"
          value="{{ old('full_name', auth()->user()->full_name) }}" maxlength="255" required>
        @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="col-12">
        <label for="username" class="form-label">Username</label>
        <input id="username" name="username"
          class="form-control @error('username') is-invalid @enderror"
          value="{{ old('username', auth()->user()->username) }}" maxlength="255" required>
        @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="col-md-6">
        <label for="password" class="form-label">Password baru</label>
        <input id="password" type="password" name="password"
          class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="col-md-6">
        <label for="password_confirmation" class="form-label">Ulangi password baru</label>
        <input id="password_confirmation" type="password" name="password_confirmation"
          class="form-control" autocomplete="new-password">
      </div>
    </div>
    <button type="submit" class="btn btn-primary mt-4">
      <i class="ti ti-device-floppy me-1"></i>Simpan Profil
    </button>
  </form>
</section>
@endsection
