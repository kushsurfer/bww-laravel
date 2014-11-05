<?php

use NomadicBits\CDRatorSoapClient\Type\requestDTO;
use NomadicBits\CDRatorSoapClient\Type\valueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\executeMethod;
use NomadicBits\CDRatorSoapClient\executeMethodResponse;
use NomadicBits\CDRatorSoapClient\Action\GetProductConfigs;
use NomadicBits\DemoBundle\Manager\DeviceManager;
use NomadicBits\CDRatorSoapClient\Action\GetOptionsForRatePlan;

use NomadicBits\DemoBundle\Model\SignupCustomerModel;
use NomadicBits\CDRatorSoapClient\Action\SignupCustomer;
use NomadicBits\CDRatorSoapClient\Object\User;
use NomadicBits\CDRatorSoapClient\Object\UpdateUser;
use NomadicBits\CDRatorSoapClient\Action\UpdateUser as UpdateUserRequest;

use NomadicBits\DemoBundle\Model\AuthorizeNet;
use NomadicBits\CDRatorSoapClient\Action\SavePayment;
use NomadicBits\CDRatorSoapClient\Action\AddCharge;

class SController extends BaseController {

   

    public function setAddress(){
        // exit;
        $frminput = Input::get();

        $session = new Session();

        $formResponse = array();
        $formResponse['response'] = '';
        
        $productKey =  $frminput['plandCode']; // plan code ()
        $handsetID = $frminput['handsetID'];
        $meid = null; // MEID number for BYOSD



        if ($productKey != null && $handsetID != null) {
            $signupCustomer = new SignupCustomerModel();
        } else {
            $signupCustomer = SignupCustomerModel::getCurrentSignupCustomer($session);
            if ($signupCustomer == null) {
                $signupCustomer = new SignupCustomerModel();
            }
        }

        if ($productKey != null) {
            $productPlan = $signupCustomer->getPackageByKey($productKey);
            $signupCustomer->setProductPlan($productPlan);
        }


        if ($handsetID != null) {
            $signupCustomer->setHandset($handsetID);
        }



        if ($meid != null) {
            $repository = $this->getDoctrine()->getManager()->getRepository('NomadicBitsDemoBundle:ByosdHandset');
            $byosdHandset = $repository->find($handsetID);
            if ($byosdHandset) {
                $signupCustomer->setByosd($meid, $byosdHandset);
            } else {
                ///TODO: What should happen?
            }
        }

        if (is_null($signupCustomer->getProductPlan()) || (is_null($signupCustomer->getHandset()) && !$signupCustomer->isByosd())) {
            // return new RedirectResponse('/#products');
            // return to product list / shop page
        }

        if (is_object($signupCustomer->getUser())) {
            $user = $signupCustomer->getUser();
        } else {
            $user = new User();
            $user->Country = 'US';
        }

        $promotionCode = isset($frminput['signup']['PromotionCode']) ? $frminput['signup']['PromotionCode'] : ''; // promotion code
        if (!empty($promotionCode)) {

            $promotions = Promotions::where('promo_code', '=', $promotionCode)->get();
            if(count($promotions) > 0){

                $form->get('PromotionCode')->addError(new FormError('Entered promotion code is not valid.'));
                $formResponse['form'] = $form->createView();
                return $this->render('NomadicBitsDemoBundle:Signup:address.html.twig',
                    $formResponse);
            } else {
                $signupCustomer->PromotionCode = $promotionCode;
                //Send email if AnyP code
                if (stristr($promotionCode, 'AnyP') !== false) {
                    $body = sprintf('Full name: %s %s, User name: %s, Promotion code: %s',
                        $user->FirstName, $user->LastName, $user->Username, $promotionCode);

                    // $message = \Swift_Message::newInstance()
                    //     ->setSubject('AnyPerks Campaign Signup')
                    //     ->setFrom('noreply@upsourcemobile.com')
                    //     //->setTo('craig@upsourcemobile.com')
                    //     ->setTo('mickey@nomadicbits.com')
                    //     ->setBody($body);
                    // $this->get('mailer')->send($message);

                    // TODO: send email 
                }
            }
        }
        

        $zipcode = $frminput['signup']['Zip']; // form zipcode
       if (!$signupCustomer->checkCoverage($zipcode)) {
           
            // $this->get('session')->getFlashBag()->add('error', 'Oops! Looks like there\'s something off with your zip code, or possibly BetterWorld Wireless coverage is not adequate for this area. Call us for more info at 844-846-1653.');
            echo 'Oops! Looks like there\'s something off with your zip code, or possibly BetterWorld Wireless coverage is not adequate for this area. Call us for more info at 844-846-1653.';

            // return $this->render('NomadicBitsDemoBundle:Signup:address.html.twig',
            //     $formResponse);

            // TODO : render error message zipcode not acceptable
        }



        // save customer information to database        
        $customer = new Customers;
        // form values
        $customer->firstname = $frminput['signup']['FirstName'];
        $customer->lastname = $frminput['signup']['LastName'];
        $customer->email_address = $frminput['signup']['Email'];
        $customer->phone = '';
        $customer->street_address = $frminput['signup']['Street'];
        $customer->city = $frminput['signup']['City'];
        $customer->zipcode = $frminput['signup']['Zip'];
        $customer->state = $frminput['signup']['State'];
        $customer->country = $frminput['signup']['Country'];
        $customer->dob = '';
        $customer->employment = '';
        $customer->education = '';
        $customer->hometown = '';
        $customer->relationship = ''; 
        $customer->likes = '';
        $customer->shipping_address =  $frminput['signup']['Street'];
        $customer->shipping_state = $frminput['signup']['State'];
        $customer->shipping_zip = $frminput['signup']['Zip'];
        $customer->username = $frminput['signup']['Username'];
        $customer->password = '';
        $customer->subscription_date = date('Y-m-d H:i:s');
        $customer->customerStaatus = 'Pending';
        $customer->save();

        Session::put('customerID', $customer->id);


        $user->Company = $frminput['signup']['Company'];
        $user->FirstName = $frminput['signup']['FirstName'];
        $user->LastName = $frminput['signup']['LastName'];
        $user->FloorUnit = $frminput['signup']['FloorUnit'];
        $user->Address2 = $frminput['signup']['StreetNumber'];
        $user->Street = $frminput['signup']['Street'];
        $user->Zip = $frminput['signup']['Zip'];
        $user->City = $frminput['signup']['City'];
        $user->State = $frminput['signup']['State'];
        $user->Email = $frminput['signup']['Email'];
        $user->Username = $frminput['signup']['Username'];
    
        //If user is already created, just update information on the user
        if ($signupCustomer->getOwnerID() != null) {
            $updateUserRequest = new UpdateUserRequest();
            $updateUserRequest->UserId = $signupCustomer->getOwnerID();
            $updateUser = new UpdateUser($signupCustomer->getUser(), $signupCustomer->getOwnerID());
            $updateUserRequest->setUser($updateUser);
            $response = $updateUserRequest->executeRequest();
            $signupCustomer->calculateTax();
            
            if ($response['errorCode'] != '0') {
                $formResponse['response'] = $response;
                //Generic error
                $form->get('Username')->addError(new FormError('Generic error: '.$response['errorMessage']));
            } else {
                return $this->redirect($this->generateUrl('signup_terms'));
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
                echo 'Username is already taken';
            } else if ($response['errorCode'] != '0') {
                // $formResponse['response'] = $response;
                //Generic error
                // $form->get('Username')->addError(new FormError('Generic error: '.$response['errorMessage']));

                echo 'Generic error: '.$response['errorMessage'];
            } else {
                $signupCustomer->setAccountID($response);
                $signupCustomer->setCustomerNumber($response);
                $signupCustomer->setOwnerID($response);
                $signupCustomer->SetBillingGroup($response);
                $signupCustomer->setUser($user);
                if (!$signupCustomer->isByosd()) {
                    $signupCustomer->calculateTax();
                }

                
                // create billing profile in preparation for the payment process
                // $authModel = new AuthorizeNet($this->container);
                // $authNetCustomer = new AuthorizeNetCustomer();
                // $authNetCustomer->description = sprintf("%s %s", $user->FirstName, $user->LastName);
                // $authNetCustomer->merchantCustomerId = $signupCustomer->getBillingGroupName();
                // //$authNetCustomer->email = $user->Email;
                // $authResponse = $authModel->createCustomerProfile($authNetCustomer);
                
                // if ($authResponse->isOk()) {
                    // $signupCustomer->AuthNetCustomerProfileID = $authResponse->getCustomerProfileId();
                    $signupCustomer->AuthNetCustomerProfileID = null;
                    // save customer data for next process and payment
                    SignupCustomerModel::saveCurrentSignupCustomer($signupCustomer, $session);

                              
                    // return $this->redirect($this->generateUrl('signup_terms'));

                    // redirect to terms and condition pge
                // }

                echo 'CDrator User successfully created';
            }   
        }


        // echo 'cool2x';
    }


    public function addToCart(){
        
        if(Session::has('orderset')){

            // session order selections
            $orderset = Session::get('orderset');

            $session = new Session();

            $signupCustomer = SignupCustomerModel::getCurrentSignupCustomer($session);

            
            $session_id = MagentoAPI::initialize();
            
            $bundleProd = MagentoAPI::getProductBySKU($session_id, 'setorder');
            $prodID = $bundleProd['product_id'];

            $homepage = file_get_contents('http://bww-magento.gfdev.net/index.php/bundleids?prodID=21');
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

            $arrAddresses = array(
                    array(
                        "mode" => "shipping",
                        "firstname" => $signupCustomer->getUser()->FirstName,
                        "lastname" => $signupCustomer->getUser()->LastName,
                        "company" => $signupCustomer->getUser()->Company,
                        "street" => $signupCustomer->getUser()->Street,
                        "city" => $signupCustomer->getUser()->City,
                        // "region" => $signupCustomer->getUser()->,
                        "postcode" => $signupCustomer->getUser()->Zip,
                        "country_id" => $signupCustomer->getUser()->Country,
                        "telephone" => $signupCustomer->getUser()->Phone1,
                        "fax" => $signupCustomer->getUser()->Fax,
                        "is_default_shipping" => 0,
                        "is_default_billing" => 0
                    ),
                    array(
                        "mode" => "billing",
                        "firstname" => $signupCustomer->getUser()->FirstName,
                        "lastname" => $signupCustomer->getUser()->LastName,
                        "company" => $signupCustomer->getUser()->Company,
                        "street" => $signupCustomer->getUser()->Street,
                        "city" => $signupCustomer->getUser()->City,
                        // "region" => $signupCustomer->getUser()->,
                        "postcode" => $signupCustomer->getUser()->Zip,
                        "country_id" => $signupCustomer->getUser()->Country,
                        "telephone" => $signupCustomer->getUser()->Phone1,
                        // "fax" => "0123456789",
                        "is_default_shipping" => 0,
                        "is_default_billing" => 0
                    )
                );

            // $arrAddresses = null;

            $customerAsGuest = array(
                            "firstname" => "Retchel",
                            "lastname" => "Tapayan",
                            "email" => "rtapayan@global-fusion.net",
                            "website_id" => "0",
                            "store_id" => "0",
                            "mode" => "guest"
                        );

            $response = MagentoAPI::addCustomerToCart($session_id, $cartID, $customerAsGuest);
            // var_dump($response);
            // echo '<br/><br/><br/>';

            $response = MagentoAPI::addCustomerInfoToCart($session_id, $cartID, $arrAddresses);
      
           

            // $response = MagentoAPI::getPaymentList($session_id, $cartID);
            // var_dump($response);
            // echo '<br/><br/><br/>';


            // $response = MagentoAPI::getShippingMethod($session_id, $cartID);
            // var_dump($response);
            // echo '<br/><br/><br/>';

            $response = MagentoAPI::setShippingMethod($session_id, $cartID);
            // var_dump($response);
            // echo '<br/><br/><br/>';

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
            // var_dump($response);
            // echo '<br/><br/><br/>';


            $orderID = MagentoAPI::createOrderFromCart($session_id, $cartID);

            echo '<br/> Order created in Magento';
           
            if($orderID != 0){

                $signupCustomer->AuthNetCustomerProfileID = $orderID; // set orderID from magento 
             
                $response = MagentoAPI::getOrderInfo($session_id, $orderID);
                $transactionID =  $response['payment']['last_trans_id'];

                echo 'SubTotal: '. $response['base_subtotal'].'<br/>';
                echo 'Shipping & Handling (Flat Rate - Fixed): '. $response['shipping_amount'].'<br/>';
                echo 'Grand Total: '. $response['grand_total'].'<br/>';
              
                if($response['status'] == 'pending_payment'){
                    $invoiceID = MagentoAPI::createInvoice($session_id, $orderID);

                    echo '<br/> Invoice created in Magento';
                   
                    $paid = MagentoAPI::captureInvoice($session_id, $invoiceID);

                   

                    $response = MagentoAPI::getOrderInfo($session_id, $orderID);

                    $transactionID =  $response['payment']['last_trans_id'];

                    $shippingFee = $response['shipping_amount'];

                }

                $signupCustomer->AuthNetPaymentProfileID = $transactionID; // set transaction ID as paymentProfile ID from Magento

                
                // if($paid){

                //     echo '<br/> Order paid using test Credit Account in Sandbox Authorize.net';

                //     // save payment to CDRator API
                //     $savePaymentRequest = new SavePayment();
                //     $savePaymentRequest->BillingGroupID = $signupCustomer->getBillingGroupID();
                //     $savePaymentRequest->Amount = $grandtotal; // symfony - included plan rate 
                //     $savePaymentRequest->PaymentDate = date('YmD');
                //     $savePaymentRequest->PaymentReference = $orderID; 
                //     $savePaymentRequest->PaymentCaptured = true;
                //     $savePaymentRequest->TransactionID = $transactionID;
                //     $savePaymentRequest->executeRequest();

                //     //TODO: Find out cost for Handset and what OrderID to use
                //     $handsetCost = !is_null($signupCustomer->getHandset()) ? $signupCustomer->getHandset()->getPrice() + $shippingFee : 6.25; //6.25 is the byosd "import" fee
                //     $firstMonthCost = $signupCustomer->getProductPlan()->RecurrentPrice;

                //     $signupCustomer->signupSubscription();
                //     $signupCustomer->createRechargeTicket();
                //     if (!$signupCustomer->isByosd()) {
                //         $signupCustomer->orderHandset();
                //     }

                //     $addChargeRequest = new AddCharge();
                //     $addChargeRequest->Amount = $handsetCost;
                //     $addChargeRequest->BillingGroupID = $signupCustomer->getBillingGroupID();
                //     if ($signupCustomer->isByosd()) {
                //         $addChargeRequest->Description = sprintf('Byosd import fee', 'HandsetFee');
                //     } else {
                //         $addChargeRequest->Description = sprintf('Handset %s', $signupCustomer->getHandset()->getTitle(), 'HandsetFee');
                //     }

                //     $addChargeRequest->setChargeItemID('201406141600076507');
                //     $response = $addChargeRequest->executeRequest();

                //     if (!is_null($signupCustomer->getHandset()) && $shippingFee > 0) {
                //         $addChargeRequest = new AddCharge();
                //         $addChargeRequest->Amount = $shippingFee;
                //         $addChargeRequest->BillingGroupID = $signupCustomer->getBillingGroupID();
                //         $addChargeRequest->Description = "Handset shipping fee";
                //         $addChargeRequest->setChargeItemID('201406141600076507');
                //         $response = $addChargeRequest->executeRequest();
                //     }

                //     if (stristr($signupCustomer->getProductPlan()->OptionKey, 'BWW_PAYG') !== false) {
                //         $chargeDescription = $signupCustomer->getProductPlan()->OptionKey == 'BWW_PAYG' ? 'Just plan (1st month deposit)' : 'Data Only (1st month deposit)';

                //         $addChargeRequest = new AddCharge();
                //         $addChargeRequest->Amount = 20;
                //         $addChargeRequest->BillingGroupID = $signupCustomer->getBillingGroupID();
                //         $addChargeRequest->Description = $chargeDescription;
                //         $addChargeRequest->setChargeItemID('201406141600076507');
                //         $response = $addChargeRequest->executeRequest();
                //    }

                //    SignupCustomerModel::saveCurrentSignupCustomer($signupCustomer, $session);

                //    echo 'Order is complete!';
                // }
            }
        }else{
            echo 'Select Device, Plan and Cause first';
        }
    }


    // public function savePayment(){


    // }


    public function testconnection(){

        $optionsForRatePlan = new GetOptionsForRatePlan();
        $optionsForRatePlan->ProductID = '201312240052364157';
        $optionsForRatePlan->RatePlanID = '201312292352141290';
        $response = $optionsForRatePlan->executeRequest();
        echo "<pre>";
        print_r($response);
        echo "</pre>";
    }



    public function demo(){
        // $session = $this->get('session');
    	$session = new Session();

        $formResponse = array();
		$formResponse['response'] = '';
		
		$productKey = 'BWW_Package_Mini'; // plan code ()
		$handsetID = 'SAM-SPHM580';
        $meid = null; // MEID number for BYOSD


        if ($productKey != null && $handsetID != null) {
            $signupCustomer = new SignupCustomerModel();
        } else {
            $signupCustomer = SignupCustomerModel::getCurrentSignupCustomer($session);
            if ($signupCustomer == null) {
                $signupCustomer = new SignupCustomerModel();
            }
        }


		if ($productKey != null) {
			$productPlan = $signupCustomer->getPackageByKey($productKey);
            $signupCustomer->setProductPlan($productPlan);
		}


		if ($handsetID != null) {
			$signupCustomer->setHandset($handsetID);
		}

        if ($meid != null) {
            $repository = $this->getDoctrine()->getManager()->getRepository('NomadicBitsDemoBundle:ByosdHandset');
            $byosdHandset = $repository->find($handsetID);
            if ($byosdHandset) {
                $signupCustomer->setByosd($meid, $byosdHandset);
            } else {
                ///TODO: What should happen?
            }
        }

        if (is_null($signupCustomer->getProductPlan()) || (is_null($signupCustomer->getHandset()) && !$signupCustomer->isByosd())) {
            // return new RedirectResponse('/#products');
            // return to product list / shop page
        }

		if (is_object($signupCustomer->getUser())) {
			$user = $signupCustomer->getUser();
		} else {
			$user = new User();
			$user->Country = 'US';
		}


        $promotionCode = null; // promotion code
        if (!empty($promotionCode)) {

            $promotions = Promotions::where('promo_code', '=', $promotionCode)->get();
            if(count($promotions) > 0){

                $form->get('PromotionCode')->addError(new FormError('Entered promotion code is not valid.'));
                $formResponse['form'] = $form->createView();
                return $this->render('NomadicBitsDemoBundle:Signup:address.html.twig',
                    $formResponse);
            } else {
                $signupCustomer->PromotionCode = $promotionCode;
                //Send email if AnyP code
                if (stristr($promotionCode, 'AnyP') !== false) {
                    $body = sprintf('Full name: %s %s, User name: %s, Promotion code: %s',
                        $user->FirstName, $user->LastName, $user->Username, $promotionCode);

                    // $message = \Swift_Message::newInstance()
                    //     ->setSubject('AnyPerks Campaign Signup')
                    //     ->setFrom('noreply@upsourcemobile.com')
                    //     //->setTo('craig@upsourcemobile.com')
                    //     ->setTo('mickey@nomadicbits.com')
                    //     ->setBody($body);
                    // $this->get('mailer')->send($message);

                    // TODO: send email 
                }
            }
        }
       
       $zipcode = '94118'; // form zipcode
       if (!$signupCustomer->checkCoverage($zipcode)) {
           
            // $this->get('session')->getFlashBag()->add('error', 'Oops! Looks like there\'s something off with your zip code, or possibly BetterWorld Wireless coverage is not adequate for this area. Call us for more info at 844-846-1653.');
            echo 'Oops! Looks like there\'s something off with your zip code, or possibly BetterWorld Wireless coverage is not adequate for this area. Call us for more info at 844-846-1653.';

            // return $this->render('NomadicBitsDemoBundle:Signup:address.html.twig',
            //     $formResponse);

            // TODO : render error message zipcode not acceptable
        }

        // form values

        $user->Company = 'Global Fusion';
        $user->FirstName = 'Retchel';
        $user->LastName = 'Tapayan';
        $user->FloorUnit = 'Tapayan';
        $user->Address2 = '555';
        $user->Street = '10th Avenue';
        $user->Zip = '94118';
        $user->City = 'San Francisco';
        $user->State = 'CA';
        $user->Email = 'rtapayan@global-fusion.net';
        $user->Username = 'rtapayan';

        //If user is already created, just update information on the user
        if ($signupCustomer->getOwnerID() != null) {
            $updateUserRequest = new UpdateUserRequest();
            $updateUserRequest->UserId = $signupCustomer->getOwnerID();
            $updateUser = new UpdateUser($signupCustomer->getUser(), $signupCustomer->getOwnerID());
            $updateUserRequest->setUser($updateUser);
            $response = $updateUserRequest->executeRequest();
            $signupCustomer->calculateTax();
            
            if ($response['errorCode'] != '0') {
                $formResponse['response'] = $response;
                //Generic error
                $form->get('Username')->addError(new FormError('Generic error: '.$response['errorMessage']));
            } else {
                return $this->redirect($this->generateUrl('signup_terms'));
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
                echo 'Username is already taken';
            } else if ($response['errorCode'] != '0') {
                // $formResponse['response'] = $response;
                //Generic error
                // $form->get('Username')->addError(new FormError('Generic error: '.$response['errorMessage']));

                echo 'Generic error: '.$response['errorMessage'];
            } else {
                $signupCustomer->setAccountID($response);
                $signupCustomer->setCustomerNumber($response);
                $signupCustomer->setOwnerID($response);
                $signupCustomer->SetBillingGroup($response);
                $signupCustomer->setUser($user);
                if (!$signupCustomer->isByosd()) {
                    $signupCustomer->calculateTax();
                }

                // create billing profile in preparation for the payment process
                // $authModel = new AuthorizeNet($this->container);
                // $authNetCustomer = new AuthorizeNetCustomer();
                // $authNetCustomer->description = sprintf("%s %s", $user->FirstName, $user->LastName);
                // $authNetCustomer->merchantCustomerId = $signupCustomer->getBillingGroupName();
                // //$authNetCustomer->email = $user->Email;
                // $authResponse = $authModel->createCustomerProfile($authNetCustomer);
                
                // if ($authResponse->isOk()) {
                    // $signupCustomer->AuthNetCustomerProfileID = $authResponse->getCustomerProfileId();
                    $signupCustomer->AuthNetCustomerProfileID = null;
                    // save customer data for next process and payment
                    SignupCustomerModel::saveCurrentSignupCustomer($signupCustomer, $session);

                              
                    // return $this->redirect($this->generateUrl('signup_terms'));

                    // redirect to terms and condition pge
                // }

                echo 'CDrator User successfully created';
            }   
        }

       

    }


    public function displayTerms(){
        echo 'Display Terms and condition page';
    }

    public function processPayment(){
        echo 'Process payment here';
    }

     public function confirmationAction(Request $request) {
        $session = new Session();
        
        $signupCustomer = SignupCustomerModel::getCurrentSignupCustomer($session);

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
                echo "<pre>";
                echo $activateRequest->getLastRequest();
                print_r($activateResponse);
                echo "</pre>";
                if ($activateResponse['errorCode'] == '0') {
                    $signupCustomer->setActivated();
                    SignupCustomerModel::saveCurrentSignupCustomer($signupCustomer, $session);
                }
            }
        }
        
        return $this->render('NomadicBitsDemoBundle:Signup:confirmation.html.twig', array(
            'signupCustomer' => $signupCustomer,
            'userManager' => $userManager,
            'user' => $signupCustomer->getUser(),
            'handset' => $signupCustomer->getHandset(),
            'productPlan' => $signupCustomer->getProductPlan()
        )); 
    }

    
}



?>