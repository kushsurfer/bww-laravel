@foreach($causeprod as $cause)
<div class="col-lg-12">
	<div class="cause-msg">
		<div class="content-msg">
			<span class="msg-header">{{ $cause['cause_how'] }}</span>
			<div class="mobile-all">
				<h2>{{ strtoupper($cause['name']) }}</h2>
				<p>Mission: {{ $cause['cause_mission'] }}<br/>
					Where: {{ $cause['cause_where'] }}<br/>
					Goal: {{ $cause['cause_goal'] }} &nbsp;Sponsors: {{ (!empty($cause['cause_sponsors'])) ? $cause['cause_sponsors'] : '###' }}<br/>
					URL: {{ $cause['cause_url'] }}
				</p>
			</div>
		</div>
	</div>
	<div class="content-msg">
		
		<div class="mobile-all">
			<h2>{{ strtoupper($cause['name']) }}</h2>
				<p>Mission: {{ $cause['cause_mission'] }}<br/>
					Where: {{ $cause['cause_where'] }}<br/>
					Goal: {{ $cause['cause_goal'] }} &nbsp;Sponsors: {{ (!empty($cause['cause_sponsors'])) ? $cause['cause_sponsors'] : '###' }}
				</p>
			<span class="cause-button">Goal: {{ $cause['cause_goal'] }}</span>
			<span class="cause-button">Sponsors: {{ (!empty($cause['cause_sponsors'])) ? $cause['cause_sponsors'] : '###' }}</span>
			<a href="#" class="cause-button orange-button" id="select-sponsor" style="color:#fff" cid="{{ $cause['product_id'] }}">SPONSOR</a>
			<div class="clearfix"></div>
		</div>
	
	</div>
	<div class="cause-info">{{ $cause['description'] }}</div>

</div>
@endforeach