<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/docs-app/css/dist/mdb5/standard/core.min.css">
  <link rel="stylesheet" href="../login-assets/css/style.css">
  <link rel="icon" href="../login-assets/img/logoGuest.ico">
</head>

<body>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-12 col-lg-11 col-xl-10">
        <div class="card d-flex mx-auto my-5">
          <div class="row">
            <div class="col-md-4 col-sm-12 col-xs-12 c1 pt-5 pb-5 ps-7 d-flex justify-content-center"">
              <div class="row mb-5 m-3">  </div> <img src="../login-assets/img/LogoXhool.png" width="250vw" height="300vh" class="mx-auto " alt="Teacher">
              
              @if(session()->has('success'))
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					{{ session('success') }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
				@endif
              <div class="row justify-content-center">
              </div>
            </div>
            <div class="col-md-7 col-sm-12 col-xs-12 c2 px-5">

				@if(session()->has('LoginEror'))
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					{{ session('LoginEror') }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
				@endif
              <form action="/login" onsubmit="" method="post" class="px-5 pb-5">
              @csrf
                <div class="d-flex">
                 
                  <h3 class="font-weight-bold">Log in</h3>
                </div> 
           
        @csrf
                <input type="text" placeholder="Nama" class="@error('nama')is-invalid @enderror" placeholder="nama@example" id="nama" name="nama" autofocus required value="{{ old('nama') }}">
                @error('nama')
                <div class="invalid-feedback">
							{{ $message }}
						</div>
            @enderror
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" class="text-white text-weight-bold bt">Submit</button>

                <small class="d-block text-center mt-3">Belum Punya Akun? <a href="/register">Register</a></small>
                <a href="/" class="d-block text-center mt-3">&laquo; Back to Home</a>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</html>