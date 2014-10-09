$(document).ready(function(){
 	var loaderdiv = '<div class="loader"></div>';


 	//load plans in the background
 	$.get( "serviceplan", function( data ) {
		$('#planpanel').siblings('.panel-body').html(data);
		
		$('.planselect').on('click', function(){
			$('#plan').val($(this).attr('did'));
			$('#causepanel').trigger('click');
		})


	});

 	$.get( "causes", function( data ) {
		$('#causepanel').siblings('.panel-body').html(data);
		$('#cause').val($(this).attr('did'));
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
		

	})


	$('.devicebutton').on('click', function(){

		$('#device').val($(this).attr('did'));
		$('#planpanel').trigger('click');
		// $('#planpanel').siblings('.panel-body').html(loaderdiv);

		
	
	})



});