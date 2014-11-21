$(document).ready(function(){


 	$('.navbar-toggle').on('click', function(){
 		$('#navbar').css('background-color', '#c9c9c9');
 	});


 	$( window ).resize(function() {
	 	$('#navbar').css('background-color', 'transparent');
	});


 	
	//load byosd list of devices in the background 
 	$.get( "byosdhandset", function( data ) {
		$('#byosd-list').html(data);

		BYOSDHandset.initialize();
		
		
	});
 	
	//load byosd list of devices in the background 
 	$.get( baseurl + "causeDetail/1", function( data ) {
		$('#cause-detail').html(data);

		$('#select-sponsor').on('click', function(){
			displayPageSection('page-section', 'another-device');
		})
		
		
	});

	// load byosd list of devices in the background 
 	$.get("getDeviceList", function( data ) {
		$('#device-container').html(data);

		// intialize event functions
		Devices.initialize();
		
	});



	// load byosd list of devices in the background 
 	$.get("getPlanOption", function( data ) {
		$('#plan-container').html(data);

		// intialize event functions
		Plans.initialize();
		
	});



 	$('.select-section').on('click', function() {

 		var pagesectionID = $(this).parent().attr('id');

 		
 		var cid = $(this).attr('cid');

 		displayPageSection('page-section', cid);

 		// set back section id
 		$('#back-button').show().attr('cid', pagesectionID);

 	});


 	$('.plan-packages').on('click', function() {

 		var pagesectionID = $(this).parent().attr('id');

 		
 		var cid = $(this).attr('cid');

 		displayPageSection('page-section', cid);

 		// set back section id
 		$('#back-button').show().attr('cid', pagesectionID);

 	});



 	$('#back-button').on('click', function(){

 		$( ".page-section" ).each(function() {
		  $(this).hide();
		});

 		$('#' + $(this).attr('cid')).show();

 	});



 	$('.cause-name').on('click', function(){

 		displayPageSection('page-section', 'cause-detail');


 	});



 	$('#addevice').on('click', function(){

 		displayPageSection('page-section', 'deviceselection');


 	});



 	$('#gotoshoppingcart').on('click', function(){

 		
 		$.get("orderSummary", function( data ) {
			$('#shopping-cart').html(data);

			// intialize event functions
			// Devices.initialize();
			
		});

 		displayPageSection('page-section', 'shopping-cart');


 	});


 	function displayPageSection(classname, id){

 		$( "." + classname ).each(function() {
		  $(this).hide();
		});

 		$('#' + id).show();
 	
 	}

 	function checkSectionHistory(){
 		// for back button display
 	}

 	var BYOSDHandset = {

 		initialize: function () {

       		// load byosdhandset event functions
			$('#search-handset').on('click', function(){
				$( ".hsearch-main" ).each(function() {
				  $(this).hide();
				});

				$( ".meid-res" ).each(function() {
				  $(this).show();
				});
			})


			$('#check-meid').on('click', function(){

				$('#input-meid').hide();
				$('#valid-meid').show();
			})

			$('#selectplan').on('click', function(){

				displayPageSection('page-section', 'planselection');

			})
    	},
 	}


 	var Devices = {

 		initialize: function () {

       		// load byosdhandset event functions
			$('.device-name').on('click', function(event){
				$(this).attr('href');
				event.preventDefault();

				$('#device-container').html('<div class="loader"></div>');

				$.get($(this).attr('href'), function( data ) {
					
					$('#device-container').html(data);

					$('#selectdevice').on('click', function(){

						displayPageSection('page-section', 'planselection');

					})
					
				});
			})


			

    	},
 	}

 	var Plans = {

 		initialize: function () {

       		// load byosdhandset event functions
			$('.select-package').on('click', function(event){
				displayPageSection('page-section', 'causeselection');
			})


			

    	},
 	}






});