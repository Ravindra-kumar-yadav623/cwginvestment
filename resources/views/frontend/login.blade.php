<!doctype html>
<html lang="en">

<head>
	<title>Capital Wealth Growth</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

</head>

<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">Capital Wealth Growth</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-7 col-lg-5">
					<div class="wrap">
						<div><img src="{{asset('assets/images/bg-1.jpg')}}" alt=""></div>
						<div class="login-wrap p-4 p-md-5">
							<div class="d-flex">
								<div class="w-100">
									<h3 class="mb-4">Sign In</h3>
								</div>
								<div class="w-100">
									<p class="social-media d-flex justify-content-end">
										<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
										<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-twitter"></span></a>
									</p>
								</div>
							</div>

							@if(session('success'))
							<div class="alert alert-success">{{ session('success') }}</div>
							@endif

							@if(session('error'))
							<div class="alert alert-danger">{{ session('error') }}</div>
							@endif

							@if($errors->any())
							<div class="alert alert-danger">
								<ul class="mb-0">
									@foreach($errors->all() as $error)
									<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
							@endif
							<form method="POST" action="{{ route('login.post') }}" class="signin-form">
								@csrf

								<div class="form-group mt-3">
									<input type="text"
										name="username"
										class="form-control @error('username') is-invalid @enderror"
										value="{{ old('username') }}"
										required>
									<label class="form-control-placeholder" for="username">Username</label>
									@error('username')
										<span class="text-danger small">{{ $message }}</span>
									@enderror
								</div>

								<div class="form-group">
									<input id="password-field"
										type="password"
										name="password"
										class="form-control @error('password') is-invalid @enderror"
										required>
									<label class="form-control-placeholder" for="password">Password</label>
									<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
									@error('password')
										<span class="text-danger small">{{ $message }}</span>
									@enderror
								</div>
								
								<div class="form-group">
									<button type="submit" name="login_user" class="form-control btn btn-primary rounded submit px-3">Sign In</button>
								</div>
								<div class="form-group d-md-flex">
									<div class="w-50 text-left">
									<label class="checkbox-wrap checkbox-primary mb-0">Remember Me
										<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
										<span class="checkmark"></span>
									</label>
									</div>
									<div class="w-50 text-md-right">
										<a href="#">Forgot Password</a>
									</div>
								</div>
							</form>
							<p class="text-center">
								Not a member? <a href="{{ route('register') }}">Sign Up</a>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="{{asset('assets/js/jquery.min.js')}}"></script>
	<script src="{{asset('assets/js/popper.js')}}"></script>
	<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('assets/js/main.js')}}"></script>

</body>

</html>