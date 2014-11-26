<?php 
set_time_limit ( 300 );

class ShopController extends BaseController
{   
    
    public function index(){

    	
        return View::make('shop_view.shop');
    }



    public function getBYOSDhansets(){

        $handsets = ByosdHansets::orderBy('manufacturer', 'asc')->orderBy('name', 'asc')->get();

        return View::make('shop_view.handset_list')->with('byosdhansets', $handsets);
    }


    public function getDeviceList(){

        $products = self::getDisplayProductsByCatname();

        return View::make('shop_view.device_list')->with('products', $products);
    }


    public function getPlanOption(){

        $plan_options = self::getDisplayProductsByCatname('Service Plans');

        return View::make('shop_view.plan_list')->with('plan_options', $plan_options);
    }





    public function causes(){
        
        $causes = self::getDisplayProductsByCatname('Cause');

        return View::make('shop_view.cause_list')->with('causes', $causes);
        
        
    }



    public function causeDetail($id){
        
        $session_id = MagentoAPI::initialize();

        $causeprod = MagentoAPI::getProductDetailsByIDs($session_id, array($id));

        return View::make('shop_view.cause_detail')->with('causeprod', $causeprod);
        
    }


    public function orderSummary(){
        
        // $session_id = MagentoAPI::initialize();

        // $products = MagentoAPI::getProductDetailsByIDs($session_id, array($id));

        return View::make('shop_view.shopping_cart');
        
    }


    public function checkout(){
        
        // $session_id = MagentoAPI::initialize();

        // $products = MagentoAPI::getProductDetailsByIDs($session_id, array($id));

        return View::make('shop_view.checkout');
        
    }



    public function shop(){

        $handsets = ByosdHansets::orderBy('manufacturer', 'asc')->orderBy('name', 'asc')->get();

        $products = self::getDisplayProductsByCatname();
             
        return View::make('shop.shop_page')->with('products', $products)->with('byosdhansets', $handsets);
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

        return View::make('shop_view.device_detail')->with('products', $products);
        
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

    public function selectcause($id, $price){
        Session::forget('selectedcause'); // forget previous selected device

        Session::put('selectedcause', [
                'id'       => $id,
                'price'     => $price,
        ]); 

       return Redirect::route('causes');
        
        
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

        if (Session::has('orderset')) {

            $sessionorders =  Session::get('orderset');
            $ordersets = array_merge($ordersets,  $sessionorders);

            Session::forget('orderset'); // forget previous selected device
            
        }
        
        Session::set('orderset',  $ordersets);

        var_dump(Session::get('orderset'));
        
    }

    public function addToCart(){

                  
            $session_id = MagentoAPI::initialize();
            
            $bundleProd = MagentoAPI::getProductBySKU($session_id, 'setorder');
            $prodID = $bundleProd['product_id'];

            $homepage = file_get_contents('http://bww-magento.gfdev.net/index.php/bundleids?prodID='.$prodID);
            $options = json_decode($homepage);

            $products = array();

            foreach( $orderset as $order){

               
                $products []= array(
                    "product_id"    =>  $prodID,
                    "qty"           => "1",
                    "bundle_option" => array(
                                    $options->Device->option_id => $options->Device->prodIDs->$order['deviceID'], 
                                    $options->Service_Plan->option_id => $options->Service_Plan->prodIDs->$order['planID'], 
                                    $options->Causes->option_id => $options->Causes->prodIDs->$order['causeID'], 

                                    )
                    );
            }

            // forget orderset
            Session::forget('orderset');

            $cartID = MagentoAPI::createEmptyCart($session_id);
            

            $response = MagentoAPI::addProductToCart($session_id, $cartID, $products);
    }

}

?>  