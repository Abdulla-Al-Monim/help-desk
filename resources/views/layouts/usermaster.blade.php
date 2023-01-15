<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		@include('includes.styles')
		
		

	</head>

	<body class="">

				@include('includes.user.mobileheader')

				@include('includes.user.menu')

				<div class="page">
					<div class="page-main">

							@yield('content')


					</div>
				</div>

				@include('includes.footer')
		@include('includes.scripts')

	


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

	
	
	@yield('modal')

</body>

</html>