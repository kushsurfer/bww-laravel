<?php
	$option = '';
	if(count($regionList)> 0){
		foreach($regionList as $region){
			$option .='<option value="'.$region->code.'">'.$region->code.'</option>'; 
		}
	}

	$currentYear = date('Y');
	$cardYear = $currentYear - 25;
	

?>

<div class="col-xs-6 col-sm-6 col-lg-6 caccount-border" style="display:block" id="acct-info">
	<h3 class="section-title">ACCOUNT INFORMATION</h3>
	<h4>Fields marked with an <span class="orange-text">*</span> are required </h4>
	<form role="form" class="account-information-form" id="account-information-form" action="{{ URL::route('updateAccountInformation') }}" method="POST">
		<div class="form-group">
		    <label for="fname">First Name<span class="orange-text">*</span><span class="errormsg" id="fnameError"></span></label>
		    <input type="text" class="form-control billing-element" id="fname" name="fname" >
		</div>
		<div class="form-group">
		    <label for="minitial">Middle Initial<span class="orange-text"></span></label>
		    <input type="text" class="form-control" id="minitial" name="minitial">
		</div>
		<div class="form-group">
		    <label for="lname">Last Name<span class="orange-text">*</span><span class="errormsg" id="lnameError"></span></label>
		    <input type="text" class="form-control billing-element" id="lname" name="lname">
		</div>
		<div class="form-group">
		    <label for="billingAddress">Billing Address<span class="orange-text">*</span><span class="errormsg" id="billingAddressError"></span></label>
		    <input type="text" class="form-control billing-element" id="billingAddress" name="billingAddress">
		</div>
		<div class="form-group">
		    <label for="billingAddress2">Billing Address 2</label>
		    <input type="text" class="form-control" id="billingAddress2" name="billingAddress2">
		</div>
		<div class="form-group">
		    <label for="city">City<span class="orange-text">*</span><span class="errormsg" id="cityError"></span></label>
		    <input type="text" class="form-control billing-element" id="city" name="city">
		</div>
		<div class="form-group">
			<label for="state">
				State<span style="margin-right: 90%;" class="orange-text">*</span>Zipcode<span class="orange-text">*</span><span class="errormsg" id="stateError"></span><span class="errormsg" id="zipcodeError"></span>
			</label>
			<br>
			<select style="width:20%" class="pull-left form-control billing-element" name="state" id="state"  name="state">
				<option></option>
				{{ $option }}
			</select>
			<input type="text" style="width: 75%;" placeholder="Enter zipcode" class="form-control pull-right billing-element" id="zipcode" name="zipcode">
			<div class="clearfix"></div>
		</div>
		<div class="form-group">
		    <label for="phone">Primary Phone Number<span class="orange-text">*</span><span class="errormsg" id="phoneError"></span></label>
		    <input type="phone" class="form-control billing-element" id="phone" name="phone">
		</div>
		<div class="form-group">
		    <label for="emailAddress">Email Address<span class="orange-text">*</span><span class="errormsg" id="emailAddressError"></span></label>
		    <input type="email" class="form-control" id="emailAddress" name="emailAddress" value="{{ $customer->email_address }}">
		</div>
		<div class="form-group">
		    <label for="verifyEmail">Verify Email Address<span class="orange-text">*</span><span class="errormsg" id="verifyEmailError"></span></label>
		    <input type="email" class="form-control" id="verifyEmail" name="verifyEmail">
		</div>
		<div class="shipping-address ">

			<h4>Shipping address</h4>
			<div class="form-group">
			    <input type="checkbox" value="0" class="hide" name="sameShip" id="sameShip">
			    <span class="custom-checkbox" id="sameShipping" inputid = "sameShip"></span>
			    <label for="exampleInputEmail1">Same as billing address<span class="orange-text">*</span><span class="errormsg" id="shippingAddError"></span></label>
			</div>
			<br/>
			<div class="form-group">
			    <label for="shipfname">First Name<span class="orange-text">*</span><span class="errormsg" id="shipfnameError"></span></label>
			    <input type="text" class="form-control" id="shipfname" name="shipfname" >
			</div>
			<div class="form-group">
			    <label for="shiplname">Last Name<span class="orange-text">*</span><span class="errormsg" id="shiplnameError"></span></label>
			    <input type="text" class="form-control" id="shiplname" name="shiplname">
			</div>
			<div class="form-group">
			    <label for="shipbillingAddress">Billing Address<span class="orange-text">*</span><span class="errormsg" id="shipbillingAddressError"></span></label>
			    <input type="text" class="form-control" id="shipbillingAddress" name="shipbillingAddress">
			</div>
			<div class="form-group">
			    <label for="shipcity">City<span class="orange-text">*</span><span class="errormsg" id="shipcityError"></span></label>
			    <input type="text" class="form-control" id="shipcity" name="shipcity">
			</div>
			<div class="form-group">
				<label for="shipstate">
					State<span style="margin-right: 90%;" class="orange-text">*</span>Zipcode<span class="orange-text">*</span><span class="errormsg" id="shipstateError"></span><span class="errormsg" id="shipzipcodeError"></span>
				</label>
				<br>
				<select style="width:20%" class="pull-left form-control" id="shipstate" name="shipstate">
					<option></option>
					{{ $option }}
				</select>
				<input type="text" style="width: 75%;" placeholder="Enter zipcode" class="form-control pull-right" id="shipzipcode" name="shipzipcode">
				<div class="clearfix"></div>
			</div>
			<div class="form-group">
			    <label for="shipphone">Primary Phone Number<span class="orange-text">*</span><span class="errormsg" id="shipphoneError"></span></label>
			    <input type="shipphone" class="form-control" id="shipphone" name="shipphone">
			</div>		
		</div>				
		<div class="form-group">
		    <h4>Promotion Code</h4>
		    <input type="email" class="form-control" id="promotionCode" name="promotionCode">
		</div>
		<div class="form-group">
			<h4>Newsletter</h4>
		    <input type="text" value="0" class="hide" name="newsletter" id="newsletter">
		    <span class="custom-checkbox" inputid = "newsletter"></span>
		    <label for="exampleInputEmail1">Sign me up for Betterworld Wireless Newsletter</label>
		</div><br/>
		<div class="form-group">
			<h4>TERMS & CONDITIONS<span class="errormsg" id="termsError"></span></h4>
		    <input type="text" value="0" class="hide" name="terms" id = "terms">
		    <span class="custom-checkbox" inputid="terms"></span>
		    <label for="exampleInputEmail1" class="orange-text">I agree to Betterworld Wireless Terms & Conditions</label>
		</div>
		<br/><br/>
		<button id="submitAcctInfo" class="btn orange-button" style="width:100%">PROCEED TO VALIDATE CREDIT CARD</button>
	</form>
</div>
<div class="col-xs-6 col-sm-6 col-lg-6 caccount-border" id="ccvalidation" style="display:block">
	<h3 class="section-title">CREDIT CARD VALIDATION</h3>
	<h4>Fields marked with an <span class="orange-text">*</span> are required </h4>
	<form role="form" class="credit-card-form" id="credit-card-form" action="{{ URL::route('validateCCardInfo') }}" method="POST">
		<div class="form-group">
		    <label for="ccard">Credit Card Number<span class="orange-text">*</span><span class="errormsg" id="fnameError"></span></label>
		    <input type="text" class="form-control" id="ccard" name="ccard" >
		    <img class="pull-left" src="<?php echo url();?>/images/cc_cards.jpg"><br/>
		</div>
		<div class="form-group">
		    <label for="ccname">Cardholder's Name<span class="orange-text">*</span><span class="errormsg" id="ccnameError"></span></label>
		    <input type="text" class="form-control" id="ccname" name="ccname">
		</div>
		<div class="form-group">
			<label for="mon">Expiration Date<span class="errormsg" id="monError"></span><span class="errormsg" id="yrError"></span></label>
			<br>
			<select style="width:70%" class="pull-left form-control" name="mon" id="mon">
				<option>Month</option>
				@foreach($months as $key => $mon)
					<option value="{{ $key }}">{{ $mon }}</option>
				@endforeach

			</select>
			<select style="width:25%" class="pull-right form-control" name="yr" id="yr">
				<option>Year</option>
				<?php for($i = $currentYear; $i > $cardYear; $i--): ?>			
					<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endfor;?>

			</select>
			<div class="clearfix"></div>
		</div>
		<div class="form-group">
		    <label for="cvv">CVV Number<span class="orange-text">*</span><span class="errormsg" id="cvvError"></span></label>
		    <input type="text" class="form-control" id="cvv" name="cvv" >
		</div>
		<button  class="btn orange-button" style="width:100%" id="validateCCard">PROCEED TO VALIDATE CREDIT CARD</button>
	</form>
</div>
<div class="col-xs-6 col-sm-6 col-lg-6" id="checkoutloader" style="display:none">
	<div class="loader"></div>
</div>
<div class="col-xs-6 col-sm-6 col-lg-6">
	<h3 class="section-title">ORDER DETAILS</h3>
	<table class="order-details table">
		<tbody>
			<tr>
				<th class="o-device">Order Sets</th>
				<th>Monthly</th>
				<th>Due Today</th>
			</tr>
		</tbody>
		<?php 
			$dueAmount = 0;
			$monthlydue = 0;
			$cnt = 0;
		?>
		@foreach($cartdetails as $key => $cartItem)

		<?php 
			$dueAmount += $cartItem['deviceDetails']['price'];
			$monthlydue += $cartItem['planDetails']['price'];
			$cnt++;
		?>

		<tbody>
			<tr>
				<th class="o-device">Set {{ $cnt; }}</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
			</tr>
			<tr>
				<td class="product-name">Device: {{ $cartItem['deviceDetails']['name'] }}</td>
				<td>&nbsp;</td>
				<td>{{ '$' . number_format($cartItem['deviceDetails']['price'] , 2, '.', '') }}</td>
			</tr>
			<tr>
				<td class="product-name">Plan: {{ $cartItem['planDetails']['name'] }}</td>
				<td>{{ '$' . number_format($cartItem['planDetails']['price'] , 2, '.', '') }}</td>
				<td>&nbsp;</td>
			</tr>
		</tbody>
		<tbody class="oder-total">
			<tr>
				<th><strong>Estimated Tax</strong></th>
				<th colspan="2" style="text-align:right;font-weight:normal">$0.00</th>
			</tr>
			<tr>
				<td class="product-name">Due Toady</td>
				<td colspan="2"><span style="font-size:16px">{{ '$' . number_format($dueAmount , 2, '.', '') }}</span></td>
			</tr>
			<tr>
				<td class="product-name">Due Monthly</td>
				<td colspan="2">{{ '$' . number_format($monthlydue , 2, '.', '') }}</td>
			</tr>
		</tbody>
		@endforeach
	</table>
</div>