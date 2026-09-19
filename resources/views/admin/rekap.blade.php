@extends('layouts.app')

@section('title', 'Rekap Kunjungan')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/libs/datatables/dataTables.bootstrap5.min.css') }}">
@endpush

@section('content')
<div class="page-heading d-flex flex-wrap justify-content-between align-items-center gap-3">
  <div>
    <p class="text-primary fw-semibold mb-1">Administrasi</p>
    <h1>Rekap Kunjungan</h1>
  </div>
  <div class="d-flex flex-wrap gap-2">
    <a id="export-excel" href="{{ route('rekap.export.excel') }}" class="btn btn-outline-primary">
      <i class="ti ti-file-spreadsheet me-1"></i>Excel
    </a>
    <a id="export-pdf" href="{{ route('rekap.export.pdf') }}" class="btn btn-outline-primary">
      <i class="ti ti-file-type-pdf me-1"></i>PDF
    </a>
  </div>
</div>

<section class="dashboard-band">
  <div class="band-heading">
    <div>
      <h2>Data kunjungan</h2>
      <p class="text-muted mb-0">Daftar kunjungan tersimpan</p>
    </div>
  </div>

  <form id="rekap-filters" class="rekap-filter-grid">
    <div>
      <label for="bulan" class="form-label">Bulan</label>
      <input id="bulan" name="bulan" type="month" class="form-control">
    </div>
    <div>
      <label for="tanggal_mulai" class="form-label">Dari tanggal</label>
      <input id="tanggal_mulai" name="tanggal_mulai" type="date" class="form-control">
    </div>
    <div>
      <label for="tanggal_selesai" class="form-label">Sampai tanggal</label>
      <input id="tanggal_selesai" name="tanggal_selesai" type="date" class="form-control">
    </div>
    <div class="filter-actions">
      <button type="submit" class="btn btn-primary"><i class="ti ti-filter me-1"></i>Terapkan</button>
      <button id="reset-filters" type="button" class="btn btn-light">Reset</button>
    </div>
  </form>

  <div class="rekap-table-wrap mt-4">
    <table id="visitor-table" class="table align-middle admin-table w-100"
      data-source="{{ route('rekap.data') }}"
      data-export-excel="{{ route('rekap.export.excel') }}"
      data-export-pdf="{{ route('rekap.export.pdf') }}">
      <thead>
        <tr>
          <th>Pengunjung</th>
          <th>Waktu</th>
          <th>Asal</th>
          <th>Tujuan</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</section>
@endsection

@push('scripts')
  <script src="{{ asset('assets/libs/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/libs/datatables/dataTables.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('assets/js/rekap-datatable.js') }}"></script>
@endpush