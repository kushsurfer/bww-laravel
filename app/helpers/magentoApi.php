<?php

	Class MagentoAPI{
		

		protected static $mage_url = 'http://bww-magento.gfdev.net/api/soap/?wsdl'; 
		
		protected static $mage_user = 'bwwmagento'; 
		protected static $mage_api_key = '8iKNZoW5Ju'; 
		protected static $soap;

		// Initialize Magento API
		 public static function initialize()
		{
		   	// Initialize the SOAP client 
			self::$soap = new SoapClient( self::$mage_url ); 
		
		
			// // Login to Magento 
			$session_id = self::$soap->login( self::$mage_user, self::$mage_api_key );

			Session::put('magentoID', $session_id); // set session for Magento session ID
			

			return $session_id;
		}




		public static function getStoreView($session_id, $catID){

			return self::$soap->catalogCategoryCurrentStore($session_id, $catID);
		}


		public static function getResources($session_id){

			return self::$soap->resources( $session_id );
		}


		public static function getMProductlist($session_id){
			return self::$soap->catalogProductList($session_id);
		}


		public static function getAllCategories($session_id){
			return self::$soap->call($session_id, 'catalog_category.level');
		} 


		public static function getCategoryID($session_id, $catname){
			$categories =  self::getAllCategories($session_id);
		
			$catID = null;
			foreach($categories as $cat){
				if($cat['name'] == $catname){
					$catID = $cat['category_id'];
					break;
				}
			}

			return $catID;
		} 
		

		public static function getProductIDsByCategory($session_id, $catID){
			$productIDs = array();

			$catproducts = self::$soap->call($session_id, 'catalog_category.assignedProducts',  $catID);
			
			foreach($catproducts as $prod){
				$productIDs[] =  $prod['product_id'];
			}

		
			return $productIDs;
		}

		public static function getProductDetailsByIDs($session_id, $prodids){

			$prodDetails = array();

			if(count($prodids) > 0) {
				foreach($prodids as $id){
					
					// $prodattributes = array('product_id', 'name', 'status', 'short_description', 'price ');
					// $prodDetails[$id] = self::$soap->catalogProductInfo($session_id, $id, 'default', $prodattributes);	
					
					$prodDetails[$id] = self::$soap->call($session_id, 'catalog_product.info', $id);
					$prodDetails[$id]['images'] = self::getImageProducts($session_id, $id);
				}
				
			}

			return $prodDetails;

		}


		public static function getImageProducts($session_id, $prodID){
			
			$images = array();
			$prodimages = self::$soap->call($session_id, 'catalog_product_attribute_media.list', $prodID);
			
			if(count($prodimages) > 0){
				foreach($prodimages as $img){
					$images[] = $img['url'];
				}
			}

			return $images;
		}


		public static function getProductBySKU($session, $sku){
			
			$result = self::$soap->call($session, 'catalog_product.info', 'setorder');
			
			// If you don't need the session anymore
			//$client->endSession($session);

			return $result;

		}


		public static function getBundle($session){
			$result = self::$soap->call($session, 'bundleapi.listitems', array());
			var_dump ($result);
		}



		public static function createEmptyCart($sessionId){
			
			$shoppingCartIncrementId = self::$soap->call( $sessionId, 'cart.create', array('default'));

			return $shoppingCartIncrementId;
		}


		public static function addProductToCart($session, $cart, $products){
			$resultCartProductsAdd = self::$soap->call($session, "cart_product.add", array($cart, $products));

			return $resultCartProductsAdd;
		}

		public static function addCustomerToCart($sessionId, $shoppingCartId, $customerAsGuest){

			$resultCustomerSet =  self::$soap->call($sessionId, 'cart_customer.set', array( $shoppingCartId, $customerAsGuest) );

			return $resultCustomerSet;

		}

		public static function addCustomerInfoToCart($session, $cartId){
			$arrAddresses = array(
			    array(
			        "mode" => "shipping",
			        "firstname" => "testFirstname",
			        "lastname" => "testLastname",
			        "company" => "testCompany",
			        "street" => "testStreet",
			        "city" => "testCity",
			        "region" => "testRegion",
			        "postcode" => "testPostcode",
			        "country_id" => "id",
			        "telephone" => "0123456789",
			        "fax" => "0123456789",
			        "is_default_shipping" => 0,
			        "is_default_billing" => 0
			    ),
			    array(
			        "mode" => "billing",
			        "firstname" => "testFirstname",
			        "lastname" => "testLastname",
			        "company" => "testCompany",
			        "street" => "testStreet",
			        "city" => "testCity",
			        "region" => "testRegion",
			        "postcode" => "testPostcode",
			        "country_id" => "id",
			        "telephone" => "0123456789",
			        "fax" => "0123456789",
			        "is_default_shipping" => 0,
			        "is_default_billing" => 0
			    )
			);


			$response = self::$soap->call($session, "cart_customer.addresses", array($cartId, $arrAddresses));

			return $response;

		}

		public static function getShippingMethod($sessionId, $cartId){

			$result = self::$soap->call($sessionId, 'cart_shipping.list', $cartId);   

			return $result;
		}


		public static function setShippingMethod($sessionId, $cartId){

			$result = self::$soap->call($sessionId, 'cart_shipping.method', array($cartId, 'flatrate_flatrate'));
			
			return $result;
		}

		public static function getCartTotal($session, $cartId){
			$total =  self::$soap->call($session,'cart.totals',array($cartId));

			return $total;
		}


		public static function getPaymentList($session, $cartID){
			$result = self::$soap->call($session, 'cart_payment.list', $cartID);
			
			return $result;
		}


		public static function addCartPaymentMethod($sessionId, $shoppingCartId, $paymentMethod){
			$resultPaymentMethod = self::$soap->call($sessionId, "cart_payment.method", array($shoppingCartId, $paymentMethod));

			return $resultPaymentMethod;
		}


		public static function createOrderFromCart($sessionId,  $shoppingCartId){

			$resultOrderCreation = self::$soap->call($sessionId, "cart.order",  array($shoppingCartId));

			return $resultOrderCreation;
		}
	}

?>