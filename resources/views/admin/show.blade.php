@extends('layouts.app')

@section('title', 'Detail Kunjungan')

@section('content')
<div class="page-heading d-flex justify-content-between align-items-center gap-3">
  <div>
    <p class="text-primary fw-semibold mb-1">Data kunjungan</p>
    <h1>Detail pengunjung</h1>
  </div>
  <div class="d-flex gap-2">
    <a href="{{ route('rekap.edit', $tamu) }}" class="btn btn-primary"><i class="ti ti-edit me-1"></i>Edit</a>
    <a href="{{ route('rekap.index') }}" class="btn btn-light">Kembali</a>
  </div>
</div>

<section class="detail-layout">
  <div class="detail-photo">
    <img src="{{ route('rekap.photo', $tamu) }}" alt="Foto {{ $tamu->nama_tamu }}">
  </div>
  <dl class="detail-list">
    <div><dt>Nama</dt><dd>{{ $tamu->nama_tamu }}</dd></div>
    <div><dt>Waktu kunjungan</dt><dd>{{ $tamu->tanggal->format('d-m-Y H:i') }}</dd></div>
    <div><dt>Jenis kelamin</dt><dd>{{ $tamu->jenis_kelamin === 'L' ? 'Laki-laki' : ($tamu->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}</dd></div>
    <div><dt>Nomor HP</dt><dd>{{ $tamu->nohp }}</dd></div>
    <div><dt>Asal instansi</dt><dd>{{ $tamu->asal }}</dd></div>
    <div><dt>Tujuan</dt><dd>{{ $tamu->tujuan }}</dd></div>
    <div><dt>Keterangan</dt><dd>{{ $tamu->keterangan ?: '-' }}</dd></div>
  </dl>
</section>
@endsection
