<?php 
set_time_limit ( 300 );

use \AdamWathan\EloquentOAuth\ApplicationRejectedException;
use \AdamWathan\EloquentOAuth\InvalidAuthorizationCodeException;


use NomadicBits\CDRatorSoapClient\Type\requestDTO;
use NomadicBits\CDRatorSoapClient\Type\valueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\executeMethod;
use NomadicBits\CDRatorSoapClient\executeMethodResponse;
use NomadicBits\CDRatorSoapClient\Action\GetProductConfigs;
use NomadicBits\DemoBundle\Manager\DeviceManager;
use NomadicBits\DemoBundle\Model\UserManager;
use NomadicBits\CDRatorSoapClient\Action\GetOptionsForRatePlan;

use NomadicBits\DemoBundle\Model\SignupCustomerModel;
use NomadicBits\CDRatorSoapClient\Action\SignupCustomer;
use NomadicBits\CDRatorSoapClient\Object\User;
use NomadicBits\CDRatorSoapClient\Object\UpdateUser;
use NomadicBits\CDRatorSoapClient\Action\UpdateUser as UpdateUserRequest;
use NomadicBits\CDRatorSoapClient\Action\ActivateSubscription;

use NomadicBits\DemoBundle\Model\AuthorizeNet;
use NomadicBits\CDRatorSoapClient\Action\SavePayment;
use NomadicBits\CDRatorSoapClient\Action\AddCharge;
use NomadicBits\CDRatorSoapClient\Action\ManageDevice;
use NomadicBits\CDRatorSoapClient\Action\GetWebUserProfileInternal;

class ShopController extends BaseController
{   
    
    public function index(){

    	Session::forget('ordersets');
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


            $itemdetails = array(
                'deviceID' => $deviceID,
                'planID' => $planID,
                'causeID' => $causeID,
                'byodhanset' => $byodhanset,
                'meid' => $meid
            );

            $resp = self::setProductsToCart($itemdetails);

           
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

            var_dump(Session::get('ordersets'));

            
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



    public function setProductsToCart($itemdetails){

        $session_id = MagentoAPI::initialize();
        
        $bundleProd = MagentoAPI::getProductBySKU($session_id, 'setorder');
        $prodID = $bundleProd['product_id'];

        $homepage = file_get_contents('http://bww-magento.gfdev.net/index.php/bundleids?prodID='.$prodID);
        $options = json_decode($homepage);

        $deviceID = $itemdetails['deviceID'];
        $planID = $itemdetails['planID'];
        $causeID = $itemdetails['causeID'];
        $byodhanset = $itemdetails['byodhanset'];
        $meid = $itemdetails['meid'];

         
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

    }


    public function updateCartItems(){


        $ordersets = Session::get('ordersets');

        $itemSet =  Input::get('setID');
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

        $ordersets[$itemSet] = array(
            'deviceID' => $deviceID,
            'planID' => $planID,
            'causeID' => $causeID,
            'byodhanset' => $byodhanset,
            'meid' => $meid
        );

        // reset orderset sessions

        Session::forget('ordersets');

        Session::set('ordersets',  $ordersets); 


        // recreate cart and add product to new cart 
        Session::forget('cartID'); // forget old cart

        // loop to add products
        foreach($ordersets as $set){
            $itemdetails = array(
                'deviceID' => $set['deviceID'],
                'planID' => $set['planID'],
                'causeID' => $set['causeID'],
                'byodhanset' => $set['byodhanset'],
                'meid' => $set['meid']
            );

            self::setProductsToCart($itemdetails);

        }

        echo 'Success';


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


    // public function getCurrentCartInfo(){

                  
    //     $session_id = MagentoAPI::initialize();

    //     $cartID = Session::get('cartID', 93); 

    //     $response = MagentoAPI::getCartTotal($session_id, $cartID);

    //     var_dump($response);
       
    //     echo $cartID;exit;

    //     $arrAddresses = array(
    //                 array(
    //                     "mode" => "shipping",
    //                     "firstname" => 'Retchel',
    //                     "lastname" => 'Tapayan',
    //                     "company" => 'Retchel BWW',
    //                     "street" => '10th Avenue',
    //                     "city" => 'San Francisco',
    //                     "region" => 'CA',
    //                     "postcode" => '94118',
    //                     "country_id" => 'US',
    //                     "telephone" => '0123456789',
    //                     "fax" => '0123456789',
    //                     "is_default_shipping" => 0,
    //                     "is_default_billing" => 0
    //                 ),
    //                 array(
    //                     "mode" => "billing",
    //                     "firstname" => 'Retchel',
    //                     "lastname" => 'Tapayan',
    //                     "company" => 'Retchel BWW',
    //                     "street" => '10th Avenue',
    //                     "city" => 'San Francisco',
    //                     "region" => 'CA',
    //                     "postcode" => '94118',
    //                     "country_id" => 'US',
    //                     "telephone" => '0123456789',
    //                     // "fax" => "0123456789",
    //                     "is_default_shipping" => 0,
    //                     "is_default_billing" => 0
    //                 )
    //             );

    //         // $arrAddresses = null;

    //         $customerAsGuest = array(
    //                         "firstname" => 'Retchel',
    //                         "lastname" => 'Tapayan',
    //                         "email" => 'rtapayan@global-fusion.net',
    //                         "website_id" => "0",
    //                         "store_id" => "0",
    //                         "mode" => "guest"
    //                     );

    //         $response = MagentoAPI::addCustomerToCart($session_id, $cartID, $customerAsGuest);
    //         var_dump($response);
    //         echo '<br/><br/><br/>';


    //         $response = MagentoAPI::addCustomerInfoToCart($session_id, $cartID, $arrAddresses);
      
           

    //         // $response = MagentoAPI::getPaymentList($session_id, $cartID);
    //         var_dump($response);
    //         echo '<br/><br/><br/>';


    //         // $response = MagentoAPI::getShippingMethod($session_id, $cartID);
    //         // var_dump($response);
    //         // echo '<br/><br/><br/>';

    //         $response = MagentoAPI::setShippingMethod($session_id, $cartID);
    //         var_dump($response);
    //         echo '<br/><br/><br/>';
            

    //        $paymentMethod = array(
    //                         "po_number" => null,
    //                         "method" => 'authorizenet_directpost',
    //                         "cc_type" => 'DI',
    //                         "cc_number" =>'6011000000000012',
    //                         "cc_exp_month" => 12,
    //                         "cc_exp_year" => 2014,
    //                         "cc_cid" => 123     
    //                     );

    //         $response = MagentoAPI::addCartPaymentMethod($session_id, $cartID, $paymentMethod);
    //         var_dump($response);
    //         echo '<br/><br/><br/>';

            

    //         $orderID = MagentoAPI::createOrderFromCart($session_id, $cartID);
    //         // var_dump($orderID);
    //         // exit;
    //         $response = MagentoAPI::getOrderInfo($session_id, $orderID);

    //         var_dump($response);
    //         echo '<br/><br/><br/>';

         
    // }


    public function createAccount(){

        $rules = array(
            'email_address'    => 'required|email|unique:customers',    // required and must be unique in the ducks table
            'password'         => 'required',
            'password_confirm' => 'required|same:password'          // required and has to match the password field
        );

        // validate against the inputs from our form
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {

           return json_encode(array('success'=>false, 'errors' => $validator->messages()));

        } else {
            $customer = new Customers;
            // form values
            $customer->email_address = Input::get('email_address');
            $customer->password = Hash::make(Input::get('password'));
            $customer->subscription_date = date('Y-m-d H:i:s');
            $customer->customerStatus = 'Pending';
            $customer->save();

            Session::put('customerID', $customer->customerID);

            return json_encode(array('success'=>true));
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

                $customerID = $existcustomer->customerID;

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

            return 'Success';

        }else{
            return 'Failed';
        }
        
    }


    public function updateCustomerInfo($data){

    }

    
    public function checkCustomerSession(){

        if (Session::has('customerID')) {
            return 'Found';
        }else{
            return 'Failed';
        }

    }



    public function privacypage(){
        echo 'privacy page';

       //  $cartID = Session::get('cartID');
       //  echo $cartID;
       // $resp = true;
       //  $session_id = MagentoAPI::initialize();
       //  var_dump(MagentoAPI::getCartInfo($session_id, $cartID));

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

           return json_encode(array('success'=>false, 'errors' => $validator->messages()));

        } else {
            $signupCustomer = new SignupCustomerModel();

            $errorMsg = array();

            $promotionCode = Input::get('promotionCode');
            if (!empty($promotionCode)) {

                $promotions = Promotions::where('promo_code', '=', $promotionCode)->get();
                if(count($promotions) > 0){

                    $errorMsg['promotionCode'] = 'Entered promotion code is not valid.';
                } else {
                    Session::put('promotionCode', $promotionCode);
                  
                }
            }

            if (!$signupCustomer->checkCoverage(Input::get('zipcode'))) {
                 $errorMsg['zipcode'] = 'Zipcode error or BetterWorld Wireless coverage is not adequate for this area. Call us for more info at 844-846-1653.';
            }

            if(count($errorMsg) > 0){
                return json_encode(array('success'=>false, 'errors' => $errorMsg));
            }else{

                $customerID = Session::get('customerID');

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

                $estimatedTax = number_format(Session::get('estimatedTax'), 2);

                return json_encode(array('success'=>$response, 'estimatedTax' => '$'.$estimatedTax));
            }

            
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

           return json_encode(array('success'=>false, 'errors' => $validator->messages()));

        } else {
            $response = true;

            $paymentMethod = array(
                        "po_number" => null,
                        "method" => 'authorizenet_directpost',
                        "cc_type" => Input::get('ccardtype'),
                        "cc_number" => Input::get('ccard'),
                        "cc_exp_month" => Input::get('mon'),
                        "cc_exp_year" => Input::get('yr'),
                        "cc_cid" => Input::get('cvv')     
                    );

            $response = self::addCCardInfoToCart($paymentMethod);

            $estimatedTax = number_format(Session::get('estimatedTax'), 2);

            return json_encode(array('success'=>$response, 'estimatedTax' => '$'.$estimatedTax));

        }


    }

    public function addCCardInfoToCart($paymentMethod){
        
        $cartID = Session::get('cartID');
        $session_id = MagentoAPI::initialize();
        $session = new Session();

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

                $grandtotal = $response['grand_total'];

                Session::put('transactionID', $transactionID);
                Session::put('orderID', $orderID);
                Session::put('shippingFee', $shippingFee);

            }

           
        
        }

         if($paid){

            // echo '<br/> Order paid using test Credit Account in Sandbox Authorize.net';

            $response = self::submitToCDrator(); // call CDRator API

            // echo 'Order is complete!';

            Session::forget('ordersets');

            $response = true;
         }

        return $response;

    }

    public function submitToCDrator(){
        $customerID = Session::get('customerID');

        $customer = Customers::find($customerID);

        $resp = true;

        $session = new Session();

        Session::put('estimatedTax', 0);


        if (Session::has('ordersets')) {
            $ordersets = Session::get('ordersets');
            
            // if(!count($ordersets)){
            //      $ordersets = array();

            //     $ordersets[] = array(
            //         'deviceID' => 2,
            //         'planID' => 23,
            //         'causeID' => 19,
            //         'byodhanset' => '',
            //         'meid' => ''
            //     );
            // }           


            $session_id = MagentoAPI::initialize();

            $signupCustomer = new SignupCustomerModel();
           
            foreach($ordersets as $cartProduct){
                $device = MagentoAPI::getProductDetailsByID($session_id, $cartProduct['deviceID']);
                $plan = MagentoAPI::getProductDetailsByID($session_id, $cartProduct['planID']);
               
                $productKey =  $plan['sku']; // plan code ()
                $handsetID = $device['sku'];
                $meid = $cartProduct['meid']; // MEID number for BYOSD
                
             

                if ($productKey != null) {
                    $productPlan = $signupCustomer->getPackageByKey($productKey);
                    $signupCustomer->setProductPlan($productPlan);
                }
                
                if ($handsetID != null && $cartProduct['byodhanset'] == '') {
                    $signupCustomer->setHandset($handsetID);
                }

                if ($meid != '') {
                    $byosdHandset = $user = ByosdHansets::find($handsetID);
                    if ($byosdHandset) {
                        $signupCustomer->setByosd($meid, $byosdHandset);
                    } else {
                        ///TODO: What should happen?
                        $resp = false;
                    }
                }

                if (is_null($signupCustomer->getProductPlan()) || (is_null($signupCustomer->getHandset()) && !$signupCustomer->isByosd())) {
                    // return new RedirectResponse('/#products');
                    // return to product list / shop page
                    $resp = false;
                }

                if (is_object($signupCustomer->getUser())) {
                    $user = $signupCustomer->getUser();
                } else {
                    $user = new User();
                    $user->Country = 'US';
                }

                if(Session::has('promotionCode')){
                    $signupCustomer->PromotionCode = Session::pull('promotionCode', 'default');
                }


                $user->Company = '';
                $user->FirstName = $customer->firstname;
                $user->LastName = $customer->lastname;
                $user->FloorUnit = '';
                $user->Address2 = $customer->street_address;
                $user->Street = '';
                $user->Zip = $customer->zipcode;
                $user->City = $customer->city;
                $user->State = $customer->state;
                $user->Email = $customer->email_address;
                $user->Username = $customer->email_address; //  check if username is null then set email address for FB and amazon


                //If user is already created, just update information on the user
                if ($signupCustomer->getOwnerID() != null) {
                    $updateUserRequest = new UpdateUserRequest();
                    $updateUserRequest->UserId = $signupCustomer->getOwnerID();
                    $updateUser = new UpdateUser($signupCustomer->getUser(), $signupCustomer->getOwnerID());
                    $updateUserRequest->setUser($updateUser);
                    $response = $updateUserRequest->executeRequest();
                    $estimateTax = Session::pull('estimatedTax', 'default');
                    $estimateTax += $signupCustomer->calculateTax();

                    Session::put('estimatedTax', $estimateTax);
                    
                    if ($response['errorCode'] != '0') {
                        $formResponse['response'] = $response;
                        //Generic error
                        $resp =  'Generic error: '.$response['errorMessage'];
                    } else {
                        $resp = true;

                        self::addChargesToCDrator($signupCustomer);

                    }
                } else {

                    $signupCustomerRequest = new SignupCustomer();
                    $signupCustomerRequest->setUser($user);
                    if (!empty($signupCustomer->PromotionCode)) {
                        $signupCustomerRequest->ReferencedBy = $signupCustomer->PromotionCode;
                    }

                    if (!empty($user->Company)) {
                        $signupCustomerRequest->AccountType = 1;
                    }

                            
                    $response = $signupCustomerRequest->executeRequest(); //TODO: Handle real webservice errors, like timeouts and such
                    
                    if (strtolower($response['errorMessage']) == 'username is not unique') { //TODO: Think about possible error codes and messages, e.g. username too long, non unique
                        // $formResponse['response'] = $response;
                        //WebService fails because of unique constraint
                        // $form->get('Username')->addError(new FormError($this->get('translator')->trans('signup.address_info.feedback.username_exists'))); //Username already taken, please choose another
                        // echo 'Username is already taken';

                        $resp = false;

                    } else if ($response['errorCode'] != '0') {
                        // $formResponse['response'] = $response;
                        //Generic error
                        // $form->get('Username')->addError(new FormError('Generic error: '.$response['errorMessage']));

                        $resp = 'Generic error: '.$response['errorMessage'];


                    } else {
                        $signupCustomer->setAccountID($response);
                        $signupCustomer->setCustomerNumber($response);
                        $signupCustomer->setOwnerID($response);
                        $signupCustomer->SetBillingGroup($response);
                        $signupCustomer->setUser($user);
                        if (!$signupCustomer->isByosd()) {
                            $signupCustomer->calculateTax();
                        }

                        $signupCustomer->AuthNetCustomerProfileID = null;
                        // save customer data for next process and payment
                        SignupCustomerModel::saveCurrentSignupCustomer($signupCustomer, $session);

                           
                        // echo 'CDrator User successfully created';

                        $resp = true;

                        self::addChargesToCDrator($signupCustomer);

                    }

            
                }

            }

        }


        return $resp;

    }


    public function addChargesToCDrator($signupCustomer){
        $session = new Session();

        $signupCustomer->AuthNetCustomerProfileID = Session::get('orderID'); // set orderID from magento 
        $signupCustomer->AuthNetPaymentProfileID = Session::get('transactionID');// set transaction ID as paymentProfile ID from Magento

        //TODO: Find out cost for Handset and what OrderID to use
        $handsetCost = !is_null($signupCustomer->getHandset()) ? $signupCustomer->getHandset()->getPrice() + $signupCustomer->getHandset()->shippingFee() : 6.25; //6.25 is the byosd "import" fee
        $firstMonthCost = $signupCustomer->getProductPlan()->RecurrentPrice;

         // save payment to CDRator API
        $savePaymentRequest = new SavePayment();
        $savePaymentRequest->BillingGroupID = $signupCustomer->getBillingGroupID();
        $savePaymentRequest->Amount = $handsetCost + $firstMonthCost; // symfony - included plan rate 
        $savePaymentRequest->PaymentDate = date('YmD');
        $savePaymentRequest->PaymentReference = Session::get('orderID'); 
        $savePaymentRequest->PaymentCaptured = true;
        $savePaymentRequest->TransactionID = Session::get('transactionID');
        $savePaymentRequest->executeRequest();


        $signupCustomer->signupSubscription();
        $signupCustomer->createRechargeTicket();
        if (!$signupCustomer->isByosd()) {
            $signupCustomer->orderHandset();
        }

        $addChargeRequest = new AddCharge();
        $addChargeRequest->Amount = $handsetCost;
        $addChargeRequest->BillingGroupID = $signupCustomer->getBillingGroupID();
        if ($signupCustomer->isByosd()) {
            $addChargeRequest->Description = sprintf('Byosd import fee', 'HandsetFee');
        } else {
            $addChargeRequest->Description = sprintf('Handset %s', $signupCustomer->getHandset()->getTitle(), 'HandsetFee');
        }

        $addChargeRequest->setChargeItemID('201406141600076507');
        $response = $addChargeRequest->executeRequest();

        if (!is_null($signupCustomer->getHandset()) && $signupCustomer->getHandset()->shippingFee() > 0) {
            $addChargeRequest = new AddCharge();
            $addChargeRequest->Amount = $signupCustomer->getHandset()->shippingFee();
            $addChargeRequest->BillingGroupID = $signupCustomer->getBillingGroupID();
            $addChargeRequest->Description = "Handset shipping fee";
            $addChargeRequest->setChargeItemID('201406141600076507');
            $response = $addChargeRequest->executeRequest();
        }

        if (stristr($signupCustomer->getProductPlan()->OptionKey, 'BWW_PAYG') !== false) {
            $chargeDescription = $signupCustomer->getProductPlan()->OptionKey == 'BWW_PAYG' ? 'Just plan (1st month deposit)' : 'Data Only (1st month deposit)';

            $addChargeRequest = new AddCharge();
            $addChargeRequest->Amount = 20;
            $addChargeRequest->BillingGroupID = $signupCustomer->getBillingGroupID();
            $addChargeRequest->Description = $chargeDescription;
            $addChargeRequest->setChargeItemID('201406141600076507');
            $response = $addChargeRequest->executeRequest();
        }

        SignupCustomerModel::saveCurrentSignupCustomer($signupCustomer, $session);

        if ($signupCustomer->isByosd()){
            self::confirmationAction($signupCustomer);
        }

        return true;
    }

    public function confirmationAction($signupCustomer) {
        $session = new Session();
        
        // $signupCustomer = SignupCustomerModel::getCurrentSignupCustomer($session);

        $getWebUserRequest = new GetWebUserProfileInternal();
        $getWebUserRequest->CustomerNumber = $signupCustomer->getCustomerNumber();
        $response = $getWebUserRequest->executeRequest();
        $userManager = null;

        if ($response['errorCode'] == '0' && array_key_exists('ROLE', $response) && $response['ROLE'] != '') {
            $userManager = new UserManager($response);

            //If the signup is Byosd try and activate right away. Display confirmation / error and send email on error
            if ($signupCustomer->isByosd() && !$signupCustomer->isActivated()) {
                $activateRequest = new ActivateSubscription();
                $activateRequest->SubscriptionID = $userManager->getCurrentSubscription()->getID();
                $activateRequest->MEID = $signupCustomer->getMEID();
                $activateResponse = $activateRequest->executeRequest();
                // echo "<pre>";
                // echo $activateRequest->getLastRequest();
                // print_r($activateResponse);
                // echo "</pre>";
                if ($activateResponse['errorCode'] == '0') {
                    $signupCustomer->setActivated();
                    SignupCustomerModel::saveCurrentSignupCustomer($signupCustomer, $session);
                }
            }


            // echo 'BYOSD subscription is created';
            $response = true;
        }else{
            $response = false;
        }
      

        return $response;
    }



}

?>  