<!DOCTYPE html>
<html lang="en">

  <head>
  	@section('head')
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	   	<link href='https://fonts.googleapis.com/css?family=Raleway:400,200,600,700,800,900,500,100,300' rel='stylesheet' type='text/css'>
	   	<link id="divi-fonts-css" media="all" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,700italic,800italic,400,300,700,800&subset=latin,latin-ext" rel="stylesheet">
	    <!-- Bootstrap -->
	    <link href="<?php echo url();?>/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
	    <link href="<?php echo url();?>/css/style1.css" rel="stylesheet"/>
	    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  	

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
  	<div id="amazon-root"></div>
	<script type="text/javascript">

	  window.onAmazonLoginReady = function() {
	    amazon.Login.setClientId('amzn1.application-oa2-client.3032012dedb74c53bcf3e0d3e140e44e');
	  };
	  (function(d) {
	    var a = d.createElement('script'); a.type = 'text/javascript';
	    a.async = true; a.id = 'amazon-login-sdk';
	    a.src = 'https://api-cdn.amazon.com/sdk/login1.js';
	    d.getElementById('amazon-root').appendChild(a);
	  })(document);

	</script>
  	
  	<nav class="navbar navbar-inverse fixed" role="navigation" id="header-section">
		<div class="container header-container">
		<div class="row">
			<div class="site-logo col-xs-3 col-sm-3 col-lg-3">
				<img src="/images/logo.png" width="200" height="80"/>
			</div>			
			<div class="nav-section col-xs-9 col-sm-9 col-lg-9" style="text-align:right">
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
							<a href="http://bww.gfdev.net/news/">News</a>
						</li>
						<li>
							<a href="http://bww.gfdev.net/aboutus/">About Us</a>
						</li>
						<li>
							<a href="http://bww.gfdev.net/#support">Support</a>
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
							<a href="http://bww.gfdev.net/symfony/web/en/selfcare/login">Sign In</a>
						</li>
					</ul><br/>
					<ul class="nav navbar-nav" role="navigation" id="menu-utility-menu">
						<li>
							<a href="http://bww.gfdev.net/#mission">Phone for Phone</a>
						</li>
						<li>
							<a href="http://bww.gfdev.net/#devices-plans">Devices & Plans</a>
						</li>
						<li>
							<a href="http://bww.gfdev.net/#coverage">Coverage</a>
						</li>
						<li>
							<a href="http://bww.gfdev.net/#signup" title="sign up">Sign Up</a>
						</li>						
					</ul>
				</div>
			</div>
			</div>
		</div>

		<div class="orange-border fixed">
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
  	<script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo url();?>/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo url();?>/js/jquery.scrollTo.min.js"></script>
    <script src="<?php echo url();?>/js/waypoints.min.js"></script>
    <script src="<?php echo url();?>/js/main1.js"></script>
  </body>
</html>
