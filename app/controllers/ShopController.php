<?php 
set_time_limit ( 300 );

class ShopController extends BaseController
{   
    
    public function index(){

    	$products = self::getDisplayProducts();

    	
        return View::make('shop.device')->with('products', $products);
    }

    public function getDisplayProducts($catname = 'Devices'){

    	$session_id = MagentoAPI::initialize();

		$catID = MagentoAPI::getCategoryID($session_id, $catname);

		$productIDs = MagentoAPI::getProductIDsByCategory($session_id, $catID);

		$resources = MagentoAPI::getProductDetailsByIDs($session_id, $productIDs);

		return $resources;
    }


    public function deviceDetail($id){
        
        $session_id = MagentoAPI::initialize();

        $products = MagentoAPI::getProductDetailsByIDs($session_id, array($id));

        return View::make('shop.device_detail')->with('products', $products);
        
    }

    public function planDetail($id){
    	
    	$session_id = MagentoAPI::initialize();

    	$products = MagentoAPI::getProductDetailsByIDs($session_id, array($id));

    	return View::make('shop.plan_detail')->with('products', $products);
    	
    }

    public function selectdevice($id, $price){
        Session::forget('device'); // forget previous selected device

        Session::put('device', [
                'id'       => $id,
                'price'     => $price,
        ]); 

       return Redirect::route('selectplan');
        
        
    }

    public function selectplan(){
    	
    	$products = self::getDisplayProducts('Service Plans');
       
    	return View::make('shop.plan')->with('products', $products);
    	
    	
    }

    public function selectedplan($id, $price){
        Session::forget('selectedplan'); // forget previous selected device

        Session::put('selectedplan', [
                'id'       => $id,
                'price'     => $price,
        ]); 

       return Redirect::route('selectplan');
        
        
    }



    public function selectcause(){
        
        $causes = self::getDisplayProducts('Cause');
       
        return View::make('shop.cause')->with('causes', $causes);
        
        
    }

}

?>  