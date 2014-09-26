<?php

class ShopController extends BaseController
{   
    
    public function index(){
        return View::make('shop.device');
    }

    public function MagentoAPI(){

    	// Magento login information 
		$mage_url = 'http://bww-magento.predev.gflocal/api/soap?wsdl'; 
		$mage_user = 'bwwmagento'; 
		$mage_api_key = '8iKNZoW5Ju'; 
		// Initialize the SOAP client 
		$soap = new SoapClient( $mage_url ); 
		// Login to Magento 
		$session_id = $soap->login( $mage_user, $mage_api_key );

		$response = $soap->getSomethingSpecific ( $arguments );

		var_dump($response);
    }
}

?>