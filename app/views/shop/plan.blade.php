@extends('layouts.main')

@section('head')
    @parent
    <title>Service Plan</title>
@stop

@section('content')
	<h1 class="shopheaderall">Shop</h1>
	<div class="shopbg">
		<img src="/images/cellphone.png" width="7%" class="pull-left"/>
		<h2 class="pull-left"> &nbsp;&nbsp;&nbsp;Select a Plan</h2>
		<div class="clearfix"></div>
		<div class="productdetails">

			
	    		<a href="#" class="selectshop">
					<h3>The Just Plan</h3>
					<div class="col-xs-5 col-sm-5 col-md-5">
						<img src="/images/no-image.png" width="90%"/>
					</div>
				</a>
				<div class="col-xs-7 col-sm-7 col-md-7">
					<p>Talk – $0.03 per
						Data - $0.03 per MB
						SMS Text - $0.01 per text </p>
					
					<p>
					  <button type="button" class="btn btn-primary btn-lg">Select</button>
					</p>
				</div>
				<div class="clearfix"></div>

		

		</div>
	</div>
@stop