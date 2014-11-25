@foreach ($products as $prod)
<div class="col-xs-6 col-sm-6 col-lg-6">
	<img src="{{ $prod['images'][0] }}" style="width:100%">
</div>
<div class="col-xs-6 col-sm-6 col-lg-6">
	<h2>{{ $prod['name'] }}</h2>
	<p>{{ $prod['short_description'] }}</p>
	<span class="price">{{ '$' . number_format($prod['price'] , 2, '.', '') }}</span><br/><br/>
	<a style="width: 50%;" href="#" class="orange-button" id="selectdevice">SELECT</a>
</div>

<div class="clearfix"></div>

<div class="device-list">
	<!-- <div class="col-xs-6 col-sm-6 col-lg-6">
		<h4>Specifications</h4>
		<br/>
		Size and Weight<br/>
		5.75 x 2.83 x 0.30 inches<br/>
		5.36 ounce<br/>
		Connectivity<br/>
		Sync methods: 802.11a/b/g/n/ac, Wi-Fi<br/>
		4G Capable<br/>
		4G LTE Capable<br/>
		Wi-Fi Calling<br/>
		Operating System and Processor<br/>
		Android 4.4<br/>
		2.5GHz Quad core application processor<br/>
		Memory<br/>
		3GB RAM, 32GB ROM (user memory)<br/>
		Battery Life<br/>
		Up to 21 hours talk time<br/>
		Up to 21 days standby time<br/>
		Camera<br/>
		20.7 Megapixel Camera<br/>
		Front-facing Camera<br/>
		Office Hub<br/>
		GPS <br/>
		GPS enabled<br/>
		International<br/>
		Quad Band GSM; LTE: 2, 4; UMTS: Band I (2100), Band II (1900), Band IV (1700/2100), Band V (850), Band VIII (900)<br/>
		Hearing Aid Compatibility<br/>
		M3 & T3<br/>
		Alerts
	</div>
	<div class="col-xs-6 col-sm-6 col-lg-6">
		<h4>In The Box</h4>
		<br/>
		Size and Weight<br/>
		5.75 x 2.83 x 0.30 inches<br/>
		5.36 ounce<br/>
		Connectivity<br/>
		Sync methods: 802.11a/b/g/n/ac, Wi-Fi<br/>
		4G Capable<br/>
		4G LTE Capable<br/>
		Wi-Fi Calling<br/>
		Operating Syste<br/>
	</div> -->
	{{ $prod['description'] }}
</div>
@endforeach