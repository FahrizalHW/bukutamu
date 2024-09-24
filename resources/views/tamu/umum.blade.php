@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <h1 class="text-center mb-4">Daftar Tamu</h1>
  <div class="row">
    @foreach($tamus as $tamu)
    <div class="col-md-4 mb-4">
      <div class="card">
        <img src="{{ asset('storage/uploads/' . $tamu->gambar) }}" class="card-img-top" alt="{{ $tamu->nama_tamu }}" data-toggle="modal" data-target="#imageModal" data-image="{{ asset('storage/uploads/' . $tamu->gambar) }}" data-nama="{{ $tamu->nama_tamu }}" data-asal="{{ $tamu->asal }}" style="cursor: pointer;">
        <div class="card-body">
          <h5 class="card-title">{{ $tamu->nama_tamu }}</h5>
          <p class="card-text">Asal: {{ $tamu->asal }}</p>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <!-- Link Kembali ke Form -->
  <a href="{{ url('/') }}" class="back-link">Kembali ke Form</a>
  
  <!-- Modal untuk menampilkan gambar dan informasi -->
  <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="imageModalLabel">Detail Tamu</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body row">
          <div class="col-md-6">
            <img src="" id="modalImage" class="img-fluid" alt="Gambar Tamu">
          </div>
          <div class="col-md-6">
            <h5 id="modalName"></h5>
            <p id="modalOrigin"></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    .back-link {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 18px; /* Ukuran font sesuai dengan preferensi */
        font-weight: bold; /* Agar teks lebih tegas */
        text-decoration: none; /* Hilangkan garis bawah */
        color: #fff; /* Warna teks */
        background-color: #5A5A5A; /* Warna latar belakang */
        padding: 10px 20px; /* Padding dalam tombol */
        border-radius: 5px; /* Membuat sudut membulat */
        transition: background-color 0.3s ease; /* Animasi saat hover */
    }

    .back-link:hover {
        background-color: #3A3A3A; /* Warna saat di-hover */
    }
  </style>

</div>

<script>
  // JavaScript untuk mengubah gambar dan informasi dalam modal saat gambar diklik
  $(document).on('click', 'img[data-toggle="modal"]', function() {
    var imageSrc = $(this).data('image');
    var name = $(this).data('nama');
    var origin = $(this).data('asal');

    $('#modalImage').attr('src', imageSrc);
    $('#modalName').text(name);
    $('#modalOrigin').text('Asal: ' + origin);
  });
</script>

@endsection
