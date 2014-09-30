@extends('layouts.main')

@section('head')
    @parent
    <title>Shop</title>
@stop

@section('content')
	<div  class="shopheader">
		<div class="col-xs-9 col-sm-9 col-md-9">
			<h1>Shop</h1>
		</div>
		
		<div class="col-xs-3 col-sm-3 col-md-3">
			<a class="dropdown-toggle pull-right" style="text-align:right;" href="#" data-toggle="dropdown">
				<img width="50%" style="" src="/images/cart.png">
				<span class="caret" style="margin-top: 5px"></span>
			</a>
			<!-- <ul class="dropdown-menu" role="menu"> -->
	            <!-- <li><a href="#">Action</a></li> -->
	        <!-- </ul> -->
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="shopbg">
		<img src="/images/cellphone.png" width="7%" class="pull-left"/>
		<h2 class="pull-left" > &nbsp;&nbsp;&nbsp;<a href="{{ URL::route('shop') }}" class="selectshop">Select a Device</a></h2>
		<div class="clearfix"></div>
		<div class="productdetails">

			@foreach ($products as $prod)
	    
				<h3>{{ $prod['name'] }}</h3>
				<div class="col-xs-5 col-sm-5 col-md-5">
					<img src="{{ $prod['images'][0] }}" width="90%"/>
				</div>
				<div class="col-xs-7 col-sm-7 col-md-7">
					<p>{{ $prod['short_description'] }}</p>
					<h2>{{ '$' . number_format($prod['price'] , 2, '.', '') }}</h2>

					<p>
					  <button type="button" class="btn btn-primary btn-lg">Select</button>
					</p>
					

				</div>
				<div class="clearfix"></div>
				<p>
					{{ $prod['description'] }}
				</p>
			@endforeach



		</div>
	</div>
@stop