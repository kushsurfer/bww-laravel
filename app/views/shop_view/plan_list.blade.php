<h2>PACKAGE</h2>
<p>Prefer a fixed rate every month? Pick the package that is right for you.</p>
<div class="table-responsive">
	<table class="table table-hover table-condensed package-table ">
		@foreach ($plan_options as $package)
		@if($package['sku'] != 'BWW_PAYG')
		<tr id="{{ $package['product_id'] }}" class="service-plan-item">
			<td><strong>{{ $package['name'] }}</strong></td>
			<td>
				${{ $package['per_month'] }}<br/>
				<span>per month</span>
			</td>
			<td>
				{{ $package['plan_minutes'] }}<br/>
				<span>minutes</span>
			</td>
			<td>
				{{ $package['plan_messages'] }}<br/>
				<span>messages </span>
			</td>
			<td>
				{{ $package['plan_data'] }}<br/>
				<span>data</span>
			</td>
		</tr>
		@endif
		@endforeach
	</table>
</div>
<div style="text-align: center;">
	<a class="orange-button select-package" href="#" style="width: 25%;margin:20px 40%" >SELECT</a>
</div>
<br/><br/>
<div>
	<h5><u>Internation Calling</u></h5>
	<p>
		<strong>Terms:</strong> No contract. Your credit card will be billed once a month and you can cancel anytime. <br/>
		<strong>Included:</strong> Voicemail; 3-way calling; caller ID; hotspot; global messaging and more. <br/>
		<strong>Surcharges:</strong> Monthly fee of $8 per device per month; One-time $6.25 per device activation fee; Bring Your Own Sprint Device (BYOSD) Activation $12.50. <br/>
		<strong>Additional charges and information:</strong> Shipping $15. Taxes and regulatory fees additional. Standard airtime and toll rates apply for: Call Forwarding; Operator Services; Directory Assistance; 911 and E911; and Customer Care. National and international roaming charges additional. International calling charges from U.S. vary by terminating country. <br/>
		<strong>Optional Tethering:</strong> $1.50/month (Please note: Your chosen data plan rates will apply.); Directory Assistance $1/min; Number Porting $5.50; Call Tracing $20. Please visit our FAQs for more information.<br/>

	</p>
</div>