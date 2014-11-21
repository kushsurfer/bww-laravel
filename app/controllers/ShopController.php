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

        $plan_options = array(
            'BWW_PACKAGE_MINI' => array(
                                'name' => 'Mini',
                                'per month' => '$22',
                                'minutes' => '250',
                                'messages' => '500',
                                'data' => '350 MB'), 
            'BWW_PACKAGE_SMALL' => array(
                                'name' => 'Small',
                                'per month' => '$33',
                                'minutes' => '500',
                                'messages' => '750',
                                'data' => '500 MB'),  
            'BWW_PACKAGE_MEDIUM' => array(
                                'name' => 'Medium',
                                'per month' => '$55',
                                'minutes' => '1200',
                                'messages' => 'unlimited',
                                'data' => '750 MB'), 
            'BWW_PACKAGE_LARGE' => array(
                                'name' => 'Large',
                                'per month' => '$77',
                                'minutes' => '1500',
                                'messages' => 'unlimited',
                                'data' => '1.2 GB'), 
            'BWW_PACKAGE_JUMBO' => array(
                                'name' => 'Jumbo',
                                'per month' => '$99',
                                'minutes' => 'unlimited',
                                'messages' => 'unlimited',
                                'data' => '2 GB'), 
            );

        return View::make('shop_view.plan_list')->with('plan_options', $plan_options);
    }




    public function causeDetail($id){
        
        // $session_id = MagentoAPI::initialize();

        // $products = MagentoAPI::getProductDetailsByIDs($session_id, array($id));

        return View::make('shop_view.cause_detail');
        
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

    /*public function testingCDRator(){
        function processRequest($url, $params) { if(!is_array($params)) return false; $post_params = ""; foreach($params as $key => $val) { $post_params .= $post_params?"&":""; $post_params .= $key."=".$val; } $ch = curl_init(); curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); curl_setopt($ch, CURLOPT_URL, $url); curl_setopt($ch, CURLOPT_POST, 1); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); curl_setopt($ch, CURLOPT_VERBOSE, 0); curl_setopt($ch, CURLOPT_TIMEOUT, 0); curl_setopt($ch, CURLOPT_HEADER, true); // 'true', for developer testing purpose curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); curl_setopt($ch, CURLOPT_POSTFIELDS, $post_params); $data = curl_exec($ch); if(curl_errno($ch)) print curl_error($ch); else curl_close($ch); return $data; } $url = 'http://Kunaki.com/XMLService.ASP'; $request = '<?xml version="1.0" encoding="utf-8"?><ShippingOptions><Country>United States</Country><State_Province>NY</State_Province><PostalCode>10004</PostalCode><Product><ProductId>XZZ1111111</ProductId><Quantity>2</Quantity></Product><Product><ProductId>PXZZ111112</ProductId><Quantity>3</Quantity></Product></ShippingOptions>'; $params = array('ShippingOptions' => $request);// key value pairs $response = processRequest($url, $params); print_r($response); - See more at: http://www.blogs.zeenor.com/it/php/how-to-send-xml-request-to-web-service-through-php.html#sthash.0mVYqnnv.dpuf
    }*/
}

?>  