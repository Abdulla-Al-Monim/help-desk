		<!-- Meta data -->
		

		<link rel="icon" href="{{asset('uploads/logo/favicons/favicon.ico')}}" type="image/x-icon"/>

	


		<link href="{{asset('assets/plugins/bootstrap/css/bootstrap.css')}}>" rel="stylesheet" />
		

		<!-- Style css -->
		<link href="{{asset('assets/css/style.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
		<link href="{{asset('assets/css/updatestyles.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
		<link href="{{asset('assets/css/dark.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		<!-- Animate css -->
		<link href="{{asset('assets/css/animated.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		<!-- P-scroll bar css-->
		<link href="{{asset('assets/plugins/p-scrollbar/p-scrollbar.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		<!---Icons css-->
		<link href="{{asset('assets/css/icons.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		<!-- Select2 css -->
		<link href="{{asset('assets/plugins/select2/select2.min.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		<!--INTERNAL Toastr css -->
		<link href="{{asset('assets/plugins/toastr/toastr.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		<!-- INTERNAL Sweet-Alert css -->
		<link href="{{asset('assets/plugins/sweet-alert/sweetalert.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		@yield('styles')

		
	<style>
			:root {
		--primary:var(--secondary);
		--secondary:var(--primary);
			}

		</style>

		
		<!-- Google Fonts -->
		<style>
			
			@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

		</style>
