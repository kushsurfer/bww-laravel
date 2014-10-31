@extends('layouts.main')

@section('head')
    @parent
    <title>Shop Page</title>
@stop
<script type="text/javascript">
	var devices = {};
 	var plans = {};
 	var causes = {};

</script>
@section('content')
	
	<form action="{{ URL::route('setOrderSet') }}" id="orderform" class="hide" method="post">
		<input type="hidden" id="device" name="device" value="" >
		<input type="hidden" id="plan" name="plan" value="">
		<input type="hidden" id="cause" name="cause" value="">
		<input type="hidden" id="orderset" name="orderset" value="0">
		{{ Form::token() }}
	</form>

	<div class="panel panel-primary shoppanels">
  <!-- Default panel contents -->
		<div class="panel-heading" id="devicespanel"><span class="arrows">&#9660</span>Select Device</div>
		<div class="panel-body">
			<?php $cnt = 1 ?>
			@foreach ($products as $prod)
		   		<div class="col-xs-3 col-sm-3 col-md-3">
		   			<a href="{{ URL::route('deviceDetail', $prod['product_id']) }}" class="selectshop">
		   				<span class="name">{{ $prod['name'] }}</span><br/><br/>
		   				<img src="{{ $prod['images'][0] }}" width="65%"/>
		   			</a><br/>
		   			<p class="pricedetails">
		   				<span class="decription"> {{ $prod['short_description'] }}</span>
		   				<br/><span class="price"> {{ '$' . number_format($prod['price'] , 2, '.', '') }}</span>
		   				<br/>
		   				<button type="button" class="btn btn-primary btn-sm devicebutton" did="{{ $prod['product_id'] }}">Select</button>
		   			</p>
		   			
		   		</div>
		   		@if($cnt == 4)
		   			<div class="clearfix"></div><br/><br/>
		   			<?php $cnt = 0 ?>
		   		@endif

		   		<?php $cnt++; ?>
		   		<script type="text/javascript">
		   			devices[{{$prod['product_id']}}] = {};
		   			devices[{{$prod['product_id']}}]['desc'] = '{{ $prod['name'] }}';
		   			devices[{{$prod['product_id']}}]['price'] = '{{$prod['price'] }}' ;
		   		</script>
	   		@endforeach
  		</div>

	</div>
	<div class="panel panel-primary shoppanels" >
  <!-- Default panel contents -->
		<div class="panel-heading" id="planpanel"><span class="arrows">&#9658</span>Select Plan</div>
		<div class="panel-body hide">
			<div class="loader"></div>
	   	</div>

	</div>
	<div class="panel panel-primary shoppanels" >
  <!-- Default panel contents -->
		<div class="panel-heading" id="causepanel"><span class="arrows">&#9658</span>Sponsor a Cause</div>
		<div class="panel-body hide">
	   		<div class="loader"></div>
  		</div>

	</div>
	<div class="panel panel-primary shoppanels" >
  <!-- Default panel contents -->
		<div class="panel-heading" id="createAccount"><span class="arrows">&#9658</span>Create My Account</div>
		<div class="panel-body hide">
	   		<div class="row">
				<div class="span12">
					<form class="well form-horizontal" id="addressForm" method="post" action="{{ URL::route('setAddress') }}">
						<input type="hidden" name="handsetID" id="handsetID" value="SAM-SPHM580"/>
						<input type="hidden" name="plandCode" id="plandCode" value=""/>
						<input type="hidden" name="causeID" id="causeID" value=""/>
						<legend>Address Information</legend>
						<div class="control-group ">
							<label class="control-label required" for="signup_Company">Company name</label>
							<div class="controls">
								<input id="signup_Company" type="text" required="required" name="signup[Company]">
							</div>
						</div>
						<div class="control-group ">
							<label class="control-label required" for="signup_FirstName">First Name*</label>
							<div class="controls">
								<input id="signup_FirstName" type="text" required="required" name="signup[FirstName]">
							</div>
						</div>
						<div class="control-group ">
							<label class="control-label required" for="signup_LastName">Last Name*</label>
							<div class="controls">
								<input id="signup_LastName" type="text" required="required" name="signup[LastName]">
							</div>
						</div>
						<div class="control-group ">
							<label class="control-label required" for="signup_StreetNumber">House Number*</label>
							<div class="controls">
								<input id="signup_StreetNumber" type="text" required="required" name="signup[StreetNumber]">
							</div>
						</div>
						<div class="control-group ">
							<label class="control-label required" for="signup_Street">Street*</label>
							<div class="controls">
								<input id="signup_Street" type="text" required="required" name="signup[Street]">
							</div>
						</div>
						<div class="control-group ">
							<label class="control-label required" for="signup_Floor">Floor</label>
							<div class="controls">
								<input id="signup_Floor" type="text" required="required" name="signup[Floor]">
							</div>
						</div>
						<div class="control-group ">
							<label class="control-label required" for="signup_FloorUnit">Floor Unit</label>
							<div class="controls">
								<input id="signup_FloorUnit" type="text" required="required" name="signup[FloorUnit]">
							</div>
						</div>
						<div class="control-group ">
							<label class="control-label required" for="signup_Zip">Zip*</label>
							<div class="controls">
								<input id="signup_Zip" type="text" required="required" name="signup[Zip]">
							</div>
						</div>
						<div class="control-group ">
							<label class="control-label required" for="signup_City">City*</label>
							<div class="controls">
								<input id="signup_City" type="text" required="required" name="signup[City]">
							</div>
						</div>
						<div class="control-group ">
							<label class="control-label required" for="signup_State">State*</label>
							<div class="controls">
								<select id="signup_State" required="required" name="signup[State]">
									<option selected="selected" value="">Select state</option>
									<option value="AL">Alabama</option>
									<option value="AK">Alaska</option>
									<option value="AZ">Arizona</option>
									<option value="AR">Arkansas</option>
									<option value="CA">California</option>
									<option value="CO">Colorado</option>
									<option value="CT">Connecticut</option>
									<option value="DE">Delaware</option>
									<option value="DC">District Of Columbia</option>
									<option value="FL">Florida</option>
									<option value="GA">Georgia</option>
									<option value="HI">Hawaii</option>
									<option value="ID">Idaho</option>
									<option value="IL">Illinois</option>
									<option value="IN">Indiana</option>
									<option value="IA">Iowa</option>
									<option value="KS">Kansas</option>
									<option value="KY">Kentucky</option>
									<option value="LA">Louisiana</option>
									<option value="ME">Maine</option>
									<option value="MD">Maryland</option>
									<option value="MA">Massachusetts</option>
									<option value="MI">Michigan</option>
									<option value="MN">Minnesota</option>
									<option value="MS">Mississippi</option>
									<option value="MO">Missouri</option>
									<option value="MT">Montana</option>
									<option value="NE">Nebraska</option>
									<option value="NV">Nevada </option>
									<option value="NH">New Hampshire</option>
									<option value="NJ">New Jersey</option>
									<option value="NM">New Mexico</option>
									<option value="NY">New York</option>
									<option value="NC">North Carolina</option>
									<option value="ND">North Dakota</option>
									<option value="OH">Ohio</option>
									<option value="OK">Oklahoma</option>
									<option value="OR">Oregon</option>
									<option value="PA">Pennsylvania</option>
									<option value="RI">Rhode Island</option>
									<option value="SC">South Carolina</option>
									<option value="SD">South Dakota</option>
									<option value="TN">Tennessee</option>
									<option value="TX">Texas</option>
									<option value="UT">Utah</option>
									<option value="VT">Vermont</option>
									<option value="VA">Virginia</option>
									<option value="WA">Washington</option>
									<option value="WV">West Virginia</option>
									<option value="WI">Wisconsin</option>
									<option value="WY">Wyoming</option>
								</select>
							</div>
						</div>
						<div class="control-group ">
							<label class="control-label required" for="signup_Country">Country</label>
							<div class="controls">
								<input id="signup_Country" type="text" value="US" style="background-color: #EEEEEE" required="required" readonly="readonly" name="signup[Country]">
							</div>
						</div>
						<div class="control-group ">
							<label class="control-label required" for="signup_Email">Email*</label>
							<div class="controls">
								<input id="signup_Email" type="text" required="required" name="signup[Email]">
							</div>
						</div>
						<div class="control-group ">
							<label class="control-label required" for="signup_Username">Username*</label>
							<div class="controls">
								<input id="signup_Username" type="text" required="required" name="signup[Username]">
							</div>
						</div>
						<input id="signup__token" type="hidden" value="eb54565a4aedc629696d19c7076f6e814eff491d" name="signup[_token]">
						<!-- <legend>Promotion Code</legend> -->
						<div class="control-group ">
							<!-- <label class="control-label required" for="signup_PromotionCode">Promotion code</label> -->
							<div class="controls">
								<!-- <input id="signup_PromotionCode" type="text" required="required" name="signup[PromotionCode]"> -->
								<input type="button" id="submitAddress" value="Submit">
							</div>
						</div>
						
					</form>
				</div>
			</div>
  		</div>

	</div>
	<div class="panel panel-primary shoppanels" >
 
 		<input type="hidden" id="addToCartUrl" value="{{ URL::route('addToCart') }}"/>
		<div class="panel-heading" id="checkout"><span class="arrows">&#9658</span>Checkout</div>
		<div class="panel-body hide">
	   		<div class="loader"></div>
  		</div>

	</div>
@stop