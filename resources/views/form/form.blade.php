@extends ('master-form.master')

@section('content')
<header>
    <a href="" class="brand">Buku Tamu</a>
    
    <div class="menu-btn">
        
        <div class="navigation">
            <div class="navigation-item">
                @auth
                <a href="/Admin">Admin</a>
                @else
                <a href="/login">Login</a>
                @endauth
                
                <a href="/">Home</a>
            </div>
        </div>
    </div>
</header>
<section class="home">
    <img src="assetsform/img/hand-painted-watercolor-background-with-sky-clouds-shape.png" alt="" class="imaged">
    <div class="content">
        <div class="guestbook-form">
            <h3>Form Buku Tamu</h3>
            <form action="{{route('tamu.store')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
               <label for="name">Name:</label>
                <input type="text" id="name" name="nama_tamu" required>

                <label for="gender">Gender:</label>
                <select id="gender" name="jenis_kelamin" required>
                    <option value="" hidden selected>Pilih Jenis Kelamin</option>
                    <option value="male">Laki-Laki</option>
                    <option value="female">Perempuan</option>
                </select>

                <label for="phone">No HP:</label>
                <input type="text" id="phone" name="nohp" required>

                <label for="institution">Asal Instansi:</label>
                <input type="text" id="institution" name="asal" required>

                <!-- input trigger Modal Tujuan -->
                <!-- <div class="icon-box wow fadeInUp" data-wow-delay="0.8s">
   <div id="wrap-input1">
      <input type="hidden" name="tujuan" id="id_akun">
      <input type="text" id="tujuan" readonly placeholder="Tujuan" class="input1" style="cursor: pointer;" data-toggle="modal" data-target="#tujuanModal" required oninvalid="this.setCustomValidity('MOHON DI PILIH')" oninput="setCustomValidity('')">
      <span class="shadow-input1"></span>
   </div>
</div> -->

<!-- Modal -->
<!-- <div class="modal fade" id="tujuanModal" tabindex="-1" role="dialog" aria-labelledby="tujuanModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="tujuanModalLabel">PILIH TUJUAN ANDA</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <table id="example" class="table table-striped table-bordered" style="width:100%; cursor: pointer;">
               <thead align="center">
                  <tr>
                     <th>NO</th>
                     <th>NAMA</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($akunTujuans as $data)
                  <tr class="tujuan-row" data-id="{{ $data->id }}" data-nama="{{ $data->nama }}">
                     <td align="center">{{ $loop->iteration }}</td>
                     <td>{{ $data->nama }}</td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div> -->


                <label for="tujuan">Tujuan:</label>
                <input type="text" id="tujuan" name="tujuan" required>
                

                <label for="purpose">Keterangan:</label>
                <textarea id="purpose" name="keterangan" rows="4" required></textarea>

                <label for="webcam">Camera</label>
                <div id="my_camera"></div>
                <br />
                <input type=button value="Take Snapshot" onClick="take_snapshot()">
                <input type="hidden" name="gambar" class="image-tag">
                <div id="results">Gambar akan muncul di sini</div>
                <!-- Upload button -->
                <label for="signature">Tanda Tangan:</label>
                <div class="signature-container">
                    <canvas class="signature-canvas" id="signature" width="auto" height="100%"></canvas>
                    <button type="button" id="clear-signature">Hapus Tanda Tangan</button>
                </div>
                <button type="submit">Done</button>
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
            </form>
        </div>
    </div>

</section>

@endsection