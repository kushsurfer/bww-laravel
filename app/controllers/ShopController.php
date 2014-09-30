<?php 
set_time_limit ( 300 );

class ShopController extends BaseController
{   
    
    public function index(){

    	$products = self::getDisplayProducts();

    	
        return View::make('shop.device')->with('products', $products);
    }

    public function getDisplayProducts(){

    	$session_id = MagentoAPI::initialize();

		$catID = MagentoAPI::getCategoryID($session_id, 'Devices');

		$productIDs = MagentoAPI::getProductIDsByCategory($session_id, $catID);

		$resources = MagentoAPI::getProductDetailsByIDs($session_id, $productIDs);

		
		return $resources;
    }


    public function deviceDetail($id){
    	
    	$session_id = MagentoAPI::initialize();

    	$products = MagentoAPI::getProductDetailsByIDs($session_id, array($id));

    	return View::make('shop.device_detail')->with('products', $products);
    	
    }

    public function selectplan(){
    	
    	// $session_id = MagentoAPI::initialize();

    	// $products = MagentoAPI::getProductDetailsByIDs($session_id, array($id));

        // return View::make('shop.device_detail')->with('products', $products);
        $products = '';
    	return View::make('shop.plan')->with('products', $products);
    	
    	
    }

    public function MagentoAPI(){
    	var_dump(self::getDisplayProducts());
    }
}

?>  