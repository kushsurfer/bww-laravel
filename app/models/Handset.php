<?php

	
	class Handset {
		
		private $_identifier;
		private $_title;
		private $_price;
        private $_isLteCapable;
        private $_customerCareOnly;
        private $_shippingFee = 0;
        const CACHE_KEY = 'HANDSET_CACHE';
		
		function __construct($identifer, $title, $price, $isLteCapable, $customerCareOnly, $shippingFee) {
			$this->_identifier = $identifer;
            $this->_title = $title;
            $this->_price = $price;
            $this->_isLteCapable = $isLteCapable;
            $this->_customerCareOnly = $customerCareOnly;
            $this->_shippingFee = $shippingFee;
		}
		
		public function getIdentifier() {
			return $this->_identifier;
		}

        public function getTitle() {
            return $this->_title;
        }

        public function getPrice() {
            return $this->_price;
        }

        public function isLteCapable() {
            return $this->_isLteCapable;
        }

        public function isCustomerCareOnly() {
            return $this->_customerCareOnly;
        }

        public function shippingFee() {
            return $this->_shippingFee;
        }

        public static function refreshList($sku) {
            $handsetList = null;
            $session_id = MagentoAPI::initialize();
            // $data = Handset::getDisplayProductsByCatname();

            $handset = MagentoAPI::getProductBySKU($session_id, $sku);
            
            // foreach($data as $handset) {
            //     var_dump($handset);exit;

                $handsetList[$handset['sku']] = new Handset($handset['sku'], $handset['name'], $handset['price'], $handset['ltecapable'], $handset['customer_care_only'], $handset['shipping_per_product']);
           // }

            //apc_add(Handset::CACHE_KEY, $handsetList, 3600);
			return $handsetList;
        }

        public static function getDisplayProductsByCatname($catname = 'Devices'){

            $session_id = MagentoAPI::initialize();

            $catID = MagentoAPI::getCategoryID($session_id, $catname);

            $productIDs = MagentoAPI::getProductIDsByCategory($session_id, $catID);

            $resources = MagentoAPI::getProductDetailsByIDs($session_id, $productIDs);

            return $resources;
        }

        /**
         * @return \NomadicBits\DemoBundle\Model\Handset[]
         */
        public static function getHandsetList($identifier) {
            //if (!apc_exists(Handset::CACHE_KEY)) {
                return Handset::refreshList($identifier);
            //}
            //return apc_fetch(Handset::CACHE_KEY);
        }

        /**
         * @return \NomadicBits\DemoBundle\Model\Handset
         */
        public static function getHandsetFromID($identifier, $refresh = false) {
            $handsetList = Handset::getHandsetList($identifier);
            
            if (array_key_exists($identifier, $handsetList)) {
                return $handsetList[$identifier];
            } else {
                return null;
            }
        }
	}
