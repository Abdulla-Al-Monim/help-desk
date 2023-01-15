@extends('layouts.custommaster')

								@section('content')

								<!--Login Page-->
								<div class="pb-3 px-5 pt-3">
									<h1 class="mb-2">Login</h1>
									<p class="text-muted  mb-0">Sign In to your account</p>
								</div>
								

								<form class="card-body border-top-0 pt-3" id="login" action="{{route('client.do_login')}}" method="post">
									@csrf
								

									<div class="form-group">
										<label class="form-label">Email  <span class="text-red">*</span></label>
										<input class="form-control  @error('email') is-invalid @enderror" placeholder="Email" type="email"
											value="{{old('email')}}" name="email" autocomplete="username">
										@error('email')

										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror

									</div>
									<div class="form-group">
										<label class="form-label">Password  <span class="text-red">*</span></label>
										<input class="form-control  @error('password') is-invalid @enderror" placeholder="password" type="password" name="password" autocomplete="current-password">
										@error('password')

										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror

									</div>
									<div class="form-group">
										<label class="custom-control form-checkbox">
											<input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember')
												? 'checked' : '' }}>
											<span class="custom-control-label">Remember me</span>
										</label>
									</div>
									
									<div class="submit">
										<input class="btn btn-secondary btn-block" type="submit" value="Login"
											onclick="this.disabled=true;this.form.submit();">
									</div>
									<div class="text-center mt-3">
										<a href="{{url('customer/forgotpassword')}}" class="text-primary pb-2">Forgot Password?</a>
										
										<p class="text-dark mb-0">Don’t have account?<a class="text-primary ms-1"
												href="{{route('auth.register')}}">Register</a></p>
										
										
										<p class="text-dark mb-0"><a class="text-primary ms-1" href="{{url('/')}}">Register</a></p>
									</div>
								</form>
								<!--Login Page-->
							
								@endsection
		@section('scripts')
		
		<!-- Captcha js-->
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>

		
		@endsection