<!DOCTYPE html>
<html lang="en">

  <head>
  	@section('head')
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	   
	    <!-- Bootstrap -->
	    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
	    <link href="/css/style.css" rel="stylesheet"/>

	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
	@show
    
  </head>
  <body>
  	<div class="container">
  		<div class="header">
			<ul class="nav navbar-nav navbar-right" role="navigation">
				<li class="active">
					<a href="#"><img src="/images/lines.png" /></a>
				</li>
				<li>
					<a href="#">Signup</a>
				</li>
			</ul>
			<!-- <h3 class="text-muted">Project name</h3> -->
			<img src="/images/logo.png" width="200" height="80"/>
		</div>
		<br/><br/>
		<div class="row marketing">
			@yield('content')
		</div>

	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="/js/site.js"></script>
  </body>
</html>