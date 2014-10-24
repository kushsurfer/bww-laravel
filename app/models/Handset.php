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

        public static function refreshList() {
            $handsetList = null;

            $data = Handsets::all();
                      
            foreach($data as $handset) {
                $handsetList[$handset->rator_product_id] = new Handset($handset->rator_product_id, $handset->phone_name, $handset->price, $handset->ltecapable, $handset->customer_care_only, $handset->shipping_fee);
           }

            //apc_add(Handset::CACHE_KEY, $handsetList, 3600);
			return $handsetList;
        }

        /**
         * @return \NomadicBits\DemoBundle\Model\Handset[]
         */
        public static function getHandsetList() {
            //if (!apc_exists(Handset::CACHE_KEY)) {
                return Handset::refreshList();
            //}
            //return apc_fetch(Handset::CACHE_KEY);
        }

        /**
         * @return \NomadicBits\DemoBundle\Model\Handset
         */
        public static function getHandsetFromID($identifier, $refresh = false) {
            $handsetList = Handset::getHandsetList();

            if (array_key_exists($identifier, $handsetList)) {
                return $handsetList[$identifier];
            } else {
                return null;
            }
        }
	}
