	<h3 class="section-title">DEVICE</h3>
	<p>Choose a device from us or from one of our authorized partners</p>
	
	<div class="handset-list row col-xs-12 col-sm-12 col-lg-12">

		@foreach ($products as $prod)
		@if($prod['sku'] != 'BYOD')
		<div class="col-xs-4 col-sm-4 col-lg-4 hanset-item">
			<a href="{{ URL::route('deviceDetail', $prod['product_id']) }}" class="device-name">
				<div class="handset-container">
					<h5>{{ $prod['name'] }}</h5>
					<div class="col-xs-4 col-sm-4 col-lg-4">						
						<img class="pull-left" src="{{ $prod['images'][0] }}">
					</div>
					<div class="hanset-info col-xs-8 col-sm-8 col-lg-8">
						<div class="prod-desc">{{ $prod['short_description'] }} <br/></div>
						<span class="price">{{ '$' . number_format($prod['price'] , 2, '.', '') }}</span><br/>
						<!-- <a href="#" class="orange-button" id="selectdevice" did="{{ $prod['product_id'] }}">SELECT</a> -->
					</div>
				</div>
			</a>
		</div>		

		@endif
		@endforeach
		<!-- <div class="col-xs-4 col-sm-4 col-lg-4 hanset-item">
			<div class="handset-container">
				<h5><a href="#" class="device-name">Device Name</a></h5>
				<img class="pull-left" src="http://laravel.dev/images/nopic_handset.jpg">
				<div class="hanset-info pull-left">
					Short Description <br/>
					<span class="price">$0.00</span><br/>
					<a href="#" class="orange-button" id="selectdevice">SELECT</a>
				</div>
			</div>
		</div-->		
	</div>