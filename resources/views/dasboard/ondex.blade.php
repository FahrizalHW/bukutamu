@extends ('includes.master')

@section('content')
@if(session('success'))
    <script>
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
@endif

<div class="card">
  <h5 class="card-header">Data Tamu</h5>
  <div class="table-responsive text-nowrap m-4">
    <table id="example" class="table table-striped" style="width:100%">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Tamu</th>
          <th>Gambar</th>
          <th>Jenis Kelamin</th>
          <th>Asal</th>
          <th>No Hp</th>
          <th>Tujuan</th>
          <th>Keterangan</th>
          <th>Tanggal</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($tamu as $tamu)
        <tr>
          <td>{{$tamu->id}}</td>
          <td>{{$tamu->nama_tamu}}</td>
          <td>{{$tamu->gambar}}</td>
          <td>{{$tamu->jenis_kelamin}}</td>
          <td>{{$tamu->asal}}</td>
          <td>{{$tamu->nohp}}</td>
          <td>{{$tamu->tujuan}}</td>
          <td>{{$tamu->keterangan}}</td>
          <td>{{$tamu->tanggal}}</td>
          <td>
            <form action="{{route('bulanan.destroy', $tamu->id)}}" method="POST" onsubmit="return confirmDelete(event)">
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

<script>
    function confirmDelete(event) {
        event.preventDefault(); // Stop the form from submitting immediately

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit(); // Submit the form if confirmed
            }
        })
    }
</script>
@endsection

<script>
  $(document).ready(function () {
      // Handle form submission
      $('form').on('submit', function (e) {
          e.preventDefault(); // Prevent the form from refreshing the page

          let formData = new FormData(this); // Create FormData object to handle file uploads

          $.ajax({
              url: "{{ route('tamu.store') }}", // Route untuk store tamu
              type: "POST",
              data: formData,
              contentType: false,
              processData: false,
              success: function (response) {
                  // Jika berhasil
                  Swal.fire({
                      title: 'Success!',
                      text: 'Tamu added successfully',
                      icon: 'success',
                      confirmButtonText: 'OK'
                  });

                  // Reset form
                  $('form')[0].reset();

                  // Tambahkan tamu baru ke tabel (jika ada tabel daftar tamu)
                  $('#guestbook-list').append(`
                      <tr>
                          <td>${response.id}</td>
                          <td>${response.nama_tamu}</td>
                          <td>${response.jenis_kelamin}</td>
                          <td>${response.asal}</td>
                          <td>${response.nohp}</td>
                          <td>${response.tujuan}</td>
                          <td>${response.keterangan}</td>
                          <td>${response.created_at}</td>
                      </tr>
                  `);
              },
              error: function (response) {
                  // Jika gagal
                  Swal.fire({
                      title: 'Error!',
                      text: 'There was a problem adding the guest.',
                      icon: 'error',
                      confirmButtonText: 'OK'
                  });
              }
          });
      });
  });
</script>

