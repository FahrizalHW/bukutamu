@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <table class="table datatables">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th>Foto</th>
              <th>Nama Tamu</th>
              <th>Asal Instansi</th>
              <th>Kontak</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($visitor as $data)
            <tr>
              <td class="text-center" width="80px">{{ $loop->index+1 }}</td>
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
