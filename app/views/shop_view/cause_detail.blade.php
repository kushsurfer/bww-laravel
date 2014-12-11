<?php
/*echo '<pre>';
print_r($causeprod);
echo '</pre>';
*/?>
@foreach($causeprod as $cause)
<div class="col-lg-12">
	<div class="cause-msg">
		<div class="content-msg">
			<span class="msg-header">{{ $cause['name'] }}</span>
			<div class="mobile-all">
				<!-- <h2>MOBILE<span style="color:#fe8700">4</span>ALL</h2> -->
				<p><!-- 
					Mission: End homelessness<br/>
					Where: U.S. <br/>
					What: Smartphones<br/> 
					Goal: 250 Sponsors: ### -->
					{{ $cause['short_description'] }}
				</p>
			</div>
		</div>
	</div>
	<div class="content-msg">
		
		<div class="mobile-all">
			<h2>{{ $cause['name'] }}</h2>
			<p>{{ $cause['short_description'] }}</p>
			<span class="cause-button">Goal 250</span>
			<span class="cause-button">Sponsors:###</span>
			<a href="#" class="cause-button orange-button" id="select-sponsor" style="color:#fff" cid="{{ $cause['product_id'] }}">SPONSOR</a>
			<div class="clearfix"></div>
		</div>
	
	</div>
	<div class="cause-info">
		<!-- <p><strong>Excepteur sint occaecat cupidatat non proident</strong><br/>
Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		</p><p>
Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad min aliquip ex ea commodo consequat. Dr in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p> -->
	{{ $cause['description'] }}
	</div>

</div>
@endforeach