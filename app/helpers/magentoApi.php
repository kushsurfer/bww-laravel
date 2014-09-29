<?php

	Class MagentoAPI{
	
		
		protected static $mage_url = 'http://bww-magento.gfdev.net/api/v2_soap/?wsdl'; 
		
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
			return self::$soap->catalogCategoryLevel($session_id);
		} 


		public static function getCategoryID($session_id, $catname){
			$categories =  self::getAllCategories($session_id);

			$catID = null;
			foreach($categories as $cat){
				if($cat->name == $catname){
					$catID = $cat->category_id;
					break;
				}
			}

			return $catID;
		} 


		public static function getProductIDsByCategory($session_id, $catID){
			$productIDs = array();

			$catproducts = self::$soap->catalogCategoryAssignedProducts($session_id, $catID);

			foreach($catproducts as $prod){
				$productIDs[] =  $prod->product_id;
			}

			return $productIDs;
		}

		public static function getProductDetailsByIDs($session_id, $prodids){

			$prodDetails = array();

			if(count($prodids) > 0) {
				foreach($prodids as $id){
					
					$prodattributes = array('product_id', 'name', 'status', 'short_description', 'price ');

					$prodDetails[$id] = self::$soap->catalogProductInfo($session_id, $id, 'default', $prodattributes);	
					$prodDetails[$id]->images = self::getImageProducts($session_id, $id);
				}
				
			}

			return $prodDetails;

		}


		public static function getImageProducts($session_id, $prodID){
			
			$images = array();
			$prodimages = self::$soap->catalogProductAttributeMediaList($session_id,  $prodID);
			
			if(count($prodimages) > 0){
				foreach($prodimages as $img){
					$images[] = $img->url;
				}
			}

			return $images;
		}
	}

?>