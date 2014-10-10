<?php 
set_time_limit ( 300 );

class ShopController extends BaseController
{   
    
    public function index(){

    	$products = self::getDisplayProductsByCatname();

    	
        return View::make('shop.device')->with('products', $products);
    }

    public function shop(){

        $products = self::getDisplayProductsByCatname();
             
        return View::make('shop.shop_page')->with('products', $products);
    }


    public function getDisplayProductsByCatname($catname = 'Devices'){

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
    	
    	$products = self::getDisplayProductsByCatname('Service Plans');
       
    	return View::make('shop.service_plan')->with('products', $products);

        
    	
    	
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
        
        $causes = self::getDisplayProductsByCatname('Cause');

        // $totalcost = Session::get('device.price') + Session::get('selectedplan.price');
       
        // return View::make('shop.cause')->with('products', $causes)->with('totalcost', $totalcost);
        return View::make('shop.causes')->with('products', $causes);
        
        
    }


    public function selectcause($id, $price){
        Session::forget('selectedcause'); // forget previous selected device

        Session::put('selectedcause', [
                'id'       => $id,
                'price'     => $price,
        ]); 

       return Redirect::route('causes');
        
        
    }


    public function testurl(){
         $ordersets[0] = array(
            'deviceID' => 1,
            'planID' => 1,
            'causeID' => 1
        );

        Session::set('ordesets',  $ordersets);
         var_dump(Session::get('ordesets'));
    }



    public function getDisplayProducts(){

        $session_id = MagentoAPI::initialize();

        $result = MagentoAPI::getAllCategories($session_id);
        $categories = array();
        $productIDs = array();
        $productDetails = array();

        if(count($result) > 0) {
            foreach($result as $cat){
                if($cat['name'] != 'Default Category')
                    $categories[$cat['category_id']] = $cat['name'];
            }

          

            foreach ($categories as $catID => $catname){

                $productIDs[$catname] = MagentoAPI::getProductIDsByCategory($session_id, $catID);
                $productDetails[$catname] = MagentoAPI::getProductDetailsByIDs($session_id, $productIDs[$catname]);
            }
        }


        return $productDetails;
    }


    public function setOrderSet(){
        
        $ordersets[Input::get('orderset')] = array(
            'deviceID' => Input::get('device'),
            'planID' => Input::get('plan'),
            'causeID' => Input::get('cause')
        );

        if (Session::has('ordesets')) {

            $sessionorders =  Session::get('ordesets');
            $ordersets = array_merge($ordersets,  $sessionorders);

            Session::forget('ordesets'); // forget previous selected device
            
        }
        
        Session::set('ordesets',  $ordersets);

        var_dump(Session::get('ordesets'));
        
    }
}

?>  