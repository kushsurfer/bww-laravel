@extends('layouts.header1')

@section('head')
    @parent
    <title>Shop Page</title>
@stop

@section('content')
	<div class="row page-section" id="plan-device"  style="display:block">
		<div class="col-xs-12 col-sm-6 col-lg-6  select-device  select-section" cid="deviceselection">
			<div class="select-content">
				<div class="content">
					<h3>DEVICES</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
				</div>
			</div>
		</div>
		<!-- <div class="col-xs-2 col-sm-2 col-md-2">
		</div> -->
		<div class="col-xs-12 col-sm-6 col-lg-6 select-plan  select-section" cid="planselection">
			<div class="select-content">
				<div class="content">
					<h3>PLANS</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
				</div>
			</div>
		</div>
	</div>

	<!-- Devices Information Section -->
	<div class="clearfix" />
	<div class="row page-section" id="deviceselection" style="display:none">
		<h3 class="col-lg-12 section-title" >Select a device for first adult</h3>
		<div class="col-xs-12 col-sm-6 col-lg-6  select-device  select-section" cid="device-container">
			<div class="select-content">
				<div class="content">
					<h3>SELECT A DEVICE</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6 col-lg-6 select-plan  select-section" cid="byosd-list">
			<div class="select-content">
				<div class="content">
					<h3>BRING YOUR OWN DEVICE</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
				</div>
			</div>
		</div>
	</div>

	<div class="clearfix" />
	<div class="row  page-section" id="device-container" style="display:none">
		<div class="loader"></div>
	</div>

	<div class="clearfix" />
	<div class="row  page-section" id="device-detail" style="display:none">
		<div class="loader"></div>
	</div>

	<!-- BYOSD information Section -->

	<div class="row  page-section" id="byosd-list" style="display:none">
		<div class="loader"></div>
	</div>

	<div class="row  page-section" id="byosd-checkmeid" style="display:none">
		<h3 class="section-title">BRING YOUR OWN DEVICE</h3>
		<h4 class="meid-res">Great! Your phone is compatible & eligible for Betterworld Wireless.</h4><br/>
		<div style="padding-left:0px;" class="col-xs-6 col-sm-6 col-lg-6 meid-res">
			<img class="pull-left" src="http://laravel.dev/images/sample_device.jpg">
			<div class="pull-left" style="width:80%;margin-top:2%">
				<div id="input-meid">
					Dial *#06# to display your 15-digit IMEI number. Enter it below.<br/><br/>
					<input type="hidden" id="checkmeid" name="checkmeid" value="{{ URL::route('checkMEID') }}">
					<input type="text" value="" style="width: 76%;" class="search pull-left" id="meid" placeholder="Enter a 15 digit IMEI number">
					<a href="#" class="orange-button pull-left" id="check-meid">CHECK</a>
					<div class="clearfix"></div>
					<div id="showloader"></div>
				</div>
			</div>
		</div>
	</div>	
	<div class="row  page-section" id="byosd-editmeid" style="display:none">
		<h3 class="section-title">BRING YOUR OWN DEVICE</h3>
		<h4 class="meid-res">Great! Your phone is compatible & eligible for Betterworld Wireless.</h4><br/>
		<div style="padding-left:0px;" class="col-xs-6 col-sm-6 col-lg-6 meid-res">
			<img class="pull-left" src="http://laravel.dev/images/sample_device.jpg">
			<div class="pull-left" style="width:80%;margin-top:2%">
						
				<div id="valid-meid">
  					<h4>Your IMEI number: <span id="validmeid"></span> <a class="orange-link" href="#" id="editBYOSD">Edit</a></h4><br/>
					<a style="width: 68%;" href="#" class="orange-button" id="selectplan">Next To Choose a Plan</a>
				</div>
			</div>
		</div>
		<div class="col-xs-6 col-sm-6 col-lg-6 "></div>
		<div class="clearfix"></div>
		<div class="device-list meid-res" id="compatible">
			<strong>FAQ</strong>
			<p>
				You need an unlocked GSM phone to use the BetterWorld Wireless Network.<br/>
				<a href="#">How can I tell if it's unlocked?</a><br/>
				<br/>
				<a href="#">What if I don't see a number or it's fewer than 15 digits?</a><br/>
				<a href="#">What is an IMEI number?</a>
			</p>
		</div>
		
	</div>
	<!-- Plan Information Section -->

	<div class="row  page-section plan-section" id="planselection"  style="display:none">
		<h3 class="section-title col-lg-12">SELECT A PLAN</h3>
		<div class="col-xs-12 col-sm-6 col-lg-6 select-device plan-section  select-section" cid="just-plan">
			<div class="select-content">
				<div class="content">
					<h3>JUST PLAN</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-3 col-lg-3 plan-package plan-section select-section" cid="plan-container" >
			<div class="select-content">
				<div class="content">
					<h3>PACKAGE</h3>
					<p>Consectetur adipiscing elit, eiusmod tempor incididunt.</p>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-3 col-lg-3 plan-package plan-section select-section" cid="plan-container">
			<div class="select-content">
				<div class="content">
					<h3>DATA ONLY</h3>
					<p>Consectetur adipiscing elit, eiusmod tempor incididunt.</p>
				</div>
			</div>
		</div>
		
	</div>
	<div class="clearfix" />
	<div class="row  page-section" id="just-plan" style="display:none">
		<div class="col-lg-12">
			<h3 class="section-title">JUST PLAN</h3>
			<p class="subheading">Just pay for what you use. That's it</p>
			<div style="text-align: center;">
				<img style="" src="<?php echo url();?>/images/justplan_picture.jpg" class="plan-types">
				<br>
				<a class="orange-button wide select-justplan" href="#" style="margin:20px auto">SELECT</a>
			</div>
			<div class="disclaimer">
				<h5>Internation Calling</h5>
				<p>
					<strong>Terms:</strong> No contract. Your credit card will be billed once a month and you can cancel anytime. <br/>
					<strong>Included:</strong> Voicemail; 3-way calling; caller ID; hotspot; global messaging and more. <br/>
					<strong>Surcharges:</strong> Monthly fee of $8 per device per month; One-time $6.25 per device activation fee; Bring Your Own Sprint Device (BYOSD) Activation $12.50. <br/>
					<strong>Additional charges and information:</strong> Shipping $15. Taxes and regulatory fees additional. Standard airtime and toll rates apply for: Call Forwarding; Operator Services; Directory Assistance; 911 and E911; and Customer Care. National and international roaming charges additional. International calling charges from U.S. vary by terminating country. <br/>
					<strong>Optional Tethering:</strong> $1.50/month (Please note: Your chosen data plan rates will apply.); Directory Assistance $1/min; Number Porting $5.50; Call Tracing $20. Please visit our FAQs for more information.<br/>
				</p>
			</div>
		</div>
	</div>
	<div class="row  page-section" id="plan-container" style="display:none">
		<div class="loader"></div>
	</div>
	<div class="row  page-section" id="causeselection" style="display:none">
		<div class="loader"></div>
	</div>
	<div class="row  page-section" id="cause-detail" style="display:none">
		<div class="loader"></div>
	</div>

	<div class="row  page-section" id="another-device" style="display:none">
		<div class="col-lg-12">
			<h3 class="section-title">ANOTHER DEVICE?</h3>
			<div class="add-device-action col-xs-1 col-sm-1 col-lg-1">
				<img src="<?php echo url();?>/images/add_device.png">
			</div>
			<div class="add-device-action col-xs-10 col-sm-10 col-lg-10">
				<p>You have added a plan to your device. </p>
				<p>	Do you want to add another device to your Family Plan?</p>
				<a id="addevice" class="orange-button" href="#">Yes add another device</a>
				<a id="gotoshoppingcart" class="blue-button" href="#">No, continue to checkout</a>
			</div>
		</div>
	</div>

	<div class="row  page-section" id="shopping-cart" style="display:none">
		<div class="loader"></div>
	</div>

	<div class="clearfix"></div>
	<div class="row  page-section" id="create-account" style="display:none">
		<!-- <div class="loader"></div> -->
		<div class="col-xs-12 col-sm-6 col-lg-6 caccount-border">
			<h3 class="section-title">CREATE AN ACCOUNT</h3>
			<p class="subheading">Fields marked with an <span class="orange-text">*</span> are required </p>
			<form role="form" class="create-account-form" id="create-account-form" action="{{ URL::route('createAccount') }}">
				<div class="form-group" id="email_addressBox">
				    <label for="email_address">Email address<span class="orange-text">*</span><span class="errormsg" id="email_addressError"></a></label>
				    <input type="email" class="form-control" id="email_address" name="email_address" placeholder="Enter email">
				</div>
				<div class="form-group" id="passwordBox">
				    <label for="password">Password<span class="orange-text">*</span><span class="errormsg" id="passwordError"></a></label>
				    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
				</div>
				<div class="form-group" id="password_confirmBox">
				    <label for="password_confirm">Re-enter Password<span class="orange-text">*</span><span class="errormsg" id="password_confirmError"></a></label>
				    <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Re-enter Password">
				</div>
				  <button type="button" class="btn orange-button proceedcheckout" style="width:100%" >CREATE AN ACCOUNT</button>
			</form>
		</div>
		<div class="col-xs-12 col-sm-6 col-lg-6">
			<h3 class="section-title">OR LOGIN USING...</h3>
			
			<a href="#" class="proceedcheckout login-facebook">
				<img src="<?php echo url();?>/images/facebook_login.png">
			</a>

			<h2 style="font-weight:200">Or</h2>
			
			<a href="#" class="proceedcheckout login-amazon">
				<img src="<?php echo url();?>/images/amazon_login.png">
			</a>
		</div>
	</div>
	
	<div class="clearfix"></div>
	<div class="row  page-section" id="checkout-container" style="display:none">
		<div class="loader"></div>
		
	</div>


<!-- <a href="#" id="LoginWithAmazon">
  <img border="0" alt="Login with Amazon"
    src="https://images-na.ssl-images-amazon.com/images/G/01/lwa/btnLWA_gold_156x32.png"
    width="156" height="32" />
</a> -->
<script type="text/javascript">

  document.getElementById('LoginWithAmazon').onclick = function() {
    options = { scope : 'profile' };
    amazon.Login.authorize(options, 'https://bww-laravel.gfdev.net/amazon');
    return false;
  };

</script>


@stop

