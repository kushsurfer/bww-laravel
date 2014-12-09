<div class="col-lg-12">
<h3 class="section-title">ORDER SUMMARY</h3>
<p class="subheading">Your items</p>
<?php 
	$dueAmount = 0;
	$monthlydue = 0;
?>
@foreach($cartdetails as $key => $cartItem)

<?php 
	$dueAmount += $cartItem['deviceDetails']['price'];
	$monthlydue += $cartItem['planDetails']['price'];
?>

<div class="cart-item row">
	<div class="col-xs-2 col-sm-2 col-lg-2">
		<img src="{{ $cartItem['deviceImage'] }}" >
	</div>
	<div class="col-xs-10 col-sm-10 col-lg-10">
		<table class="table table-productinfo">
			<thead>
				<tr>
					<th colspan="3"><strong class="item-name">Item <?php echo $key + 1; ?></strong></th>
					<th><strong>Monthy</strong></th>
					<th><strong>Due Today</strong></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><strong>Device:</strong></td>
					<td>
						{{ $cartItem['deviceDetails']['name'] }}<br/>
						<span class="small">New from BetterWorld Wireless</span>
					</td>
					<td>
						<a href="#" class="cart-button" cid="{{ $key }}">Edit</a>
						<div class="clearfix"></div>
					</td>
					<td>
						&nbsp;
					</td>
					<td class="cart-price">
						{{ '$' . number_format($cartItem['deviceDetails']['price'] , 2, '.', '') }}
					</td>
				</tr>
				<tr>
					<td><strong>Plan:</strong></td>
					<td>
						{{ $cartItem['planDetails']['name'] }}<br/>
						<!-- 1200 minutes, unlimited messages, 750 MB data -->
					</td>
					<td>
						<a href="#" class="cart-button">Edit</a>
						<div class="clearfix"></div>
					</td>
					<td class="cart-price">
						{{ '$' . number_format($cartItem['planDetails']['price'] , 2, '.', '') }}
					</td>
					<td>
						&nbsp;
					</td>
				</tr>
				<tr>
					<td colspan="4">One-Time Activation Fee</td>
					<td class="cart-price">
						{{ '$' . number_format($cartItem['activationFee'] , 2, '.', '') }}
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="clearfix"></div>
</div>
@endforeach


<div class="cart-item row"></div>

<div class="cart-summary row">
	<div class="col-xs-12 col-sm-12 col-lg-12">
		<h3 style="font-weight: 500;">Summary</h3>
	</div>
</div>
<div class="cart-summary row">
	
	<div class="col-xs-10 col-sm-10 col-lg-10">
		<h4>Shipping</h4>
	</div>
	<div class="col-xs-2 col-sm-2 col-lg-2">
		<h4 class="orange-text" style="font-weight:300">FREE</h4>
	</div>
</div>
<div class="cart-summary row">
	<div class="col-xs-10 col-sm-10 col-lg-10">
		<h4>Estimated tax</h4>
	</div>
	<div class="col-xs-2 col-sm-2 col-lg-2">
		<h4 style="font-weight:300">$0.00</h4>
	</div>
</div>
<div class="row">
	<div class="col-xs-7 col-sm-7 col-lg-8"></div>
	<div class="cart-summary col-xs-3 col-sm-3 col-lg-2"><h4>Due Today*</h4></div>
	<div class="cart-summary col-xs-2 col-sm-2 col-lg-2">
		<h4>{{ '$' . number_format($dueAmount , 2, '.', '') }}</h4>
	</div>
</div>
<div class="row">
	<div class="col-xs-7 col-sm-7 col-lg-8"></div>
	<div class="cart-summary col-xs-3 col-sm-3 col-lg-2"><h5>Due Monthly*</h5></div>
	<div class="cart-summary col-xs-2 col-sm-2 col-lg-2">
		<h5>{{ '$' . number_format($monthlydue , 2, '.', '') }}</h5>
	</div>
</div>

<div class="clearfix"></div>
<a id="checkout" href="#" class="orange-button wide pull-right" style="margin-top: 1.4em;">CHECK OUT</a>
</div>