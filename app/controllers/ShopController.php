<?php 
set_time_limit ( 300 );

use \AdamWathan\EloquentOAuth\ApplicationRejectedException;
use \AdamWathan\EloquentOAuth\InvalidAuthorizationCodeException;

class ShopController extends BaseController
{   
    
    public function index(){

    	
        return View::make('shop_view.shop');
    }


    public function shop1(){

        
        return View::make('shop_view.shop1');
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

            $deviceID = Input::get('deviceID');
            $planID = Input::get('planID');
            $causeID = Input::get('causeID');
            $byodhanset = '';
            $meid = '';

            if (Input::has('byoshandset')){
                $byodhanset = Input::has('byoshandset');
            }

            if (Input::has('meid')){
                $meid = Input::has('meid');
            }

     
            // get product ID for BYOD product
            if($deviceID == 'BYOD'){
                $deviceID = MagentoAPI::getProductBySKU($session_id, $deviceID);
                $deviceID = $deviceID['product_id'];
            }

            // get product ID for Just Plan
            if($planID == 'BWW_PAYG'){
                $planID = MagentoAPI::getProductBySKU($session_id, $planID);
                $planID = $planID['product_id'];
            }

          
            $products = array();
                         
            $products[]= array(
                "product_id"    =>  $prodID,
                "qty"           => "1",
                "bundle_option" => array(
                                $options->Device->option_id => $options->Device->prodIDs->$deviceID, 
                                $options->Service_Plan->option_id => $options->Service_Plan->prodIDs->$planID, 
                                $options->Causes->option_id => $options->Causes->prodIDs->$causeID, 

                                )
            );
          
            if (Session::has('cartID'))
            {
               $cartID = Session::get('cartID');
            }else{
                
                $cartID = MagentoAPI::createEmptyCart($session_id);
                Session::put('cartID', $cartID);
            }
                        
            $response = MagentoAPI::addProductToCart($session_id, $cartID, $products);



            // Store order items in a session
            $ordersets = array();

            $ordersets[] = array(
                'deviceID' => $deviceID,
                'planID' => $planID,
                'causeID' => $causeID,
                'byodhanset' => $byodhanset,
                'meid' => $meid
            );

            self::setSessionOrderSets($ordersets);

            
    }

    public function setSessionOrderSets($ordersets){

        if (Session::has('ordersets')) {

            $sessionorders =  Session::get('ordersets');
            $ordersets = array_merge($ordersets,  $sessionorders);

            Session::forget('ordersets'); // forget previous selected device
                
        }        

        Session::set('ordersets',  $ordersets);

        var_dump(Session::get('ordersets'));
         
    }


    public function orderSummary(){
        $cartdetails = self::getOrderDetails();

        return View::make('shop_view.shopping_cart')->with('cartdetails', $cartdetails);
        
    }


    public function getOrderDetails(){
         $cartdetails = array();
        
        if (Session::has('ordersets')) {
            $session_id = MagentoAPI::initialize();
            $ordersets = Session::get('ordersets');
           

            foreach($ordersets as $cartProduct){
                $deviceDetails = MagentoAPI::getProductDetailsByIDs($session_id, array($cartProduct['deviceID']));
                $planDetails = MagentoAPI::getProductDetailsByIDs($session_id, array($cartProduct['planID']));
               
                $deviceDetails = $deviceDetails[$cartProduct['deviceID']];
                $planDetails = $planDetails[$cartProduct['planID']];


                $cartdetails[] = array(
                    'deviceDetails' => array('name' => $deviceDetails['name'], 'price' => $deviceDetails['price']),
                    'planDetails'  => array('name' => $planDetails['name'], 'price' => $planDetails['per_month']),
                    'deviceImage' => $deviceDetails['images'][0], 
                    'activationFee' => $planDetails['price'] 
                );
            }

        }

        return $cartdetails;

    }


    public function getCurrentCartInfo(){

                  
        $session_id = MagentoAPI::initialize();

        $cartID = Session::get('cartID', 93); 

        $response = MagentoAPI::getCartTotal($session_id, $cartID);

        var_dump($response);
       
        echo $cartID;exit;

        $arrAddresses = array(
                    array(
                        "mode" => "shipping",
                        "firstname" => 'Retchel',
                        "lastname" => 'Tapayan',
                        "company" => 'Retchel BWW',
                        "street" => '10th Avenue',
                        "city" => 'San Francisco',
                        "region" => 'CA',
                        "postcode" => '94118',
                        "country_id" => 'US',
                        "telephone" => '0123456789',
                        "fax" => '0123456789',
                        "is_default_shipping" => 0,
                        "is_default_billing" => 0
                    ),
                    array(
                        "mode" => "billing",
                        "firstname" => 'Retchel',
                        "lastname" => 'Tapayan',
                        "company" => 'Retchel BWW',
                        "street" => '10th Avenue',
                        "city" => 'San Francisco',
                        "region" => 'CA',
                        "postcode" => '94118',
                        "country_id" => 'US',
                        "telephone" => '0123456789',
                        // "fax" => "0123456789",
                        "is_default_shipping" => 0,
                        "is_default_billing" => 0
                    )
                );

            // $arrAddresses = null;

            $customerAsGuest = array(
                            "firstname" => 'Retchel',
                            "lastname" => 'Tapayan',
                            "email" => 'rtapayan@global-fusion.net',
                            "website_id" => "0",
                            "store_id" => "0",
                            "mode" => "guest"
                        );

            $response = MagentoAPI::addCustomerToCart($session_id, $cartID, $customerAsGuest);
            var_dump($response);
            echo '<br/><br/><br/>';


            $response = MagentoAPI::addCustomerInfoToCart($session_id, $cartID, $arrAddresses);
      
           

            // $response = MagentoAPI::getPaymentList($session_id, $cartID);
            var_dump($response);
            echo '<br/><br/><br/>';


            // $response = MagentoAPI::getShippingMethod($session_id, $cartID);
            // var_dump($response);
            // echo '<br/><br/><br/>';

            $response = MagentoAPI::setShippingMethod($session_id, $cartID);
            var_dump($response);
            echo '<br/><br/><br/>';
            

           $paymentMethod = array(
                            "po_number" => null,
                            "method" => 'authorizenet_directpost',
                            "cc_type" => 'DI',
                            "cc_number" =>'6011000000000012',
                            "cc_exp_month" => 12,
                            "cc_exp_year" => 2014,
                            "cc_cid" => 123     
                        );

            $response = MagentoAPI::addCartPaymentMethod($session_id, $cartID, $paymentMethod);
            var_dump($response);
            echo '<br/><br/><br/>';

            

            $orderID = MagentoAPI::createOrderFromCart($session_id, $cartID);
            // var_dump($orderID);
            // exit;
            $response = MagentoAPI::getOrderInfo($session_id, $orderID);

            var_dump($response);
            echo '<br/><br/><br/>';

         
    }


    public function createAccount(){

        $rules = array(
            'email_address'    => 'required|email|unique:customers',    // required and must be unique in the ducks table
            'password'         => 'required',
            'password_confirm' => 'required|same:password'          // required and has to match the password field
        );

        // validate against the inputs from our form
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {

           return Response::json(['success'=>false, 'errors' => $validator->messages()]);

        } else {
            $customer = new Customers;
            // form values
            $customer->email_address = Input::get('email_address');
            $customer->password = Hash::make(Input::get('password'));
            $customer->subscription_date = date('Y-m-d H:i:s');
            $customer->customerStatus = 'Pending';
            $customer->save();

            Session::put('customerID', $customer->customerID);

            return Response::json(['success'=>true]);
        }
    }

    public function facebooklogin(){
      try {
            OAuth::login('facebook', function($user, $details) {

                $customerID = '';

                $existcustomer =  Customers::where('oauthID', '=', $details->userId)->first();

                //  $url = 'https://graph.facebook.com/me?'.http_build_query(array(
                //     'access_token' => $details->accessToken,
                // ));

                // var_dump(json_decode(file_get_contents($url)));

                if($existcustomer == null){
                    // form values
                    $customer = new Customers;

                    $customer->oauthID = $details->userId;
                    $customer->customer_source = 'FB';
                    $customer->firstname = $details->firstName;
                    $customer->lastname = $details->lastName;
                    $customer->email_address = $details->email;
                    $customer->customerStatus = 'Pending';
                    $customer->save();

                     $customerID =  $customer->id;
                }else{
                    $customerID = $existcustomer->customerID;

                    $customer = Customers::find($customerID);

                    $customer->oauthID = $details->userId;
                    $customer->customer_source = 'FB';
                    $customer->firstname = $details->firstName;
                    $customer->lastname = $details->lastName;
                    $customer->email_address = $details->email;
                    $customer->customerStatus = 'Pending';
                    $customer->save();
                }
               

                Session::put('customerID', $customerID );


            });
        } catch (ApplicationRejectedException $e) {
            // User rejected application
        } catch (InvalidAuthorizationCodeException $e) {
            // Authorization was attempted with invalid
            // code,likely forgery attempt
        }

        echo "<script>
            window.close();
            alert('Logged In');
            open(location, '_self').close();
            </script>";
       
    }

    public function createCustomerAmazon(){
        if(Input::has('oauthID')){
           
       
            $existcustomer =  Customers::where('oauthID', '=', Input::get('oauthID'))->first();
             $name = explode(' ', Input::get('name')); 

            if($existcustomer == null){
             
                $customer = new Customers;
               
                $customer->firstname = isset($name[0]) ? $name[0] : '';
                $customer->lastname = isset($name[1]) ? $name[1] : '';
                $customer->email_address = Input::get('email_address');
                $customer->oauthID = Input::get('oauthID');
                $customer->customer_source = 'Amazon';
                $customer->customerStatus = 'Pending';
                $customer->save();

                Session::put('customerID', $customer->id);
            }else{
                $customer = Customers::find($customerID);

                $customer->firstname = isset($name[0]) ? $name[0] : '';
                $customer->lastname = isset($name[1]) ? $name[1] : '';
                $customer->email_address = Input::get('email_address');
                $customer->oauthID = Input::get('oauthID');
                $customer->customer_source = 'Amazon';
                $customer->customerStatus = 'Pending';
                $customer->save();
            }
            
            Session::put('customerID', $customerID );

            return Response::json(['success'=>true]);

        }else{
            return Response::json(['success'=>false]);
        }
        
    }


    public function updateCustomerInfo($data){

    }

    
    public function checkCustomerSession(){

        if (Session::has('customerID')) {
            return Response::json(['success'=>true]);
        }else{
            echo 'Failed';
        }

    }



    public function privacypage(){
        echo 'privacy page';
    }


    public function checkout(){
        
        $customerID = Session::get('customerID');

        $customer = Customers::find($customerID);

        $regionList = Region::orderBy('default_name')->get();

        $months = array(
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
            );
       
        $cartdetails = self::getOrderDetails();
        
        return View::make('shop_view.checkout')->with('cartdetails', $cartdetails)->with('customer', $customer)->with('regionList', $regionList)->with('months', $months);
        
    }

    public function updateAccountInformation(){

         $rules = array(
            'fname'             => 'required',
            'lname'             => 'required',
            'billingAddress'    => 'required',
            'city'              => 'required',
            'state'             => 'required',
            'zipcode'           => 'required|numeric',
            'phone'             => 'required',
            'emailAddress'      => 'required|email',    // |unique:customers
            'verifyEmail'       => 'required|same:emailAddress',  // required and has to match the email field
            'shipfname'         => 'required',          
            'shiplname'         => 'required',          
            'shipbillingAddress'=> 'required',          
            'shipcity'          => 'required',          
            'shipstate'         => 'required',          
            'shipzipcode'       => 'required|numeric',          
            'shipphone'         => 'required'       
        );

        // validate against the inputs from our form
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {

           return Response::json(['success'=>false, 'errors' => $validator->messages()]);

        } else {

            $customerID = Session::get('customerID', 3);

            $customer = Customers::find($customerID);

            $customer->firstname = Input::get('fname');
            $customer->middleInitial = Input::get('minitial');
            $customer->lastname = Input::get('lname');
            $customer->street_address = Input::get('billingAddress').' '.Input::get('billingAddress2');
            $customer->city = Input::get('city');
            $customer->zipcode = Input::get('zipcode');
            $customer->state = Input::get('state');
            $customer->phone = Input::get('phone');
            $customer->email_address = Input::get('emailAddress');


            $customer->shipping_fname = Input::get('shipfname');
            $customer->shipping_lname = Input::get('shiplname');
            $customer->shipping_address = Input::get('shipbillingAddress');
            $customer->shipping_city = Input::get('shipcity');
            $customer->shipping_state = Input::get('shipstate');
            $customer->shipping_zip = Input::get('shipzipcode');
            $customer->shipping_phone = Input::get('shipphone');
            
            $customer->newsletter = Input::get('newsletter');
            $customer->customerStatus = 'Pending';
            $customer->save();

            $response = true;
            $response = self::addCustomerDataToCart($customer);


            return Response::json(['success'=>$response]);
        }
    }

    public function addCustomerDataToCart($customerDetails){
       $cartID = Session::get('cartID');
       // $resp = true;
       $session_id = MagentoAPI::initialize();


       $arrAddresses = array(
                array(
                    "mode" => "billing",
                    "firstname" => $customerDetails->firstname,
                    "lastname" => $customerDetails->lastname,
                    "company" => '',
                    "street" => $customerDetails->street_address,
                    "city" => $customerDetails->city,
                    "region" => $customerDetails->state,
                    "postcode" => $customerDetails->zipcode,
                    "country_id" => $customerDetails->country,
                    "telephone" => $customerDetails->phone,
                    "fax" => '',
                    "is_default_shipping" => 0,
                    "is_default_billing" => 0
                ),
                array(
                    "mode" => "shipping",
                    "firstname" => $customerDetails->shipping_fname,
                    "lastname" => $customerDetails->shipping_lname,
                    "company" => '',
                    "street" => $customerDetails->shipping_address,
                    "city" => $customerDetails->shipping_city,
                    "region" => $customerDetails->shipping_state,
                    "postcode" => $customerDetails->shipping_zip,
                    "country_id" => $customerDetails->shipping_country,
                    "telephone" => $customerDetails->shipping_phone,
                    "is_default_shipping" => 0,
                    "is_default_billing" => 0
                )
            );

        // $arrAddresses = null;

        $customerAsGuest = array(
                        "firstname" => $customerDetails->firstname,
                        "lastname" => $customerDetails->lastname,
                        "email" => $customerDetails->email_address,
                        "website_id" => "0",
                        "store_id" => "0",
                        "mode" => "guest"
                    );

        $response = MagentoAPI::addCustomerToCart($session_id, $cartID, $customerAsGuest);

        // echo '<br/><br/><br/>';

        $response = MagentoAPI::addCustomerInfoToCart($session_id, $cartID, $arrAddresses);
        
        // echo '<br/><br/><br/>';

        $response = MagentoAPI::setShippingMethod($session_id, $cartID);
       
            // echo '<br/><br/><br/>';


        return $response;
    }


    public function validateCCardInfo(){
         $rules = array(
            'ccard'             => 'required|numeric',
            'ccname'            => 'required',
            'mon'               => 'required',
            'yr'                => 'required',
            'cvv'               => 'required|numeric',
        );

        // validate against the inputs from our form
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {

           return Response::json(['success'=>false, 'errors' => $validator->messages()]);

        } else {
            $response = true;

            $paymentMethod = array(
                        "po_number" => null,
                        "method" => 'authorizenet_directpost',
                        "cc_type" => 'DI',
                        "cc_number" => Input::get('ccard'),
                        "cc_exp_month" => Input::get('mon'),
                        "cc_exp_year" => 2015,
                        "cc_cid" => Input::get('cvv')     
                    );

            $response = self::addCCardInfoToCart($paymentMethod);

            return Response::json(['success'=>$response]);

        }



    }

    public function addCCardInfoToCart($paymentMethod){
        
        $cartID = Session::get('cartID');
        $session_id = MagentoAPI::initialize();

        $response = MagentoAPI::addCartPaymentMethod($session_id, $cartID, $paymentMethod);
                
        $orderID = MagentoAPI::createOrderFromCart($session_id, $cartID);


        if($orderID != 0){

            $response = MagentoAPI::getOrderInfo($session_id, $orderID);
            $transactionID =  $response['payment']['last_trans_id'];
          
            if($response['status'] == 'pending_payment'){
                $invoiceID = MagentoAPI::createInvoice($session_id, $orderID);

                $paid = MagentoAPI::captureInvoice($session_id, $invoiceID);
               

                $response = MagentoAPI::getOrderInfo($session_id, $orderID);

                $transactionID =  $response['payment']['last_trans_id'];

                $shippingFee = $response['shipping_amount'];


            }
        }

         if($paid){
            $response = true;
         }

        return $response;



    }
}

?>  