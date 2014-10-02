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

    public function selectdevice($id, $price){
        Session::forget('device'); // forget previous selected device

        Session::put('device', [
                'id'       => $id,
                'price'     => $price,
        ]); 

       return Redirect::route('serviceplan');
        
        
    }

    public function serviceplan(){
    	
    	$products = self::getDisplayProducts('Service Plans');
       
    	return View::make('shop.plan')->with('products', $products);
    	
    	
    }



    public function planDetail($id){
        
        $session_id = MagentoAPI::initialize();

        $products = MagentoAPI::getProductDetailsByIDs($session_id, array($id));

        return View::make('shop.plan_detail')->with('products', $products);
        
    }

    public function selectplan($id, $price){
        Session::forget('selectedplan'); // forget previous selected device

        Session::put('selectedplan', [
                'id'       => $id,
                'price'     => $price,
        ]); 

       return Redirect::route('causes');
        
        
    }



    public function causes(){
        
        $causes = self::getDisplayProducts('Cause');

        $totalcost = Session::get('device.price') + Session::get('selectedplan.price');
       
        return View::make('shop.cause')->with('products', $causes)->with('totalcost', $totalcost);
        
        
    }


    public function selectcause($id, $price){
        Session::forget('selectedcause'); // forget previous selected device

        Session::put('selectedcause', [
                'id'       => $id,
                'price'     => $price,
        ]); 

       return Redirect::route('causes');
        
        
    }


}

?>  