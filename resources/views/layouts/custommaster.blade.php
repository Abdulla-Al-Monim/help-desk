<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
	<head>

		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="" name="description">
		<meta content="" name="author">
		<meta name="keywords" content=""/>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		
		<!-- Title -->
		<title>Afro Help Desk</title>

		
		<link rel="icon" href="{{asset('uploads/logo/favicons/favicon.ico')}}" type="image/x-icon"/>
		

		
		<!-- Bootstrap css -->
		<link href="{{asset('assets/plugins/bootstrap/css/bootstrap.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
	

		<!-- Style css -->
		<link href="{{asset('assets/css/style.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
		<link href="{{asset('assets/css/dark.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
		<link href="{{asset('assets/css/skin-modes.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
		<link href="{{asset('assets/css/updatestyles.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
		
		<!-- Animate css -->
		<link href="{{asset('assets/css/animated.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		<!---Icons css-->
		<link href="{{asset('assets/css/icons.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		<!--INTERNAL Toastr css -->
		<link href="{{asset('assets/plugins/toastr/toastr.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		

		<style>
			@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

		</style>


	</head>

	<body class="">

		<div class="page login-bg1">
			<div class="page-single">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-xl-4 col-lg-7 col-md-8 col-sm-9 col-10 p-md-0">
							<div class="card p-5">
								<div class="ps-4 pt-4 pb-2">
									<a class="header-brand" href="{{url('/')}}">
										
										
										<img src="{{asset('uploads/logo/darklogo/logo.png')}}" class="header-brand-img custom-logo"
											alt="logo">

										
									
									</a>
								</div>
								
							   @yield('content')

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Jquery js-->
		<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}?v=<?php echo time(); ?>"></script>

		<!-- Bootstrap4 js-->
		<script src="{{asset('assets/plugins/bootstrap/popper.min.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}?v=<?php echo time(); ?>"></script>

		<!--INTERNAL Toastr js -->
		<script src="{{asset('assets/plugins/toastr/toastr.min.js')}}?v=<?php echo time(); ?>"></script>

			@if (Session::has('error'))
				<script>
					toastr.error("{!! Session::get('error') !!}");
				</script>
			@elseif(Session::has('success'))
				<script>
					toastr.success("{!! Session::get('success') !!}");
				</script>
			@elseif(Session::has('info'))
				<script>
					toastr.info("{!! Session::get('info') !!}");
				</script>
			@elseif(Session::has('warning'))
				<script>
					toastr.warning("{!! Session::get('warning') !!}");
				</script>
			@endif
			
			@yield('scripts')
			
			@yield('modal')
	</body>
</html>