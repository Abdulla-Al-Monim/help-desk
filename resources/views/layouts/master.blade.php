<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Afro Help Desk</title>
	@include('includes.header')
	@include('includes.styles')
</head>
<body>
	@include('includes.user.mobileheader')

	@include('includes.menu')

	<div class="page page-1">
		<div class="page-main">

				@yield('content')

				@include('includes.footer')

    	@include('includes.scripts')

		</div>
	</div>

</body>
</html>