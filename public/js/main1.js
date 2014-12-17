var backorder = []; // set history for page order view

$(document).ready(function(){

	var orderCnt = 0; // number of bundle order (device, plan & cause)
	var cart = {}; // store cart product selection
	var selectedpackage = '';
	var selectedbyosd = '';
	var editCart = false;
	var editCartset = null;

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
	}).fail(function() {
	    // alert("Currently can't load BYOD handset list. Sorry for the inconvience, kindly refresh page");
	    location.reload();
	});;
 	
	// load byosd list of devices in the background 
 	$.get("getDeviceList", function( data ) {
		$('#device-container').html(data);

		// intialize event functions
		Devices.initialize();

		// scroll to device list section
		$(document).scrollTo('#device-container', 800, {offset:-150});
	}).fail(function() {
	    // alert("Currently can't load device list. Sorry for the inconvience, kindly refresh page");

	   location.reload();
	});



	// load byosd list of devices in the background 
 	$.get("getPlanOption", function( data ) {
		$('#plan-container').html(data);
		
		// intialize event functions
		Plans.initialize();

		// scroll to plan options
		$(document).scrollTo('#plan-container', 800, {offset:-150});
	}).fail(function() {
	    // alert("Currently can't load Service plan list. Sorry for the inconvience, kindly refresh page");
	    location.reload();
	});



	// load byosd list of devices in the background 
 	$.get("causes", function( data ) {
		$('#causeselection').html(data);


	 	$('.cause-name').on('click', function(){

			displayPageSection('page-section', 'cause-detail');
			$('#cause-detail').html('<div class="loader"></div>');

			//load byosd list of devices in the background 
		 	$.get( baseurl + "causeDetail/" + $(this).attr('cid'), function( data ) {

				$('#cause-detail').html(data);
				addbackHistory('causeselection');
				displayPageSection('page-section', 'cause-detail');

				$('#select-sponsor').on('click', function(event){
					event.preventDefault();

					cart[orderCnt]['causeID'] = $(this).attr('cid');

					var data = {'deviceID' : cart[orderCnt]['deviceID'], 'planID' : cart[orderCnt]['planID'], 'causeID' : cart[orderCnt]['causeID']}

					if(cart[orderCnt]['deviceID'] == 'BYOD'){
						data.byoshandset = cart[orderCnt]['byodhanset'];
						data.meid = cart[orderCnt]['meid'];
					}

					$('#cause-detail').append('<div class="loader" style="overflow:auto;"></div>');
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
		
	}).fail(function() {
	    // alert("Currently can't load Cause list. Sorry for the inconvience, kindly refresh page");
	    location.reload();
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

 		//clear package table
 		$(document).find('.package-table tr').removeClass('selectedplan');

 		displayPageSection('page-section', 'deviceselection');

 		addbackHistory('another-device');


 	});


 	$('#gotoshoppingcart').on('click', function(){

 		addbackHistory('another-device');

		console.log(backorder);
 		
 		$('#shopping-cart').html('<div class="loader"></div>');

 		$.get("orderSummary", function( data ) {
			$('#shopping-cart').html(data);

			//set the due amount to the total price container in the header section
			$('.total-price .price-value').text($('.total-due-today').text());

			$('#checkout').on('click', function(event){
				addbackHistory('shopping-cart');
				displayPageSection('page-section', 'create-account');

				console.log(backorder);
				
				event.preventDefault();
			});

			$('.edit-device, .edit-plan').on('click', function(){

				addbackHistory('shopping-cart');

 				editCartset = $(this).attr('cid');
 				editCart = true;


				if($(this).hasClass('edit-device')){
					displayPageSection('page-section', 'deviceselection');
				}else{
					// if(cart[editCartset]['planID'] != 'BWW_PAYG'){
						
						var trID = cart[editCartset]['planID'];
						
						$( ".service-plan-item" ).each(function() {
						  $(this).removeClass('selectedplan');
						});

						$('#'+trID).addClass('selectedplan');
					// }

					displayPageSection('page-section', 'planselection');
				}

 				console.log(cart[orderCnt]);
			})


			$(document).scrollTo('#shopping-cart', 800, {offset:-150});
		});

 		displayPageSection('page-section', 'shopping-cart');


 	});


	$('#check-meid').on('click', function(e){
		e.preventDefault();

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

	            		if( editCart && editCartset != null ){
							cart[editCartset]['deviceID'] = 'BYOD';
							cart[editCartset]['byodhanset'] = selectedbyosd;
		            		cart[editCartset]['meid'] = $('#meid').val();


		            		editCartItems(); // submit edit cart items		            		
		            		

		            		console.log(cart[editCartset]);

						}else{

		            		cart[orderCnt]['deviceID'] = 'BYOD';
		            		cart[orderCnt]['byodhanset'] = selectedbyosd;
		            		cart[orderCnt]['meid'] = $('#meid').val();


		            		displayPageSection('page-section', 'byosd-editmeid');

							addbackHistory('byosd-checkmeid');
						}

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
	})



	$('#selectplan').on('click', function(){

		
		if(cart[orderCnt]['byodhanset'] !== undefined){

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
			        	if(resp.search('Found') !== -1){
							displayAcctInfoSection();
						}else{
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

	 	toggleCartButton(containerID);
 	});


 	//Validates the credit card
 	//uses the library http://jquerycreditcardvalidator.com/
 	$(document).on('keyup', '#ccard', function(e) {
		var res = $('#credit-card-form').validate({
		  rules: {
		    ccard: {
		      required: true,
		      creditcard: true
		    }
		  },
		  messages: {
		    ccard: {
		      required: "Please provide your Credit Card number",
		      creditcard: "The card number seems to be incorrect format"
		    }
		  },
		  errorPlacement: function(error, element) {
		    error.appendTo(element.parent('.form-group').find('label'));
		  },
		  showErrors: function(errorMap, errorList) {
		  	if (this.numberOfInvalids() == 0) $('#validateCCard').removeClass('disabled');
		  	else $('#validateCCard').removeClass('disabled').addClass('disabled');

		  	this.defaultShowErrors();
		  },
		  success: function(label) {
		  	console.log(label);
		  }
		});
 	});

 	//Validation for number-only fields
	$(document).on('keypress', '#zipcode, #shipzipcode, #phone, #shipphone', function(e) {

		//if the letter is not digit then display error and don't type anything
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				//display error message
				//$("#errmsg").html("Digits Only").show().fadeOut("slow");
				return false;
			}
	});

	//Pre-load some of the images
	function preload() {
		var images = new Array();
		for (var i = 0; i < preload.arguments.length; i++) {
			images[i] = new Image();
			images[i].src = preload.arguments[i];
		}
	}
	preload(
		'../images/device_bg.jpg', 
		'../images/package_bg.jpg',
		'../images/cause_img1.jpg',
		'../images/cause_1.jpg',
		'../images/cause_2.jpg',
		'../images/cause_3.jpg'
	);


 	function checkSectionHistory(){
 		// for back button display
 	}

 	function addbackHistory(container_id){
 		$('#back-button').show();
 		$('#cart-button').show();

 		backorder.push(container_id);
 	}


 	function editCartItems(){
 		console.log(cart);
 		console.log(editCartset);

 		if( editCart && editCartset != null ){
	 		var data = jQuery.param(cart);
	 	
			$('#shopping-cart').html('<div class="loader"></div>');
			displayPageSection('page-section', 'shopping-cart');

			$.ajax({
				type: "POST",
				url: baseurl + 'updateCartItems',
				data : data,
		        success  : function (resp) {
		        	console.log(resp);
		        	if(resp.search('Success') !== -1){
						$('#gotoshoppingcart').trigger('click');
					}else{
						
					}															
		         
		        }
			});


			editCart = false;
			editCartset = null;
		}
 	}


 	var BYOSDHandset = {

 		initialize: function () {

       		// load byosdhandset event functions
			$('#search-handset').on('click', function(){

				if($("#bhandset_hidden").val() != ''){

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

						// check if edit cart has been selected
						if( editCart && editCartset != null ){
							cart[editCartset]['deviceID'] = $(this).attr('pid');
							// reset byosdhandset if device is selected
							cart[editCartset]['byodhanset'] = '';
		            		cart[editCartset]['meid'] = '';

		            		editCartItems(); // submit edit cart items		            		
		            		

		            		console.log(cart[editCartset]);

						}else{
							cart[orderCnt]['deviceID'] = $(this).attr('pid'); // set selected device per order set

							// reset byosdhandset if device is selected
							cart[orderCnt]['byodhanset'] = '';
		            		cart[orderCnt]['meid'] = '';

							if(cart[orderCnt]['planID'] === undefined ){
								displayPageSection('page-section', 'planselection');
							}else{
								displayPageSection('page-section', 'causeselection');
							}

							

							addbackHistory('device-detail');
						}
						

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

				// check if edit cart has been selected
				if( editCart && editCartset != null ){
					cart[editCartset]['planID'] = 'BWW_PAYG';

            		editCartItems(); // submit edit cart items		            		
            		

            		console.log(cart[editCartset]);

				}else{

					cart[orderCnt]['planID'] = 'BWW_PAYG';

					if(cart[orderCnt]['deviceID'] === undefined ){
						displayPageSection('page-section', 'deviceselection');
					}else{
						displayPageSection('page-section', 'causeselection');
					}

					addbackHistory('just-plan');
				}

				console.log(backorder);
			})


       		// load byosdhandset event functions
			$('.select-package').on('click', function(event){

				if(selectedpackage != ''){

					if( editCart && editCartset != null ){
						cart[editCartset]['planID'] = selectedpackage;
						
	            		editCartItems(); // submit edit cart items		            		
	            		

	            		console.log(cart[editCartset]);

					}else{
						cart[orderCnt]['planID'] = selectedpackage; // set selected device per order set

						if(cart[orderCnt]['deviceID'] === undefined ){
							displayPageSection('page-section', 'deviceselection');
						}else{
							displayPageSection('page-section', 'causeselection');
						}

						addbackHistory('plan-container');
					}

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

	$( "." + classname).each(function() {
  	//$(this).hide();
	});

	$('#' + id).show();

	toggleCartButton(id);

	// scrolls to the newly opened section when user selects an option
	$(document).scrollTo('#' + id, 800, {offset:-150});
}

//hide cart button if currently viewed section is on causes
function toggleCartButton(view) {
	
	var no_cart = ['causeselection', 'cause-detail'];
	var show_total_price = ['shopping-cart', 'create-account', 'checkout-container'];

	if ($.inArray(view, no_cart) >= 0) {
		$('#cart-button').hide();
		$('.total-price').hide();
	}
	else if ($.inArray(view, show_total_price) >= 0) {
		$('#cart-button').hide();
		$('.total-price').show();
	}
	else {
		$('#cart-button').show();
		$('.total-price').hide();
	} 

	/*console.log(view);
	console.log('cart icon: ' + $.inArray(view, no_cart));
	console.log('price icon: ' + $.inArray(view, show_total_price));*/
}

function addbackHistory(container_id){
	$('#back-button').show();
	$('#cart-button').show();

	backorder.push(container_id);
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
        	
        	if(resp.search('Success') !== -1){
				displayAcctInfoSection();
			}else{
				
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



function displayAcctInfoSection(){
	addbackHistory('create-account');
	displayPageSection('page-section', 'checkout-container');

	$.get("checkout", function( data ) {
		$('#checkout-container').html(data);

		//scroll to the account info container
		$(document).scrollTo('#checkout-container', 800, {offset:-150});

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
	            	
	            	if(resp.success){
	            		$('#checkoutloader').html('<h4>Order Complete!</h4>');
	            		$('#estimateTax').text(resp.estimatedTax);
	            		// reset order cart
	            		orderCnt = 0;
	            		cart = {};
						
	            	}else{
	            		$('#checkoutloader').hide();
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
