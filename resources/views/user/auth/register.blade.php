@extends('layouts.custommaster')
								@section('content')
								
								<!--Register Page-->
								<div class="p-5 pt-0">
									<h1 class="mb-2">Register</h1>
									<p class="text-muted">Create new account</p>
								</div>

								

								<div class="login-icons card-body border br-7 mx-5 my-3 p-4 d-flex align-items-center justify-content-center">
										

										
								<form class="card-body border-top-0 pt-3" method="post" action="{{route('auth.register')}}">
									@csrf
									<div class="form-group row">
										<div class="col-sm-6 col-md-6 mb-2 mb-sm-0">
											<label class="form-label">First Name </label>
											<input class="form-control @error('firstname') is-invalid @enderror" placeholder="Firstname" type="text"
												name="firstname" value="{{old('firstname')}}" >
											@error('firstname')

											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror

										</div>
										<div class="col-sm-6 col-md-6">
											<label class="form-label">Last Name </label>
											<input class="form-control @error('lastname') is-invalid @enderror" placeholder="Lastname" type="text"
												name="lastname" value="{{old('lastname')}}" >
											@error('lastname')

											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror

										</div>
										
									</div>
									<div class="form-group">
										<label class="form-label">Email </label>
										<input class="form-control @error('email') is-invalid @enderror" placeholder="Email" type="email" name="email"
											value="{{old('email')}}" autocomplete="username">
										@error('email')

										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror

									</div>
									<div class="form-group">
										<label class="form-label">Password </label>
										<input class="form-control @error('password') is-invalid @enderror" placeholder="password" type="password"
											name="password" autocomplete="new-password">
										@error('password')

										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror

									</div>
									<div class="form-group">
										<label class="form-label">Confirm Password </label>
										<input class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="password"
											type="password" name="password_confirmation" autocomplete="new-password">
										@error('password_confirmation')

										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror

									</div>
									<div class="submit">
										<input type="submit" class="btn btn-secondary btn-block" value="Create Account"
											onclick="this.disabled=true;this.form.submit();" />

									</div>
									<div class="text-center mt-4">
										<p class="text-dark mb-0">Already have an account?<a class="text-primary ms-1"
												href="{{url('customer/login')}}">Login</a></p>
										<p class="text-dark mb-0"><a class="text-primary ms-1" href="{{url('/')}}">Back to home</a></p>

									</div>
								</form>
								<!--Register Page-->
							
								@endsection
		@section('scripts')

		<!-- Captcha Js-->
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
		
		
		@endsection