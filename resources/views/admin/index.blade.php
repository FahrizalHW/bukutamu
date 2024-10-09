@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4">Rekap Pengunjung</h5>
      <div class="row">
        <div class="col-md-4 col-12">
          <form action="{{ route('rekap.filter') }}" method="GET" class="mb-3">
            <div class="input-group">
              <label class="input-group-text" for="filterBulan">Filter Bulan</label>
              <select class="form-select" id="filterBulan" name="bulan">
                <option value="">Pilih Bulan</option>
                <option value="01">Januari</option>
                <option value="02">Februari</option>
                <option value="03">Maret</option>
                <option value="04">April</option>
                <option value="05">Mei</option>
                <option value="06">Juni</option>
                <option value="07">Juli</option>
                <option value="08">Agustus</option>
                <option value="09">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
              </select>
              <button type="submit" class="btn btn-primary">Filter</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Table Data -->
      <div class="row">
        <table class="table datatables">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th>Tanggal</th>
              <th>Foto</th>
              <th>Nama Tamu</th>
              <th>Asal Instansi</th>
              <th>Kontak</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($visitor as $data)
            <tr>
              <td class="text-center" width="80px">{{ $loop->index + 1 }}</td>
              <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y') }}</td>
              <td class="text-center" width="200px">
                <img src="{{ asset('storage/uploads/' . $data->gambar) }}" alt="Foto Tamu" width="200">
              </td>
              <td>{{ $data->nama_tamu }}</td>
              <td>{{ $data->asal }}</td>
              <td>{{ $data->nohp }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
