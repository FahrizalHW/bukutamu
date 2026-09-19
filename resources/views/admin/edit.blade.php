@extends('layouts.app')

@section('title', 'Edit Kunjungan')

@section('content')
<div class="page-heading">
  <p class="text-success fw-semibold mb-1">Data kunjungan</p>
  <h1>Edit pengunjung</h1>
</div>

<section class="form-surface">
  <form action="{{ route('rekap.update', $tamu) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row g-3">
      <div class="col-md-6">
        <label for="nama_tamu" class="form-label">Nama lengkap</label>
        <input id="nama_tamu" name="nama_tamu" class="form-control @error('nama_tamu') is-invalid @enderror"
          value="{{ old('nama_tamu', $tamu->nama_tamu) }}" required>
        @error('nama_tamu')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="col-md-6">
        <label for="nohp" class="form-label">Nomor HP</label>
        <input id="nohp" name="nohp" class="form-control @error('nohp') is-invalid @enderror"
          value="{{ old('nohp', $tamu->nohp) }}" maxlength="15" required>
        @error('nohp')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="col-md-6">
        <label for="asal" class="form-label">Asal instansi</label>
        <input id="asal" name="asal" class="form-control @error('asal') is-invalid @enderror"
          value="{{ old('asal', $tamu->asal) }}" required>
        @error('asal')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="col-md-6">
        <label for="jenis_kelamin" class="form-label">Jenis kelamin</label>
        <select id="jenis_kelamin" name="jenis_kelamin" class="form-select">
          <option value="">Tidak diisi</option>
          <option value="L" @selected(old('jenis_kelamin', $tamu->jenis_kelamin) === 'L')>Laki-laki</option>
          <option value="P" @selected(old('jenis_kelamin', $tamu->jenis_kelamin) === 'P')>Perempuan</option>
        </select>
      </div>
      <div class="col-12">
        <label for="tujuan" class="form-label">Tujuan kunjungan</label>
        <input id="tujuan" name="tujuan" class="form-control @error('tujuan') is-invalid @enderror"
          value="{{ old('tujuan', $tamu->tujuan) }}" maxlength="100" required>
        @error('tujuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="col-12">
        <label for="keterangan" class="form-label">Keterangan</label>
        <textarea id="keterangan" name="keterangan" rows="3" maxlength="255"
          class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $tamu->keterangan) }}</textarea>
        @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
    </div>
    <div class="d-flex gap-2 mt-4">
      <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i>Simpan</button>
      <a href="{{ route('rekap.show', $tamu) }}" class="btn btn-light">Batal</a>
    </div>
  </form>
</section>
@endsection
