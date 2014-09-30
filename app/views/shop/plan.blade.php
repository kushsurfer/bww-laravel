@extends('layouts.main')

@section('head')
    @parent
    <title>Service Plans</title>
@stop

@section('content')
	<h1 class="shopheaderall">Shop</h1>
	<div class="shopbg">
		<img src="/images/cellphone.png" width="7%" class="pull-left"/>
		<h2 class="pull-left"> &nbsp;&nbsp;&nbsp;Select a Plan</h2>
		<div class="clearfix"></div>
		<div class="productdetails">

			@foreach ($products as $prod)
	    		<a href="{{ URL::route('deviceDetail', $prod['product_id']) }}" class="selectshop">
					<h3>{{ $prod['name'] }}</h3>
					<div class="col-xs-5 col-sm-5 col-md-5">
						<img src="{{ $prod['images'][0] }}" width="90%"/>
					</div>
				</a>
				<div class="col-xs-7 col-sm-7 col-md-7">
					<p>{{ $prod['short_description'] }}</p>
					
					<p>
					  <button type="button" class="btn btn-primary btn-lg">Select</button>
					</p>
				</div>
				<div class="clearfix"></div>

			@endforeach

		</div>
	</div>
@stop