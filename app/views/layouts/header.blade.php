<!DOCTYPE html>
<html lang="en">

  <head>
  	@section('head')
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	   	<link href='http://fonts.googleapis.com/css?family=Raleway:400,200,600,700,800,900,500,100,300' rel='stylesheet' type='text/css'>
	   	<link id="divi-fonts-css" media="all" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,700italic,800italic,400,300,700,800&subset=latin,latin-ext" rel="stylesheet">
	    <!-- Bootstrap -->
	    <link href="<?php echo url();?>/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
	    <link href="<?php echo url();?>/css/style.css" rel="stylesheet"/>
	    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  	

	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->


	    <script type="text/javascript">
	    	var baseurl = location.protocol + "//" + location.host + '/';
	    </script>
	@show
    
  </head>
  <body>
  	<nav class="navbar navbar-inverse" role="navigation" id="header-section">
		<div class="container header-container">
			<div class="col-xs-4 col-sm-4 col-lg-4">
				<img src="/images/logo.png" width="200" height="80"/>
			</div>			
			<div class="col-xs-8 col-sm-8 col-lg-8" style="text-align:right">
				<div class="navbar-header">
					<button class="navbar-toggle collapsed" aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" type="button">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					
				</div>
				<div id="navbar" class="navbar-collapse collapse pull-right" aria-expanded="false" style="height: 1px;">
			
					<ul class="nav navbar-nav" role="navigation" id="topnav">
							<li>
							<a href="https://www.betterworldwireless.com/news/">News</a>
						</li>
						<li>
							<a href="https://www.betterworldwireless.com/aboutus/">About Us</a>
						</li>
						<li>
							<a href="https://www.betterworldwireless.com/#support">Support</a>
						</li>
						<li>
							<a href="tel:8448461653">844-846-1653</a>
						</li>
						<li>
							<a href="http://www.facebook.com/betterworldwireless" target="_blank" class="socialmedia">
								<i class="social-network facebook"></i>
							</a>
						</li>
						<li>
							<a href="http://twitter.com/phone4phone" target="_blank" class="socialmedia">
								<i class="social-network twitter"></i>
							</a>
						</li>
						<li>
							<a href="http://www.linkedin.com/company/3535955?trk=tyah&trkInfo=tas%3Abetterworld%20%2Cidx%3A1-2-2" target="_blank"  class="socialmedia">
								<i class="social-network linkedin"></i>
							</a>
						</li>
						<li>
							<a href="https://www.betterworldwireless.com/symfony/web/en/selfcare/login">Sign In</a>
						</li>
					</ul><br/>
					<ul class="nav navbar-nav" role="navigation" id="menu-utility-menu">
						<li>
							<a href="https://www.betterworldwireless.com/#mission">Phone for Phone</a>
						</li>
						<li>
							<a href="https://www.betterworldwireless.com/#devices-plans">Devices & Plans</a>
						</li>
						<li>
							<a href="https://www.betterworldwireless.com/#coverage">Coverage</a>
						</li>
						<li>
							<a href="https://www.betterworldwireless.com/#signup" title="sign up">Sign Up</a>
						</li>
						
					</ul>
				</div>
			</div>
		</div>

		<div class="orange-border">
			<img src="<?php echo url();?>/images/back_button.jpg" class="pull-left" id="back-button" style="display:none">
			<img src="<?php echo url();?>/images/cart_icon.png" class="pull-right" id="back-button" cid="">
		</div>
	</nav>
	
	<div class="container">
		<div class="row" style="padding:0 20px;margin-top:20px">
			@yield('content')
		</div>
	</div>
	<div class="clearfix"></div>
	<br/><br/><br/>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
  	<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo url();?>/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo url();?>/js/main.js"></script>
  </body>
</html>