@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Tamu</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Informasi Tamu</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tamus as $tamu)
            <tr>
                <td>
                    <div class="tamu-container">
                        <div class="tamu-image">
                            <img src="{{ asset('storage/uploads/' . $tamu->gambar) }}" alt="{{ $tamu->nama_tamu }}">
                        </div>
                        <div class="tamu-info">
                            <h4>{{ $tamu->nama_tamu }}</h4>
                            <p>Asal: {{ $tamu->asal }}</p>
                        </div>
                    </div>
                    
                    
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
