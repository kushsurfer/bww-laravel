$(document).ready(function(){
 	var loaderdiv = '<div class="loader"></div>';
 	var orderset = {};
 	var ordercnt = 0;

 	orderset[ordercnt] = {};


 	//load plans in the background
 	$.get( "serviceplan", function( data ) {
		$('#planpanel').siblings('.panel-body').html(data);
		
		$('.planselect').on('click', function(){
			$('#plan').val($(this).attr('did'));
			$('#plandCode').val($(this).attr('sku'));

			$('#causepanel').trigger('click');
			

			orderset[ordercnt]['planID'] = $(this).attr('did');
		})

		
	});

 	$.get( "causes", function( data ) {
		$('#causepanel').siblings('.panel-body').html(data);
		$('#cause').val($(this).attr('did'));

		$('.causeselect').on('click', function(){
			$('#cause').val($(this).attr('did'));
			
			orderset[ordercnt]['causeID'] = $(this).attr('did');

			var data = $('#orderform').serialize();

			$.ajax({
				type: "POST",
				url: $('#orderform').attr('action'),
				data: data,
	            success  : function (resp) {
	                // console.log(resp);
	            }
			});


			// if(confirm('Do you want to setup another device?')){

			// 	$('#plan').val('');
			// 	$('#cause').val('');
			// 	$('#device').val('');

			// 	$('#devicespanel').trigger('click');

			// 	ordercnt++;
			// 	orderset[ordercnt] = {};
				
			// 	$('#device').val(orderset);

			// }else{
				$('#createAccount').trigger('click');
			// }



			// console.log(orderset);
		});
		
	});

	// shop panel accordion functions
	$('.shoppanels .panel-heading').on('click', function(){
		
		var openpanel = false;
	

		switch($(this).attr('id')) {
		    case 'planpanel':

		        if($('#device').val() != ''){
		        	openpanel =  true;
		        }else{
		        	alert('Kindly select a device first.');
		        }

		        break;
		    case 'causepanel':
		    
		        if($('#device').val() != '' && $('#plan').val() != ''){
		        	openpanel =  true;
		        }else{
		        	alert('Kindly select a device and service plan first.');
		        }

		        break;
		    case 'createAccount':
		    
		        if($('#cause').val() != ''){
		        	openpanel =  true;
		        }else{
		        	alert('Kindly select a cause to sponsor first');
		        }

		        break;
		    case 'checkout':
		    
		        if($('#account').val() != ''){
		        	openpanel =  true;
		        }else{
		        	alert('Kindly create account first');
		        }

		        break;
		    default:
		    	openpanel =  true;
		        break;
		}
	
		if(openpanel){
			$('.panel-body').each(function( index ) {
			  $(this).addClass('hide');
			  
			});

			$('.arrows').each(function( index ) {
				$(this).html('&#9658');
			 
			});

			$('.arrows', this).html('&#9660');
			$(this).siblings('.panel-body').removeClass('hide');
			// $('.panel-body', this).removeClass('hide');


		}
		

	});


	$('.devicebutton').on('click', function(){

		$('#device').val($(this).attr('did'));
		// TODO : assign handset SKU to form address
		$('#planpanel').trigger('click');

		orderset[ordercnt]['deviceID'] = $(this).attr('did');
			
	
	});

	$('#submitAddress').on('click', function(){

		var data = $('#addressForm').serialize();

		$.ajax({
			type: "POST",
			url: $('#addressForm').attr('action'),
			data: data,
            success  : function (resp) {
                alert(resp);
                $('#checkout').trigger('click');
            }
		});

			
	
	});


	$('#checkout').on('click', function(){

		// console.log(orderset);
		$.ajax({
			type: "GET",
			url: $('#addToCartUrl').val(),
            success  : function (resp) {
               
            	$('#checkout').siblings('.panel-body').html(resp);               
            }
		});
	});



});