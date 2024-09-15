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
          <td>
            <img src="{{ asset('storage/uploads/'.$tamu->gambar) }}" alt="Gambar" width="100">
          </td>
          <td>{{$tamu->jenis_kelamin}}</td>
          <td>{{$tamu->asal}}</td>
          <td>{{$tamu->nohp}}</td>
          <td>{{$tamu->tujuan}}</td>
          <td>{{$tamu->keterangan}}</td>
          <td>{{$tamu->tanggal}}</td>
          <td>
            <form id="deleteForm-{{$tamu->id}}" action="{{route('bulanan.destroy', $tamu->id)}}" method="POST" onsubmit="return confirmDelete(event, '{{$tamu->id}}')">
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
    function confirmDelete(event, formId) {
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
                document.getElementById('deleteForm-' + formId).submit(); // Submit the form with the specific ID if confirmed
            }
        });
    }
</script>
@endsection
