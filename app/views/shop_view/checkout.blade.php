<div class="col-xs-12 col-sm-6 col-lg-6 caccount-border" style="display:block" id="acct-info">
			<h3 class="section-title">ACCOUNT INFORMATION</h3>
			<p class="subheading">Fields marked with an <span class="orange-text">*</span> are required </p>
			<form role="form" class="create-account-form">
				<div class="form-group">
				    <label for="exampleInputEmail1">First Name<span class="orange-text">*</span></label>
				    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
				</div>
				<div class="form-group">
				    <label for="exampleInputEmail1">Middle Initial<span class="orange-text">*</span></label>
				    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
				</div>
				<div class="form-group">
				    <label for="exampleInputEmail1">Billing Address<span class="orange-text">*</span></label>
				    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
				</div>
				<div class="form-group">
				    <label for="exampleInputEmail1">Billing Address 2</label>
				    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
				</div>
				<div class="form-group">
				    <label for="exampleInputEmail1">City<span class="orange-text">*</span></label>
				    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">
						State<span style="margin-right: 65%;" class="orange-text">*</span>Zipcode
					</label>
					<br>
					<select style="width:20%" class="pull-left form-control">
						<option></option>
					</select>
					<input type="email" style="width: 75%;" placeholder="Enter email" class="form-control pull-right" id="exampleInputEmail1">
					<div class="clearfix"></div>
				</div>
				<div class="form-group">
				    <label for="exampleInputEmail1">Primary Phone Number<span class="orange-text">*</span></label>
				    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
				</div>
				<div class="form-group">
				    <label for="exampleInputEmail1">Email Address<span class="orange-text">*</span></label>
				    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
				</div>
				<div class="form-group">
				    <label for="exampleInputEmail1">Verify Email Address<span class="orange-text">*</span></label>
				    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
				</div>
				<div class="shipping-address ">
					<div class="form-group">
						<h4>Shipping address</h4>
					    <input type="checkbox" id="shipping-address" class="css-checkbox" checked="checked">
					    <label for="shipping-address" class="css-label">Same as billing address<span class="orange-text">*</span></label>
					</div>
				</div>				
				<div class="form-group">
				    <h4>Promotion Code</h4>
				    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
				</div>
				<div class="form-group">
					<h4>Newsletter</h4>
				    <input type="checkbox" id="subscribe-newsletter" class="css-checkbox">
				    <label for="subscribe-newsletter" class="css-label">Sign me up for Betterworld Wireless Newsletter</label>
				</div><br/>
				<div class="form-group">
					<h4>TERMS & CONDITIONS</h4>
				    <input type="checkbox" id="terms-conditions" class="css-checkbox">
				    <label for="terms-conditions" class="css-label orange-text">I agree to Betterworld Wireless Terms & Conditions</label>
				</div>
				<br/><br/>
				<button id="submitAcctInfo" class="btn orange-button" style="width:100%">PROCEED TO VALIDATE CREDIT CARD</button>
			</form>
		</div>
		<div class="col-xs-12 col-sm-6 col-lg-6 caccount-border" id="ccvalidation" style="display:none">
			<h3 class="section-title">CREDIT CARD VALIDATION</h3>
			<p class="subheading">Fields marked with an <span class="orange-text">*</span> are required </p>
			<form role="form" class="create-account-form">
				<div class="form-group">
				    <label for="exampleInputEmail1">Credit Card Number<span class="orange-text">*</span></label>
				    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
				    <img class="pull-left" src="<?php echo url();?>/images/cc_cards.jpg"><br/>
				</div>
				<div class="form-group">
				    <label for="exampleInputEmail1">Cardholder's Name<span class="orange-text">*</span></label>
				    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">Expiration Date</label>
					<br>
					<select style="width:70%" class="pull-left form-control">
						<option>Month</option>
					</select>
					<select style="width:25%" class="pull-right form-control">
						<option>Year</option>
					</select>
					<div class="clearfix"></div>
				</div>
				<div class="form-group">
				    <label for="exampleInputEmail1">CVV Number<span class="orange-text">*</span></label>
				    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
				</div>
				<button  class="btn orange-button" style="width:100%">PROCEED TO VALIDATE CREDIT CARD</button>
			</form>
		</div>
		<div class="col-xs-12 col-sm-6 col-lg-6">
			<h3 class="section-title">ORDER DETAILS</h3>
			<table class="order-details table">
				<tbody>
					<tr>
						<th class="o-device">New Line 1</th>
						<th>Monthly</th>
						<th>Due Today</th>
					</tr>
					<tr>
						<td class="product-name">Device: Sony Xperia Z3</td>
						<td>&nbsp;</td>
						<td>$340.00</td>
					</tr>
					<tr>
						<td class="product-name">Plan: Just Plan Medium Family</td>
						<td>$75.00</td>
						<td>&nbsp;</td>
					</tr>
				</tbody>
				<tbody>
					<tr>
						<th class="o-device">New Line 1</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
					</tr>
					<tr>
						<td class="product-name">Device: Sony Xperia Z3</td>
						<td>&nbsp;</td>
						<td>$340.00</td>
					</tr>
					<tr>
						<td class="product-name">Plan: Just Plan Medium Family</td>
						<td>$75.00</td>
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
						<td colspan="2"><span style="font-size:16px">$340.00</span></td>
					</tr>
					<tr>
						<td class="product-name">Due Monthly</td>
						<td colspan="2">$75.00</td>
					</tr>
				</tbody>
			</table>
		</div>