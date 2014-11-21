
		<h3 class="option-text" >BRING YOUR OWN DEVICE</h3>
		<h4 id="compatibility" class="hsearch-main">Check below. If your phone is compatible, you can select our monthly plan.</h4><br/>
		<h4 class="meid-res" style="display:none">Great! Your phone is compatible & eligible for Betterworld Wireless.</h4><br/>
		<div id="search-phone" style="display:block" class="hsearch-main">
			<h5>Search for your current phone</h5>
			<div class="col-xs-6 col-sm-6 col-lg-6 " style="padding-left:0px" >
				<input id="bhandset" class="search pull-left" type="text" style="width: 81%;" value="">
				<a class="orange-button pull-left" href="#" id="search-handset"><img src="<?php echo url();?>/images/search_icon.png"></a>
				<div class="clearfix"></div>
			</div>
		</div>
		<div style="padding-left:0px;display:none" class="col-xs-6 col-sm-6 col-lg-6 meid-res">
			<img class="pull-left" src="http://laravel.dev/images/sample_device.jpg">
			<div class="pull-left" style="width:80%;margin-top:2%">
				<div id="input-meid">
					Dial *#06# to display your 15-digit IMEI number. Enter it below.<br/><br/>
					<input type="text" value="" style="width: 76%;" class="search pull-left" id="meid" placeholder="Enter a 15 digit IMEI number">
					<a href="#" class="orange-button pull-left" id="check-meid">CHECK</a>
					<div class="clearfix"></div>
				</div>
				
				<div id="valid-meid" style="display:none">
  					<h4>Your IMEI number: 123456789101112 <a class="orange-link" href="#">Edit</a></h4><br/>
					<a style="width: 68%;" href="#" class="orange-button" id="selectplan">Next To Choose a Plan</a>
				</div>
			</div>
		</div>
		<div class="col-xs-6 col-sm-6 col-lg-6 "></div>
		<div class="clearfix"></div>
		<!-- device list -->
		<div class="device-list hsearch-main" >
			<div class="hmanufacturer">
				<strong>Acer</strong><br/>
				<div class="col-xs-3 col-sm-3 col-lg-3 ">
					<ul>
						<li>Acer Liquid Z500</li>
						<li>Acer Liquid X1</li>
						<li>Acer Liquid Jade</li>
						<li>Acer Liquid E700</li>
					</ul>
				</div>
				<div class="col-xs-3 col-sm-3 col-lg-3 ">
					<ul>
						<li>Acer Liquid Z500</li>
						<li>Acer Liquid X1</li>
						<li>Acer Liquid Jade</li>
						<li>Acer Liquid E700</li>
					</ul>
				</div>
				<div class="col-xs-3 col-sm-3 col-lg-3 ">
					<ul>
						<li>Acer Liquid Z500</li>
						<li>Acer Liquid X1</li>
						<li>Acer Liquid Jade</li>
						<li>Acer Liquid E700</li>
					</ul>
				</div>
				<div class="col-xs-3 col-sm-3 col-lg-3 ">
					<ul>
						<li>Acer Liquid Z500</li>
						<li>Acer Liquid X1</li>
						<li>Acer Liquid Jade</li>
						<li>Acer Liquid E700</li>
					</ul>
				</div>
				<div class="clearfix"></div>
			</div>

			<div class="hmanufacturer">
				<strong>Alcatel</strong><br/>
				<div class="col-xs-3 col-sm-3 col-lg-3 ">
					<ul>
						<li>Alcatel Pop D3</li>
						<li>Alcatel Pop D1</li>
						<li>Alcatel Icon</li>
						<li>Alcatel Fire C</li>
					</ul>
				</div>
				<div class="col-xs-3 col-sm-3 col-lg-3 ">
					<ul>
						<li>Alcatel Pop D3</li>
						<li>Alcatel Pop D1</li>
						<li>Alcatel Icon</li>
						<li>Alcatel Fire C</li>
					</ul>
				</div>
				<div class="col-xs-3 col-sm-3 col-lg-3 ">
					<ul>
						<li>Alcatel Pop D3</li>
						<li>Alcatel Pop D1</li>
						<li>Alcatel Icon</li>
						<li>Alcatel Fire C</li>
					</ul>
				</div>
				<div class="col-xs-3 col-sm-3 col-lg-3 ">
					<ul>
						<li>Alcatel Pop D3</li>
						<li>Alcatel Pop D1</li>
						<li>Alcatel Icon</li>
						<li>Alcatel Fire C</li>
					</ul>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="hmanufacturer">
				<strong>Allview</strong><br/>
				<div class="col-xs-3 col-sm-3 col-lg-3 ">
					<ul>
						<li>Allview X2 Soul Mini</li>
						<li>Allview Impera S</li>
					</ul>
				</div>
				<div class="col-xs-3 col-sm-3 col-lg-3 ">
					<ul>
						<li>Allview X2 Soul Mini</li>
						<li>Allview Impera S</li>
					</ul>
				</div>
				<div class="clearfix"></div>
			</div>	
		</div>

		<div class="device-list meid-res" id="compatible" style="display:none">
			<strong>FAQ</strong>
			<p>
				You need an unlocked GSM phone to use the BetterWorld Wireless Network.<br/>
				<a href="#">How can I tell if it's unlocked?</a><br/>
				<br/>
				<a href="#">What if I don't see a number or it's fewer than 15 digits?</a><br/>
				<a href="#">What is an IMEI number?</a>
			</p>
		</div>
	<?php #var_dump($byosdhansets);?>