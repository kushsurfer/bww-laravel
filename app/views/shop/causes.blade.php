@foreach ($products as $prod)
	<div class="col-xs-3 col-sm-3 col-md-3">
		<a href="{{ URL::route('planDetail', $prod['product_id']) }}" class="selectshop">
			<span class="name">{{ $prod['name'] }}</span><br/>
			<img src="{{ $prod['images'][0] }}" width="65%"/>
		</a><br/>
		<p class="pricedetails">
			<!-- <span class="name"><a href="{{ URL::route('deviceDetail', $prod['product_id']) }}" class="selectshop">{{ $prod['name'] }}</a></span> -->
			<br/>
			<button type="button" class="btn btn-primary btn-sm causeselect" did="{{ $prod['product_id'] }}">Select</button>
			<br/><span class="price"> {{ $prod['short_description'] }}</span>
			
		</p>
		
	</div>
@endforeach