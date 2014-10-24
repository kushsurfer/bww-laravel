<?php
	namespace NomadicBits\DemoBundle\Model;
	
	class ProductPlan {
		public $ID;
		public $Name;
		public $Description;
		public $Label;
		public $OptionKey;
		public $InitialPrice;
		public $RecurrentPrice;
		
		/**
		 * @return \NomadicBits\DemoBundle\Model\ProductPlan
		 */
		public static function getPlanFromKey($webKey) {
			switch($webKey) {
				case 'PLAN_A' : return ProductPlan::getPlanA();
				case 'PLAN_B' : return ProductPlan::getPlanB();
				case 'PLAN_C' : return ProductPlan::getPlanC();
                case 'PLAN_D' : return ProductPlan::getPlanD();
			}
		}

		public static function getPlanA() {
			$productPlan = new ProductPlan();
			$productPlan->ID = "201208281723260897";
            //$productPlan->ID = "201208281723260897";
			$productPlan->Name = "Mi Plus";
			$productPlan->Description = "For the user on the go...";
			$productPlan->Label = "For the light user...";
			$productPlan->OptionKey = "PLAN_A";
			$productPlan->InitialPrice = 0;
			$productPlan->RecurrentPrice = 50;
			return $productPlan;
		}
		
		public static function getPlanB() {
			$productPlan = new ProductPlan();
			$productPlan->ID = "201208281725530904";
			$productPlan->Name = "Mi Familia";
			$productPlan->Description = "For the family...";
			$productPlan->Label = "For the family...";
			$productPlan->OptionKey = "PLAN_B";
			$productPlan->InitialPrice = 0;
			$productPlan->RecurrentPrice = 79.99;
			return $productPlan;
		}
		
		public static function getPlanC() {
			$productPlan = new ProductPlan();
			$productPlan->ID = "201208281725080900";
			$productPlan->Name = "Mi Solo";
			$productPlan->Description = "For the light user...";
			$productPlan->Label = "For the light user...";
			$productPlan->OptionKey = "PLAN_C";
			$productPlan->InitialPrice = 0;
			$productPlan->RecurrentPrice = 25;
			return $productPlan;
		}

        public static function getPlanD() {
            $productPlan = new ProductPlan();
            $productPlan->ID = "201304121522417250";
            $productPlan->Name = "Mi Data Plus";
            $productPlan->Description = "Mi Data Plus";
            $productPlan->Label = "Mi Data Plus";
            $productPlan->OptionKey = "PLAN_D";
            $productPlan->InitialPrice = 0;
            $productPlan->RecurrentPrice = 29.99;
            return $productPlan;
        }
		
	}
	
?>