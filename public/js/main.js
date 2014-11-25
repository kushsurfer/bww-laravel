$(document).ready(function(){

	var orderCnt = 0; // number of bundle order (device, plan & cause)
	var cart = {}; // store cart product selection

	var backorder = []; // set history for page order view

	var selectedpackage = '';


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

			addbackHistory('cause-detail');

			console.log(backorder);
			
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

 		addbackHistory(pagesectionID);

		console.log(backorder);

 	});


 	$('.plan-packages').on('click', function() {

 		var pagesectionID = $(this).parent().attr('id');

 		
 		var cid = $(this).attr('cid');

 		displayPageSection('page-section', cid);

 		
 	});



 	$('.cause-name').on('click', function(){

 		displayPageSection('page-section', 'cause-detail');

 		addbackHistory('causeselection');

		console.log(backorder);

 	});



 	$('#addevice').on('click', function(){

 		displayPageSection('page-section', 'deviceselection');

 		addbackHistory('another-device');

		console.log(backorder);


 	});


 	$('.proceedcheckout').on('click', function(event){

 		addbackHistory('create-account');

		console.log(backorder);

 		$.get("checkout", function( data ) {
			$('#checkout-container').html(data);

			displayPageSection('page-section', 'checkout-container');

			$('#submitAcctInfo').on('click', function(){

				$('#acct-info').hide();
				$('#ccvalidation').show();

				addbackHistory('acct-info');

				console.log(backorder);
			});
			
		});

 		event.preventDefault();
 	

 	});



 	$('#gotoshoppingcart').on('click', function(){

 		addbackHistory('another-device');

		console.log(backorder);
 		
 		$.get("orderSummary", function( data ) {
			$('#shopping-cart').html(data);

			$('#checkout').on('click', function(event){
				displayPageSection('page-section', 'create-account');

				addbackHistory('shopping-cart');

				console.log(backorder);
				
				event.preventDefault();
			})
			
		});

 		displayPageSection('page-section', 'shopping-cart');


 	});


	$('#check-meid').on('click', function(){
		
		displayPageSection('page-section', 'byosd-editmeid');

		addbackHistory('byosd-checkmeid');

		console.log(backorder);
				
		
	})



	$('#editBYOSD').on('click', function(){
		displayPageSection('page-section', 'byosd-list');

		// addbackHistory('byosd-editmeid');

		// console.log(backorder);
	})



	$('#selectplan').on('click', function(){

		displayPageSection('page-section', 'planselection');

		addbackHistory('byosd-editmeid');

		console.log(backorder);

	})


 	$('#back-button').on('click', function(){


 		var containerID = backorder.pop();

 		if(containerID != 'acct-info'){
	 		$( ".page-section" ).each(function() {
			  $(this).hide();
			});

	 		$('#' + containerID).show();
	 	}else {
	 		$('#' + containerID).show();
	 		$('#ccvalidation').hide();
	 	}

 		
	 	if(backorder.length == 0){
	 		$('#back-button').hide();
	 	}


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

 	function addbackHistory(container_id){
 		$('#back-button').show();

 		backorder.push(container_id);
 	}

 	var BYOSDHandset = {

 		initialize: function () {

       		// load byosdhandset event functions
			$('#search-handset').on('click', function(){
				addbackHistory('byosd-list');

				console.log(backorder);

				displayPageSection('page-section', 'byosd-checkmeid');

				
			})
    	},
 	}


 	var Devices = {

 		initialize: function () {

       		// load byosdhandset event functions
			$('.device-name').on('click', function(event){
				$(this).attr('href');

				event.preventDefault();

				addbackHistory('device-container');

				console.log(backorder);
				$('#device-detail').html('<div class="loader"></div>');
				displayPageSection('page-section', 'device-detail');
				
				$.get($(this).attr('href'), function( data ) {
					
					$('#device-detail').html(data);

					
					$('#selectdevice').on('click', function(){

						displayPageSection('page-section', 'planselection');

						addbackHistory('device-detail');

						console.log(backorder);

					})
					
				});
			})
			

    	},
 	}

 	var Plans = {

 		initialize: function () {

       		// load byosdhandset event functions
			$('.select-justplan').on('click', function(event){
				displayPageSection('page-section', 'causeselection');

				addbackHistory('just-plan');

				console.log(backorder);
			})


       		// load byosdhandset event functions
			$('.select-package').on('click', function(event){
				displayPageSection('page-section', 'causeselection');

				addbackHistory('plan-container');

				console.log(backorder);
			})

			$('.service-plan-item').on('click', function(){
				selectedpackage = $(this).attr('id');

				$( ".service-plan-item" ).each(function() {
				  $(this).removeClass('selectedplan');
				});

				$(this).addClass('selectedplan');

			})

			

    	},
 	}






});