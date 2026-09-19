@extends('layouts.app')

@section('title', 'Dashboard & Rekap')

@section('content')
<div class="page-heading d-flex flex-wrap justify-content-between align-items-center gap-3">
  <div>
    <p class="text-success fw-semibold mb-1">Administrasi</p>
    <h1>Dashboard & Rekap</h1>
  </div>
  <div class="d-flex gap-2">
    <a href="{{ route('rekap.export.excel', request()->query()) }}" class="btn btn-outline-success">
      <i class="ti ti-file-spreadsheet me-1"></i>Excel
    </a>
    <a href="{{ route('rekap.export.pdf', request()->query()) }}" class="btn btn-outline-danger">
      <i class="ti ti-file-type-pdf me-1"></i>PDF
    </a>
  </div>
</div>

<div class="stats-grid">
  <article class="stat-card stat-green">
    <i class="ti ti-calendar-event"></i>
    <div><span>Hari ini</span><strong>{{ number_format($todayCount) }}</strong></div>
  </article>
  <article class="stat-card stat-blue">
    <i class="ti ti-calendar-month"></i>
    <div><span>Bulan ini</span><strong>{{ number_format($monthCount) }}</strong></div>
  </article>
  <article class="stat-card stat-amber">
    <i class="ti ti-users"></i>
    <div><span>Total kunjungan</span><strong>{{ number_format($totalCount) }}</strong></div>
  </article>
</div>

<section class="dashboard-band">
  <div class="band-heading">
    <div>
      <h2>Tren 7 hari</h2>
      <p class="text-muted mb-0">Jumlah kunjungan per hari</p>
    </div>
  </div>
  @php($trendMax = max(1, $trend->max('total')))
  <div class="trend-chart" aria-label="Grafik tren kunjungan tujuh hari">
    @foreach($trend as $point)
      <div class="trend-item">
        <span class="trend-value">{{ $point['total'] }}</span>
        <div class="trend-track">
          <div class="trend-bar" style="height: {{ max(4, ($point['total'] / $trendMax) * 100) }}%"></div>
        </div>
        <span class="trend-label">{{ $point['label'] }}</span>
      </div>
    @endforeach
  </div>
</section>

<section class="dashboard-band">
  <div class="band-heading">
    <div>
      <h2>Data kunjungan</h2>
      <p class="text-muted mb-0">{{ number_format($visitor->total()) }} data sesuai filter</p>
    </div>
  </div>

  <form action="{{ route('rekap.index') }}" method="GET" class="filter-grid">
    <div class="filter-search">
      <label for="search" class="form-label">Pencarian</label>
      <div class="input-group">
        <span class="input-group-text"><i class="ti ti-search"></i></span>
        <input id="search" name="search" type="search" class="form-control"
          value="{{ $filters['search'] ?? '' }}" placeholder="Nama, instansi, atau nomor HP">
      </div>
    </div>
    <div>
      <label for="bulan" class="form-label">Bulan</label>
      <input id="bulan" name="bulan" type="month" class="form-control" value="{{ $filters['bulan'] ?? '' }}">
    </div>
    <div>
      <label for="tanggal_mulai" class="form-label">Dari tanggal</label>
      <input id="tanggal_mulai" name="tanggal_mulai" type="date" class="form-control"
        value="{{ $filters['tanggal_mulai'] ?? '' }}">
    </div>
    <div>
      <label for="tanggal_selesai" class="form-label">Sampai tanggal</label>
      <input id="tanggal_selesai" name="tanggal_selesai" type="date" class="form-control"
        value="{{ $filters['tanggal_selesai'] ?? '' }}">
    </div>
    <div>
      <label for="jenis_kelamin" class="form-label">Jenis kelamin</label>
      <select id="jenis_kelamin" name="jenis_kelamin" class="form-select">
        <option value="">Semua</option>
        <option value="L" @selected(($filters['jenis_kelamin'] ?? '') === 'L')>Laki-laki</option>
        <option value="P" @selected(($filters['jenis_kelamin'] ?? '') === 'P')>Perempuan</option>
      </select>
    </div>
    <div>
      <label for="per_page" class="form-label">Baris</label>
      <select id="per_page" name="per_page" class="form-select">
        @foreach([25, 50, 100] as $size)
          <option value="{{ $size }}" @selected($perPage === $size)>{{ $size }}</option>
        @endforeach
      </select>
    </div>
    <div class="filter-actions">
      <button type="submit" class="btn btn-primary"><i class="ti ti-filter me-1"></i>Terapkan</button>
      <a href="{{ route('rekap.index') }}" class="btn btn-light">Reset</a>
    </div>
  </form>

  <div class="table-responsive mt-4">
    <table class="table align-middle admin-table">
      <thead>
        <tr>
          <th>Pengunjung</th>
          <th>Waktu</th>
          <th>Asal</th>
          <th>Tujuan</th>
          <th>Kontak</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($visitor as $data)
          <tr>
            <td>
              <div class="d-flex align-items-center gap-3">
                <img src="{{ route('rekap.photo', $data) }}" alt="Foto {{ $data->nama_tamu }}"
                  class="visitor-thumb" loading="lazy">
                <div>
                  <strong class="d-block">{{ $data->nama_tamu }}</strong>
                  <span class="text-muted small">
                    {{ $data->jenis_kelamin === 'L' ? 'Laki-laki' : ($data->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
                  </span>
                </div>
              </div>
            </td>
            <td>{{ $data->tanggal->format('d-m-Y') }}<br><span class="text-muted small">{{ $data->tanggal->format('H:i') }}</span></td>
            <td>{{ $data->asal }}</td>
            <td>{{ $data->tujuan }}</td>
            <td>{{ $data->nohp }}</td>
            <td>
              <div class="d-flex justify-content-end gap-1 action-buttons">
                <a href="{{ route('rekap.show', $data) }}" class="btn btn-light btn-sm" title="Lihat detail">
                  <i class="ti ti-eye"></i>
                </a>
                <a href="{{ route('rekap.edit', $data) }}" class="btn btn-light btn-sm" title="Edit data">
                  <i class="ti ti-edit"></i>
                </a>
                <form action="{{ route('rekap.destroy', $data) }}" method="POST"
                  onsubmit="return confirm('Hapus data kunjungan {{ addslashes($data->nama_tamu) }}?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-light text-danger btn-sm" title="Hapus data">
                    <i class="ti ti-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6">
              <div class="empty-state">
                <i class="ti ti-database-off"></i>
                <strong>Belum ada data kunjungan</strong>
                <span>Ubah filter atau mulai catat kunjungan melalui form tamu.</span>
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mt-3">
    <span class="text-muted small">
      Menampilkan {{ $visitor->firstItem() ?? 0 }}-{{ $visitor->lastItem() ?? 0 }} dari {{ $visitor->total() }}
    </span>
    {{ $visitor->links() }}
  </div>
</section>
@endsection
