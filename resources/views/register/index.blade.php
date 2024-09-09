<!doctype html>
<html lang="en">
  <head>
  	<title>Register</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/docs-app/css/dist/mdb5/standard/core.min.css">
  <link rel="stylesheet" href="../login-assets/css/style.css">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="assetsacc/css/style.css">

	</head>
	<body>
	
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-5">
					<div class="login-wrap p-4 p-md-5">
		      	<div class="icon d-flex align-items-center justify-content-center">
		      		<span class="fa fa-user-o"></span>
		      	</div>
		      	<h3 class="text-center mb-4"><a href="">Register</a></h3>
						<form action="/register" class="login-form" method="post">
							@csrf
				<div class="form-floating">
					
		      			<input type="text" class="form-control rounded-left @error('nama')is-invalid @enderror" placeholder="Nama" id="nama" name="nama" required value="{{ old('nama') }}">
						  <label for="nama">nama</label>
						@error('name')
						<div class="invalid-feedback">
        					{{ $message }}
      					</div>
						  @enderror
		      		</div>
                      <div class="form-floating">
		      			<input type="email" class="form-control rounded-left @error('email')is-invalid @enderror" placeholder="Username@Example" id="email" name="email" required value="{{ old('email') }}">
						 <label for="email">Email</label>
						@error('email')
						<div class="invalid-feedback">
        					{{ $message }}
      					</div>
						  @enderror
		      		</div>
	            <div class="form-floating">
	              <input type="password" class="form-control rounded-left @error('password')is-invalid @enderror" placeholder="Password" id="password" name="password"  required>
				  <label for="password">Password</label>
				  @error('email')
						<div class="invalid-feedback">
        					{{ $message }}
      					</div>
						  @enderror
	            </div>
	            <div class="form-floating">
	            	<button type="submit" class="btn btn-primary rounded submit p-3 px-5">Register</button>
						<small class="d-block text-center mt-3">Sudah Terdaftar? <a href="/login">Login</a></small>
						<a href="/" class="d-block text-center mt-3">&laquo; Back to Home</a>
	            </div>
	          </form>
	        </div>
				</div>
			</div>
		</div>


	<script src="assetsacc/js/jquery.min.js"></script>
  <script src="assetsacc/js/popper.js"></script>
  <script src="assetsacc/js/bootstrap.min.js"></script>
  <script src="assetsacc/js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

	</body>
</html>

