<!doctype html>
<html lang="en">
<head>
	@section('head')
	<meta charset="UTF-8">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="/css/style.css"/>
	@show
</head>
<body>
	<div class="navbar">
		<div class="container">
			<div  class="navbar-header">
				<button type="button" class="navbar-toogle" data-toggle="collapse" data-target=".navbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<a href="{{ URL::route('home') }}" class="navbar-brand">Laravel Forum Software</a>
			<div class="navbar-collapse collapse navbar-responsive-collapse">
				<ul class="nav navbar-nav">
					<li><a href="{{ URL::route('home') }}" class="navbar-brand active">Home</a></li>
					<li><a href="{{ URL::route('forum-home') }}" class="navbar-brand active">Forums</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					@if(!Auth::check())
						<li><a href="{{ URL::route('getCreate') }}" class="navbar-brand">Register</a></li>
						<li><a href="{{ URL::route('getLogin') }}" class="navbar-brand">Login</a></li>
					@else
						<li><a href="{{ URL::route('getLogout') }}" class="navbar-brand">Logout</a></li>
					@endif
					
				</ul>
			</div>
		</div>
	</div>
	<div class="container">
		@yield('content')
	</div>
	<!-- Latest compiled and minified JavaScript -->
	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</body>
</html>
