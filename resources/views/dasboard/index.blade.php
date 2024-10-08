@extends('layouts.app')
@section('content')

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="card-header">Data Tamu</h5>
    <form action="{{ route('bulanan.filter') }}" method="GET" class="form-inline">
      <select name="bulan" class="form-control" onchange="this.form.submit()">
        <option value="">-- Pilih Bulan --</option>
        @foreach(range(1, 12) as $month)
          <option value="{{ $month }}" {{ request('bulan') == $month ? 'selected' : '' }}>
            {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}
          </option>
        @endforeach
      </select>
    </form>
  </div>
  <div class="card-body">
    <div class="table-responsive text-nowrap m-4">
      <table id="datatables" class="table table-striped" style="width:100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Tamu</th>
            <!-- <th>Gambar</th> -->
            <th>Jenis Kelamin</th>
            <th>Asal</th>
            <th>No Hp</th>
            <th>Tujuan</th>
            <!-- <th>Keterangan</th> -->
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($tamu as $data)
          <tr>
            <td>{{ $loop->index+1 }}</td>
            <td>{{$data->tanggal}}</td>
            <td>{{$data->nama_tamu}}</td>
            <!-- <td>
              <img src="{{ asset('storage/uploads/'.$tamu->gambar) }}" alt="Gambar" width="100">
            </td> -->
            <td>{{$data->jenis_kelamin}}</td>
            <td>{{$data->asal}}</td>
            <td>{{$data->nohp}}</td>
            <td>{{$data->tujuan}}</td>
            <!-- <td>{{$tamu->keterangan}}</td> -->
            <td>
              <form action="{{route('bulanan.destroy', $tamu->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                  <i class="fas fa-trash"></i><span class="ml-1">Delete</span>
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection