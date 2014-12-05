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
		<table class="table">
			<tr>
				<td colspan="3"><strong>Item 1</strong></td>
				<td><strong>Monthy</strong></td>
				<td><strong>Due Today</strong></td>
			</tr>
			<tr>
				<td>Device:	</td>
				<td>
					{{ $cartItem['deviceDetails']['name'] }}<br/>
					New from BetterWorld Wireless
				</td>
				<td>
					<a href="#" class="cause-button" cid="{{ $key }}" style="width:60%">Edit</a>
					<div class="clearfix"></div>
				</td>
				<td>
					&nbsp;
				</td>
				<td>
					{{ '$' . number_format($cartItem['deviceDetails']['price'] , 2, '.', '') }}
				</td>
			</tr>
			<tr>
				<td>Plan:	</td>
				<td>
					{{ $cartItem['planDetails']['name'] }}<br/>
					<!-- 1200 minutes, unlimited messages, 750 MB data -->
				</td>
				<td>
					<a href="#" class="cause-button" style="width:60%">Edit</a>
					<div class="clearfix"></div>
				</td>
				<td>
					{{ '$' . number_format($cartItem['planDetails']['price'] , 2, '.', '') }}
				</td>
				<td>
					&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan="4">One-Time Activation Fee</td>
				<td>
					{{ '$' . number_format($cartItem['activationFee'] , 2, '.', '') }}
				</td>
			</tr>
		</table>
	</div>
	<div class="clearfix"></div>
</div>
@endforeach


<div class="cart-item row"></div>

<div class="cart-item cart-summary row">
	<h4>Summary</h4>
</div>
<div class="cart-summary row">
	
	<div class="col-xs-1 col-sm-1 col-lg-1">
		<h4>Shipping</h4>
	</div>
	<div class="col-xs-11 col-sm-11 col-lg-11">
		<table class="table shopping-table">
			<tbody><tr>
        
				<td colspan="4">&nbsp;</td>
				<td class="orange-text">FREE</td>
			</tr>
		</tbody></table>
	</div>
</div>
<div class="cart-summary row">
	<div class="col-xs-1 col-sm-1 col-lg-1">
		<h4>Estimated tax</h4>
	</div>
	<div class="col-xs-11 col-sm-11 col-lg-11">
		<table class="table shopping-table">
			<tbody><tr>
        
				<td colspan="4">&nbsp;</td>
				<td>$0.00</td>
			</tr>
		</tbody></table>
	</div>
</div>
<div class="pull-right" style="margin-right: -15px; width: 36%;">
	<table style="float: right; width: 70%;" class="table summary-table">
     	<tbody>
     		<tr>
    			<td style="width: 45%;"><strong>Due Today*</strong></td>
				<td><strong>{{ '$' . number_format($dueAmount , 2, '.', '') }}</strong></td>
			</tr>
			<tr>
    			<td style="width: 45%;">Due Monthly</td>
				<td>{{ '$' . number_format($monthlydue , 2, '.', '') }}</td>
			</tr>
		</tbody>
	</table>
	<div class="clearfix"></div>
	<a id="checkout" style="float: right; width: 45%;" href="#" class="orange-button">CHECKOUT</a>
	<div class="clearfix"></div>
</div>

</div>