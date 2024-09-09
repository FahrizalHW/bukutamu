@extends ('includes.master')

@section('content')

<div class="col-md-6">
    <div class="card mb-4">
        <h3 class="card-header">EDIT PROFIL</h3>
        <form action="{{ route('profil.update',$profil->id) }}" method="POST">
        @csrf
            @method('PUT')
        <div class="card-body">
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingInput" placeholder="Nama" aria-describedby="floatingInputHelp" value="{{ $profil->nama }}" />
                <label for="floatingInput">Name</label>
                <div id="floatingInputHelp" class="form-text">
                </div>
            </div>
            <br>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingInput" placeholder="password" aria-describedby="floatingInputHelp" value="{{ $profil->nama }}" />
                <label for="floatingInput">Password</label>
                <div id="floatingInputHelp" class="form-text">
                </div>
            </div>
        </div>
        </form>
        
    </div>
</div>
@endsection