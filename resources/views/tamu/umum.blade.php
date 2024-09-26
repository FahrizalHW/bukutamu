@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <h1 class="text-center mb-4">Daftar Tamu</h1>
  <div class="row">
    @foreach($tamus as $tamu)
    <div class="col-md-6 mb-4">
      <!-- Bootstrap Card Component with Spacing Adjustment -->
      <div class="card mb-3" style="width: 100%; height: 100%; ">
        <div class="row g-0">
          <div class="col-md-7">
            <!-- Full-width image adjustment -->
            <img src="{{ asset('storage/uploads/' . $tamu->gambar) }}" class="img-fluid rounded-start " style="height: 108%" alt="{{ $tamu->nama_tamu }}">
          </div>
          <div class="col-md-5">
            <div class="card-body">
              <!-- Nama Tamu dengan font menarik -->
              <h5 class="card-title" style="font-family: 'Poppins', sans-serif; font-weight: 700; color: #2C3E50; font-size: 1.5rem; text-transform: capitalize; letter-spacing: 1px; text-shadow: 3px 3px 5px rgba(0,0,0,0.1);">
                {{ $tamu->nama_tamu }}
              </h5>

              <!-- Asal dengan gaya italic -->
              <p class="card-text" style="font-family: 'Roboto', sans-serif; font-weight: 500; font-size: 1.1rem; font-style: italic; margin-bottom: 10px;">
                Asal: {{ $tamu->asal }}
              </p>

              <!-- Timestamp dengan gaya lebih halus -->
              <p class="card-text" style="font-family: 'Lato', sans-serif; font-weight: 400; font-size: 0.9rem; color: #7F8C8D;">
                {{ \Carbon\Carbon::parse($tamu->tanggal)->format('d M Y, H:i') }}
              </p>
              
            </div>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <!-- Link Kembali ke Form -->
  <a href="{{ url('/') }}" class="back-link">Kembali ke Form</a>
  
  <style>
    .back-link {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 18px;
        font-weight: bold;
        text-decoration: none;
        color: #fff;
        background-color: #5A5A5A;
        padding: 10px 20px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .back-link:hover {
        background-color: #3A3A3A;
    }
  </style>
</div>
@endsection
