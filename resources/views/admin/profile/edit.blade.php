@extends('layouts.app')

@section('title', 'Profil Admin')

@section('content')
<div class="page-heading d-flex flex-wrap justify-content-between align-items-center gap-3">
  <div>
    <p class="text-primary fw-semibold mb-1">Administrasi</p>
    <h1>Profil Admin</h1>
  </div>
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
        <div class="password-field">
          <input id="password" type="password" name="password"
            class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">
          <button type="button" class="password-toggle-button" data-password-toggle="password"
            aria-label="Tampilkan password baru" aria-controls="password" aria-pressed="false" title="Tampilkan password baru">
            <i class="ti ti-eye" aria-hidden="true"></i>
          </button>
        </div>
        @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
      </div>
      <div class="col-md-6">
        <label for="password_confirmation" class="form-label">Ulangi password baru</label>
        <div class="password-field">
          <input id="password_confirmation" type="password" name="password_confirmation"
            class="form-control" autocomplete="new-password">
          <button type="button" class="password-toggle-button" data-password-toggle="password_confirmation"
            aria-label="Tampilkan konfirmasi password" aria-controls="password_confirmation" aria-pressed="false" title="Tampilkan konfirmasi password">
            <i class="ti ti-eye" aria-hidden="true"></i>
          </button>
        </div>
      </div>
    </div>
    <button type="submit" class="btn btn-primary mt-4">
      <i class="ti ti-device-floppy me-1"></i>Simpan Profil
    </button>
  </form>
</section>
@endsection

@push('scripts')
  <script src="{{ asset('assets/js/password-toggle.js') }}"></script>
@endpush
