@extends('layouts.main')

@section('head')
    @parent
    <title>Shop Page</title>
@stop

@section('content')
	
	<form action="" id="orderform" class="hide">
		<input type="hidden" id="device" value="" >
		<input type="hidden" id="plan" value="">
		<input type="hidden" id="cause" value="">
		<input type="hidden" id="account" value="">
		<input type="hidden" id="cart" value="">
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
	   		<div class="loader"></div>
  		</div>

	</div>
	<div class="panel panel-primary shoppanels" >
  <!-- Default panel contents -->
		<div class="panel-heading" id="checkout"><span class="arrows">&#9658</span>Checkout</div>
		<div class="panel-body hide">
	   		<div class="loader"></div>
  		</div>

	</div>
@stop