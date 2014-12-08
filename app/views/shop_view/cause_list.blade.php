<div class="col-lg-12">
	<div class="cause-msg">
		<div class="content-msg">
			<span class="msg-header">What if you could help someone who sleeps on the streets find a home?</span>
			<div class="mobile-all">
				<h2 style="text-decoration:underline">MOBILE<span style="color:#fe8700">4</span>ALL</h2>
				<p>
					Mission: End homelessness<br/>
					Where: U.S. <br/>
					What: Smartphones<br/> 
					Goal: 250 Sponsors: ###
				</p>
			</div>
		</div>
	</div>
	<div class="cause-description">
		<p>	
			<strong>Excepteur sint occaecat cupidatat non proident</strong><br/>
		 	Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		 </p>
	</div>

	<?php $cnt = 1; ?>
	@foreach($causes as $cause)
	<div class="cause{{$cnt}} cause-item">
		<h2 class="cause-name" cid="{{ $cause['product_id'] }}">{{ $cause['name'] }}</h2>
		<p>
			{{ $cause['short_description'] }}
		</p>
	</div>
	<?php $cnt++; ?>
	@endforeach

</div>