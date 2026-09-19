@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-heading d-flex flex-wrap justify-content-between align-items-center gap-3">
  <div>
    <p class="text-primary fw-semibold mb-1">Administrasi</p>
    <h1>Dashboard</h1>
  </div>
  <a href="{{ route('rekap.index') }}" class="btn btn-primary">
    <i class="ti ti-list-details me-1"></i>Rekap
  </a>
</div>

<div class="stats-grid">
  <article class="stat-card stat-primary">
    <i class="ti ti-calendar-event"></i>
    <div><span>Hari ini</span><strong>{{ number_format($todayCount) }}</strong></div>
  </article>
  <article class="stat-card stat-primary-soft">
    <i class="ti ti-calendar-month"></i>
    <div><span>Bulan ini</span><strong>{{ number_format($monthCount) }}</strong></div>
  </article>
  <article class="stat-card stat-primary-neutral">
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
@endsection
