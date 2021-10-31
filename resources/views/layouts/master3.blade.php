<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Author" content="Momtaz Nussair">
		@livewireStyles()
		@include('layouts.head')
	</head>
	
	<body class="main-body app">
		<!-- Loader -->
		<div id="global-loader">
			<img src="{{URL::asset('assets/img/loader.svg')}}" class="loader-img" alt="Loader">
		</div>
        @include('layouts.user-header')
		<!-- /Loader -->
		@yield('content')
		@include('layouts.footer')
		@include('layouts.footer-scripts')	
	</body>
</html>