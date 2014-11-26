
		<h3 class="option-text" >BRING YOUR OWN DEVICE</h3>
		<h4 id="compatibility" class="hsearch-main">Check below. If your phone is compatible, you can select our monthly plan.</h4><br/>
		<h4 class="meid-res" style="display:none">Great! Your phone is compatible & eligible for Betterworld Wireless.</h4><br/>
		<div id="search-phone" style="display:block" class="hsearch-main">
			<h5>Search for your current phone</h5>
			<div class="col-xs-6 col-sm-6 col-lg-6 " style="padding-left:0px" >
				<input id="bhandset" class="search pull-left" type="text" style="width: 81%;" value="">
				<input type="hidden" name="selectbyosd" id="bhandset_hidden"  value="">

				<a class="orange-button pull-left" href="#" id="search-handset"><img src="<?php echo url();?>/images/search_icon.png"></a>
				<div class="clearfix"></div>
			</div>
		</div>
		
		<div class="col-xs-6 col-sm-6 col-lg-6 "></div>
		<div class="clearfix"></div>
		<!-- device list -->
		<div class="device-list hsearch-main" >

			<?php 

				// $manufacturer = $byosdhansets[0]->manufacturer;
				$manufacturer = '';
				$cnt = 0;
				$autocompleteList = '';
				
			?>

			@foreach($byosdhansets as $handset)

			@if($manufacturer != $handset->manufacturer)

			@if($cnt != 0)
			</div>
			@endif
			<div class="clearfix"></div>		
			<div class="hmanufacturer">
				<strong>{{ $handset->manufacturer }}</strong><br/>

			<?php 
				$manufacturer = $handset->manufacturer; 
				$cnt = 1;

			?>

			@endif

				<p class="col-xs-3 col-sm-3 col-lg-3 ">{{ $handset->name }}</p>
	
			<?php

			$autocompleteList .= '{value: '.$handset->id.',  label: "'.$handset->name.'"}, ';

			?>		
					
			@endforeach


		</div>

		
	<?php #var_dump($byosdhansets[0]->manufacturer);?>


<script>
$( "#bhandset" ).autocomplete({
  	source: [ <?php echo $autocompleteList; ?> ],
	select: function(event, ui) {  
	    $( "#bhandset" ).val(ui.item.label);  
	    $( "#bhandset_hidden" ).val(ui.item.value);
	    return false;  
	}   
});
</script>