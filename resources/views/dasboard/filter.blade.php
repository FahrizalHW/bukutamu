@extends ('includes.master')

@section('content')
<div class="card">
  <h5 class="card-header">Data Tamu</h5>
  <div class="table-responsive text-nowrap m-4">
  <label for="daterange">Filter by Date Range:</label>
        <input type="text" name="daterange" id="daterange" value="01/01/2015 - 01/31/2015" />
        <br>
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
            
            <form action="{{route('bulanan.destroy',$tamu->id)}}" method="POST">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i><span class="ml-1">Delete</span></button>
            </form>
          </td>
        </tr>
        @endforeach
  </div>
</div>
<script>
    $(document).ready(function () {
        $('#daterange').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear',
            },
        });

        $('#daterange').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            // Trigger data filtering based on the selected date range
            filterDataByDate(picker.startDate, picker.endDate);
        });

        $('#daterange').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
            // Reset data to show all records
            resetData();
        });

        // Your DataTable initialization script here
        new DataTable('#example');

        // Function to filter data based on the selected date range
        function filterDataByDate(startDate, endDate) {
            // Implement your logic to filter data and update the table
            // For example:
            // 1. Make an AJAX request to get filtered data
            // 2. Update the table with the new data
        }

        // Function to reset data and show all records
        function resetData() {
            // Implement your logic to reset data and show all records
            // For example:
            // 1. Make an AJAX request to get all data
            // 2. Update the table with the new data
        }
    });
</script>
@endsection