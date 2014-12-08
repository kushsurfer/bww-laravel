var backorder = []; // set history for page order view

$(document).ready(function(){

	var orderCnt = 0; // number of bundle order (device, plan & cause)
	var cart = {}; // store cart product selection
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


				$('#select-sponsor').on('click', function(event){
					event.preventDefault();

					cart[orderCnt]['causeID'] = $(this).attr('cid');

					var data = {'deviceID' : cart[orderCnt]['deviceID'], 'planID' : cart[orderCnt]['planID'], 'causeID' : cart[orderCnt]['causeID']}

					if(cart[orderCnt]['deviceID'] == 'BYOD'){
						data.byoshandset = cart[orderCnt]['byoshandset'];
						data.meid = cart[orderCnt]['meid'];
					}

					$('#cause-detail').append('<div class="loader"></div>');
					$(document).scrollTo('#cause-detail .loader', 800, {offset:-150});

					$.ajax({
						type: "POST",
						url: baseurl + 'shopAddtoCart',
						data : data,
			            success  : function (resp) {
			            	$('#cause-detail .loader').remove();

			             	displayPageSection('page-section', 'another-device');

							addbackHistory('cause-detail');

							console.log(cart);			             
			            }
					});
					
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


 	$(document).on('click', '.cc-types a', function(e) {
 		e.preventDefault();

 		var selectedCard = $(this).attr('data-id');

 		$('.cc-types a').removeClass('selected');
 		$(this).addClass('selected');

 		//set input
 		$('#ccardtype').val(selectedCard);
 	});


 	$('#manualAccount').on('click', function(event){

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

            	if (data.success){
					displayAcctInfoSection();
            	}
            	else {
            		$.each(data.errors, function(index, error){

               		$('#'+ index + 'Box').addClass('has-error');
               		$('#'+ index + 'Error').text(error);
				})
            	}
              
            }
		}); 	 	

 		event.preventDefault();
 	});


	// See changes below
    $('#fblogin').on('click', function(event) {
    	event.preventDefault();
    	 var  screenX    = typeof window.screenX != 'undefined' ? window.screenX : window.screenLeft,
             screenY    = typeof window.screenY != 'undefined' ? window.screenY : window.screenTop,
             outerWidth = typeof window.outerWidth != 'undefined' ? window.outerWidth : document.body.clientWidth,
             outerHeight = typeof window.outerHeight != 'undefined' ? window.outerHeight : (document.body.clientHeight - 22),
             width    = 900,
             height   = 570,
             left     = parseInt(screenX + ((outerWidth - width) / 2), 10),
             top      = parseInt(screenY + ((outerHeight - height) / 2.5), 10),
             features = (
                'width=' + width +
                ',height=' + height +
                ',left=' + left +
                ',top=' + top
              );

            var winObj = window.open(baseurl+'/facebook/authorize','Login_by_facebook',features);
	    	var loop = setInterval(function() {   
			    if(winObj.closed) {  
			    	// alert('closed')
			        clearInterval(loop);  
			        $.get( "checkCustomerSession", function( resp ) {
			        	
			        	console.log(backorder);
						if(resp.success){
							displayAcctInfoSection();
						}
						
					});
				 	
			        // check if customerID is set
			    }  
			}, 1000);

  	 
           	if (window.focus) {
           		winObj.focus()
           	}

	    	
      });

	     // See changes below
         // See changes below
    

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
	 		$('#cart-button').hide();
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
 		$('#cart-button').show();

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



function displayPageSection(classname, id){

	$( "." + classname ).each(function() {
	  $(this).hide();
	});

	$('#' + id).show();
}

function addbackHistory(container_id){
	$('#back-button').show();
	$('#cart-button').show();

	backorder.push(container_id);
}


function displayAcctInfoSection(){
	addbackHistory('create-account');
	displayPageSection('page-section', 'checkout-container');

	$.get("checkout", function( data ) {
		$('#checkout-container').html(data);

		$('.custom-checkbox').on('click', function(){
			if($(this).text() == 'X'){
				$(this).text('');
				$('#'+$(this).attr('inputid')).val('0');
			}else{
				$(this).text('X');
				$('#'+$(this).attr('inputid')).val(1);
			}



		})


		$('#sameShipping').on('click', function(event){
			
			$( ".billing-element" ).each(function() {

				var value = $(this).val();
				var id = '#ship'+$(this).attr('id');

				if($(this).attr('id') == 'state'){
					$(id+' option[value="'+value+'"]').prop("selected", true);
				}else{
					$(id).val(value);
				}
				
			});

		});


		$('#submitAcctInfo').on('click', function(event){

			if($('#terms').val() == 0){
				$('#termsError').text('Terms and Conditions is required.');

			}else{
				var formData = $('#account-information-form').serialize();

				$.each($('.errormsg'), function(){
		 			$(this).text('');
		 		})
		 		$.each($('.form-group'), function(){
		 			$(this).removeClass('has-error');
		 		})

		 		$('#acct-info').hide();
		 		$('#checkoutloader').show();

		 		$.ajax({
					type: "POST",
					url: $('#account-information-form').attr('action'),
					data : formData,
		            success  : function (resp) {

		            	resp = JSON.parse(resp);

		            	$('#checkoutloader').hide();
		            	if(resp.success){

							$('#acct-info').hide();
							$('#ccvalidation').show();
							$('#checkoutloader').hide();

							$('#estimateTax').text(resp.estimatedTax);

							addbackHistory('acct-info');

		            	}else{
		            		$('#acct-info').show();
		            		$.each(resp.errors, function(index, error){

			               		$('#'+ index + 'Box').addClass('has-error');

			            		if(index.search( 'ship') === -1)	{
			            			$('#'+ index + 'Error').text(error);
			            		}else{
			            			var err =  error.toString();
			            			
			            			err = err.replace("ship", "");

			            			$('#'+ index + 'Error').text(err);
			            		}
			               			
							})
		            	}
		              
		            }
				}); 	 	

			}

			

			event.preventDefault();

			console.log(backorder);
		});


		$('#validateCCard').on('click', function(event){

			var formData = $('#credit-card-form').serialize();

			$.each($('.errormsg'), function(){
	 			$(this).text('');
	 		})
	 		$.each($('.form-group'), function(){
	 			$(this).removeClass('has-error');
	 		})

	 		$('#ccvalidation').hide();
	 		$('#checkoutloader').show();

	 		$.ajax({
				type: "POST",
				url: $('#credit-card-form').attr('action'),
				data : formData,
	            success  : function (resp) {
	            	resp = JSON.parse(resp);
	            	$('#checkoutloader').hide();
	            	if(resp.success){
	            		$('#checkoutloader').html('<h4>Order Complete!</h4>');
						
	            	}else{
	            		$('#ccvalidation').show();
	            		$.each(resp.errors, function(index, error){

		               		$('#'+ index + 'Box').addClass('has-error');
	            			$('#'+ index + 'Error').text(error);
		               			
						})
	            	}
	              
	            }
			}); 	 	

	 		event.preventDefault();

		});
		
	});
}

document.getElementById('LoginWithAmazon').onclick = function() {
	 setTimeout(window.doLogin, 1);
 	return false;
};

window.doLogin = function() {
	 options = {};
	 options.scope = 'profile';
	 amazon.Login.authorize(options, function(response) {
	 if ( response.error ) {
	 alert('oauth error ' + response.error);
	 return;
}

amazon.Login.retrieveProfile(response.access_token, function(response) {

 	var data = {'name' : response.profile.Name, 'email_address' : response.profile.PrimaryEmail, 'oauthID' : response.profile.CustomerId};

 	$.ajax({
		type: "POST",
		url: baseurl + 'createCustomerAmazon',
		data : data,
        success  : function (resp) {
         	if(resp.success){
				displayAcctInfoSection();
			}
		
         
        }
	});

 	if ( window.console && window.console.log )
 		window.console.log(response);
 	});

	addbackHistory('create-account');
	displayPageSection('page-section', 'checkout-container');
 });
	 
};
