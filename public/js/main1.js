$(document).ready(function(){

	var orderCnt = 0; // number of bundle order (device, plan & cause)
	var cart = {}; // store cart product selection

	var backorder = []; // set history for page order view

	var selectedpackage = '';
	var selectedbyosd = '';

	cart[orderCnt] = {};

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
 	
	// load byosd list of devices in the background 
 	$.get("getDeviceList", function( data ) {
		$('#device-container').html(data);

		// intialize event functions
		Devices.initialize();

		// scroll to device list section
		$(document).scrollTo('#device-container', 800, {offset:-150});
	});



	// load byosd list of devices in the background 
 	$.get("getPlanOption", function( data ) {
		$('#plan-container').html(data);
		
		// intialize event functions
		Plans.initialize();

		// scroll to plan options
		$(document).scrollTo('#plan-container', 800, {offset:-150});
	});



	// load byosd list of devices in the background 
 	$.get("causes", function( data ) {
		$('#causeselection').html(data);


	 	$('.cause-name').on('click', function(){


			displayPageSection('page-section', 'cause-detail');

			//load byosd list of devices in the background 
		 	$.get( baseurl + "causeDetail/" + $(this).attr('cid'), function( data ) {
				$('#cause-detail').html(data);

		 		addbackHistory('causeselection');


				$('#select-sponsor').on('click', function(){

					cart[orderCnt]['causeID'] = $(this).attr('cid');



					var data = {'deviceID' : cart[orderCnt]['deviceID'], 'planID' : cart[orderCnt]['planID'], 'causeID' : cart[orderCnt]['causeID']}

					if(cart[orderCnt]['deviceID'] == 'BYOD'){
						data.byoshandset = cart[orderCnt]['byoshandset'];
						data.meid = cart[orderCnt]['meid'];
					}

					$.ajax({
						type: "POST",
						url: baseurl + 'shopAddtoCart',
						data : data,
			            success  : function (resp) {
			             	// load byosd list of devices in the background 
						 // 	$.get("getCurrentCartInfo", function( data ) {
							// 	console.log(data);
								
							// });	
			             
			            }
					});

					displayPageSection('page-section', 'another-device');

					addbackHistory('cause-detail');

					console.log(cart);
					
				});

				$(document).scrollTo('#cause-detail', 800, {offset:-150});
				
			});

	 		

	 	});
		
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



 	$('#addevice').on('click', function(){

 		// reset/update orderset data
 		orderCnt++;
 		selectedpackage = '';
 		selectedbyosd = '';
 		cart[orderCnt] = {};


 		displayPageSection('page-section', 'deviceselection');

 		addbackHistory('another-device');


 	});


 	$('.proceedcheckout').on('click', function(event){

 		var formData = $('#create-account-form').serialize();

 		$.each($('.errormsg'), function(){
 			$(this).text('');
 		})
 		$.each($('.form-group'), function(){
 			$(this).removeClass('has-error');
 		})

		$.ajax({
			type: "POST",
			url: $('#create-account-form').attr('action'),
			data : formData,
            success  : function (data) {

            	data = JSON.parse(data);

            	if(data.success){
            		addbackHistory('create-account');

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

            	}
            	else{
            		$.each(data.errors, function(index, error){
	               		$('#'+ index + 'Box').addClass('has-error');
	               		$('#'+ index + 'Error').text(error);
					});
            	}
              
            }
		}); 	 	

 		event.preventDefault();
 	

 	});



 	$('#gotoshoppingcart').on('click', function(){

 		addbackHistory('another-device');

		console.log(backorder);
 		
 		$('#shopping-cart').html('<div class="loader"></div>');

 		$.get("orderSummary", function( data ) {
			$('#shopping-cart').html(data);

			$('#checkout').on('click', function(event){
				displayPageSection('page-section', 'create-account');

				addbackHistory('shopping-cart');

				console.log(backorder);
				
				event.preventDefault();
			});

			$(document).scrollTo('#shopping-cart', 800, {offset:-150});
		});

 		displayPageSection('page-section', 'shopping-cart');


 	});


	$('#check-meid').on('click', function(){

		if($('#meid').val() != ''){

			$('#showloader').addClass('loader');

			$.ajax({
				type: "POST",
				url: $('#checkmeid').val(),
				data : {'meid' : $('#meid').val() },
	            success  : function (resp) {
	               	
	               	$('#showloader').removeClass('loader');
	            	
	            	if(resp == 'Found'){

	            		$('#validmeid').text($('#meid').val());

	            		cart[orderCnt]['deviceID'] = 'BYOD';
	            		cart[orderCnt]['byoshandset'] = selectedbyosd;
	            		cart[orderCnt]['meid'] = $('#meid').val();


	            		displayPageSection('page-section', 'byosd-editmeid');

						addbackHistory('byosd-checkmeid');

	            	}else {

	            		alert(resp);
	            	
	            	}
	            }
			});

			
		}else{
			alert('Kindly enter IMEI number');
		}
		
								
		
	})



	$('#editBYOSD').on('click', function(){
		displayPageSection('page-section', 'byosd-list');

		// addbackHistory('byosd-editmeid');

		// console.log(backorder);
	})



	$('#selectplan').on('click', function(){

		
		if(cart[orderCnt]['byoshandset'] !== undefined){

			if(cart[orderCnt]['planID'] === undefined ){
				displayPageSection('page-section', 'planselection');
			}else{
				displayPageSection('page-section', 'causeselection');
			}

			addbackHistory('byosd-editmeid');

		}else{
			alert('Kindly provide a valid IMEI number first.')
		}

	})


 	$('#back-button').on('click', function(){


 		var containerID = backorder.pop();

 		if(containerID != 'acct-info'){
	 		$( ".page-section" ).each(function() {
			  //$(this).hide();
			});

	 		//$('#' + containerID).show();
	 		$(document).scrollTo('#' + containerID, 800, {offset:-150});
	 	}else {
	 		$('#' + containerID).show();
	 		$('#ccvalidation').hide();
	 	}

 		
	 	if(backorder.length == 0){
	 		$('#back-button').hide();
	 	}


 	});


    /*$('.orange-border').waypoint(function(direction){
        if (direction == 'down') {
            $(this).addClass('fixed-bar');
        }
        else {
            $(this).removeClass('fixed-bar');
        }
    });*/


 	function displayPageSection(classname, id){

 		$( "." + classname ).each(function() {
		  //$(this).hide();
		});

 		$('#' + id).show();

 		// scrolls to the newly opened section when user selects an option
 		$(document).scrollTo('#' + id, 800, {offset:-150});
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

				if($( "#bhandset_hidden" ).val() != ''){

					addbackHistory('byosd-list');
					selectedbyosd = $( "#bhandset_hidden" ).val();

					displayPageSection('page-section', 'byosd-checkmeid');
				}else{
					alert('Kindly provide your current phone.');
				}

				
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

				$('#device-detail').html('<div class="loader"></div>');

				displayPageSection('page-section', 'device-detail');
				
				$.get($(this).attr('href'), function( data ) {
					
					$('#device-detail').html(data);
					
					$('#selectdevice').on('click', function(){

						cart[orderCnt]['deviceID'] = $(this).attr('pid'); // set selected device per order set

						// reset byosdhandset if device is selected
						cart[orderCnt]['byoshandset'] = '';
	            		cart[orderCnt]['meid'] = '';

						if(cart[orderCnt]['planID'] === undefined ){
							displayPageSection('page-section', 'planselection');
						}else{
							displayPageSection('page-section', 'causeselection');
						}

						

						addbackHistory('device-detail');

					});

					$(document).scrollTo('#device-detail', 800, {offset:-150});
				});
			})

    	},
 	}

 	var Plans = {

 		initialize: function () {

       		// load byosdhandset event functions
			$('.select-justplan').on('click', function(event){

				cart[orderCnt]['planID'] = 'BWW_PAYG';

				if(cart[orderCnt]['deviceID'] === undefined ){
					displayPageSection('page-section', 'deviceselection');
				}else{
					displayPageSection('page-section', 'causeselection');
				}

				addbackHistory('just-plan');

				console.log(backorder);
			})


       		// load byosdhandset event functions
			$('.select-package').on('click', function(event){

				if(selectedpackage != ''){

					cart[orderCnt]['planID'] = selectedpackage; // set selected device per order set

					if(cart[orderCnt]['deviceID'] === undefined ){
						displayPageSection('page-section', 'deviceselection');
					}else{
						displayPageSection('page-section', 'causeselection');
					}

					addbackHistory('plan-container');

				}else{
					alert('Kindly select a plan package first.')
				}

				
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