@extends('layouts.header')

@section('head')
    @parent
    <title>Shop Page</title>
@stop

@section('content')
	<div class="row page-section" id="plan-device"  style="display:block">
		<div class="col-xs-6 col-sm-6 col-lg-6  select-device  select-section" cid="deviceselection">
			<div class="select-content">
				<h3>DEVICES</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
			</div>
		</div>
		<!-- <div class="col-xs-2 col-sm-2 col-md-2">
		</div> -->
		<div class="col-xs-6 col-sm-6 col-lg-6 select-plan  select-section" cid="planselection">
			<div class="select-content">
				<h3>PLANS</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
			</div>
		</div>
	</div>

	<!-- Devices Information Section -->
	
	<div class="row  page-section" id="deviceselection" style="display:none">
		<h3 class="option-text" >Select a device for first adult</h3><br/><br/>
		<div class="col-xs-6 col-sm-6 col-lg-6  select-device  select-section" cid="device-container">
			<div class="select-content">
				<h3>SELECT A DEVICE</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
			</div>
		</div>
		<div class="col-xs-6 col-sm-6 col-lg-6 select-plan  select-section" cid="byosd-list">
			<div class="select-content">
				<h3>BRING YOUR OWN DEVICE</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
			</div>
		</div>
	</div>
	<div class="row  page-section" id="device-container" style="display:none">
		<div class="loader"></div>
	</div>
	<div class="row  page-section" id="byosd-list" style="display:none">
		<div class="loader"></div>
	</div>

	<!-- Plan Information Section -->

	<div class="row  page-section plan-section" id="planselection"  style="display:none">
		<h3 class="option-text">Select a plan</h3><br/>
		<div class="col-xs-6 col-sm-6 col-lg-6  select-device plan-section  select-section" cid="just-plan">
			<div class="select-content" >
				<h3>JUST PLAN</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
			</div>
		</div>
		<div class="col-xs-3 col-sm-3 col-lg-3 plan-package plan-section select-section" cid="plan-container" >
			<div class="select-content">
				<h3>PACKAGE</h3>
				<p>Consectetur adipiscing elit, eiusmod tempor incididunt.</p>
			</div>
		</div>
		<div class="col-xs-3 col-sm-3 col-lg-3 plan-package plan-section select-section" cid="plan-container">
			<div class="select-content">
				<h3>DATA ONLY</h3>
				<p>Consectetur adipiscing elit, eiusmod tempor incididunt.</p>
			</div>
		</div>
		
	</div>
	<div class="row  page-section" id="just-plan" style="display:none">
		<h2>JUST PLAN</h2>
		<p>Just pay for what you use. That's it</p>
		<div style="text-align: center;">
			<img style="" src="<?php echo url();?>/images/justplan_picture.jpg">
			<br>
			<a class="orange-button select-package" href="#" style="width: 17%;margin:20px 40%">SELECT</a>
		</div>
		<br/><br/>
		<div>
			<h5><u>Internation Calling</u></h5>
			<p>
				<strong>Terms:</strong> No contract. Your credit card will be billed once a month and you can cancel anytime. <br/>
				<strong>Included:</strong> Voicemail; 3-way calling; caller ID; hotspot; global messaging and more. <br/>
				<strong>Surcharges:</strong> Monthly fee of $8 per device per month; One-time $6.25 per device activation fee; Bring Your Own Sprint Device (BYOSD) Activation $12.50. <br/>
				<strong>Additional charges and information:</strong> Shipping $15. Taxes and regulatory fees additional. Standard airtime and toll rates apply for: Call Forwarding; Operator Services; Directory Assistance; 911 and E911; and Customer Care. National and international roaming charges additional. International calling charges from U.S. vary by terminating country. <br/>
				<strong>Optional Tethering:</strong> $1.50/month (Please note: Your chosen data plan rates will apply.); Directory Assistance $1/min; Number Porting $5.50; Call Tracing $20. Please visit our FAQs for more information.<br/>

			</p>
		</div>

	</div>
	<div class="row  page-section" id="plan-container" style="display:none">
		<div class="loader"></div>
	</div>
	<div class="row  page-section plan-section" id="causeselection" style="display:none">
		<div class="cause-msg">
			<div class="content-msg">
				<span class="msg-header">What if you could help someone who sleeps on the streets find a home?</span>
				<div class="mobile-all">
					<h2 style="text-decoration:underline">MOBILE<span style="color:#fe8700">4</span>ALL</h2>
					<p>
						Mission: End homelessness<br/>
						Where: U.S. <br/>
						What: Smartphones<br/> 
						Goal: 250 Sponsors: ###
					</p>
				</div>
			</div>
		</div>
		<div class="cause-description">
			<p>	
				<strong>Excepteur sint occaecat cupidatat non proident</strong><br/>
			 	Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			 </p>
		</div>
		<div class="cause1 cause-item">
			<h2 class="cause-name" sku="">E-reader Classroom Kit</h2>
			<p>
				MISSION: Eradicate Illiteracy<br/>
				WHERE: Oltikampu School - Kilgoris, Kenya<br/>
				HOW: Classroom kits of e-readers loaded with entire libraries of books in local languages<br/>
				DEVICE TYPE: Kindle e-readers DEVICE #: 50<br/>
				METRICS: Literacy rates<br/>
			</p>
		</div>
		<div class="cause2 cause-item">
			<h2 class="cause-name" sku="">PROGRAM NAME</h2>
			<p>
				MISSION: [brief mission statement] <br/>
				WHERE: [program location]<br/>
				HOW: [130 characters or less] <br/>
				DEVICE TYPE: [Device type] DEVICE #: [Number]<br/>
				METRICS: [text - i.e. self sufficiency matrix]<br/>
			</p>
		</div>
		
		<div class="cause3 cause-item">
			<h2 class="cause-name" sku="">PROGRAM NAME</h2>
			<p>
				MISSION: [brief mission statement] <br/>
				WHERE: [program location]<br/>
				HOW: [130 characters or less] <br/>
				DEVICE TYPE: [Device type] DEVICE #: [Number]<br/>
				METRICS: [text - i.e. self sufficiency matrix]<br/>
			</p>
		</div>
		
		<br/><br/><br/>
	</div>
	<div class="row  page-section" id="cause-detail" style="display:none">
		<div class="loader"></div>
	</div>

	<div class="row  page-section" id="another-device" style="display:none">
		<h2>ANOTHER DEVICE?</h2>
		<div class="add-device-action col-xs-1 col-sm-1 col-lg-1">
			<img src="http://laravel.dev/images/add_device.png">
		</div>
		<div class="add-device-action col-xs-10 col-sm-10 col-lg-10">
			<p>You have added a plan to your device. </p>
			<p>	Do you want to add another device to your Family Plan?</p>
			<a id="addevice" class="orange-button" href="#" style="width: 35%;">Yes add another device</a>
			<a id="gotoshoppingcart" class="blue-button" href="#" style="width: 35%;">No, continue to checkout</a>
		</div>
	</div>

	<div class="row  page-section" id="shopping-cart" style="display:none">
		<div class="loader"></div>
	</div>

	<div class="row  page-section" id="create-account" style="display:none;margin-top:-40px">
		<!-- <div class="loader"></div> -->
		<div class="col-xs-6 col-sm-6 col-lg-6 caccount-border">
			<h2>CREATE AN ACCOUNT</h2>
			<h3>Fields marked with an <span class="orange-text">*</span> are required </h3>
			<form role="form" class="create-account-form">
				<div class="form-group">
				    <label for="exampleInputEmail1">Email address<span class="orange-text">*</span></label>
				    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
				</div>
				<div class="form-group">
				    <label for="exampleInputPassword1">Password<span class="orange-text">*</span></label>
				    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
				</div>
				<div class="form-group">
				    <label for="exampleInputPassword1">Re-enter Password<span class="orange-text">*</span></label>
				    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
				</div>
				  <button type="button" class="btn orange-button proceedcheckout" style="width:100%" >Submit</button>
			</form>
		</div>
		<div class="col-xs-6 col-sm-6 col-lg-6">
			<h2>OR LOGIN USING....</h2>
			<br/><br/><br/>
			<a href="#" class="proceedcheckout">
				<img src="<?php echo url();?>/images/facebook_login.png">
			</a>
			<h2>Or</h2>
			<br/><br/>
			<a href="#" class="proceedcheckout">
				<img src="<?php echo url();?>/images/amazon_login.png">
			</a>
		</div>
	</div>

	<div class="row  page-section" id="checkout-container" style="display:none;margin-top:-40px">
		<div class="loader"></div>
		
	</div>
@stop