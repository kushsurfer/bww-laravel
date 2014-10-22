<?php
	namespace NomadicBits\DemoBundle\Model;
	
	use AuthorizeNet\lib\AuthorizeNetCIM;
	use AuthorizeNet\lib\AuthorizeNetCIM_Response;
	use AuthorizeNet\lib\shared\AuthorizeNetAddress;
	use AuthorizeNet\lib\shared\AuthorizeNetCustomer;
	use AuthorizeNet\lib\shared\AuthorizeNetPaymentProfile;

    use NomadicBits\CDRatorSoapClient\Action\GetOptionsForRatePlan;
    use NomadicBits\CDRatorSoapClient\Action\PreviewTaxes;
    use NomadicBits\CDRatorSoapClient\Object\User;
	use NomadicBits\CDRatorSoapClient\Object\CDMAService;
	use NomadicBits\CDRatorSoapClient\Object\SharedService;

    use NomadicBits\DemoBundle\Entity\ByosdHandset;
    use NomadicBits\DemoBundle\Model\Handset;
    use NomadicBits\DemoBundle\Model\ProductPlan;
	
	use NomadicBits\CDRatorSoapClient\Action\SignupSubscriptions;
    use NomadicBits\CDRatorSoapClient\Action\PerformCsaCheck;
	use NomadicBits\CDRatorSoapClient\Action\CreateRechargeTicket;
	use NomadicBits\CDRatorSoapClient\Action\OrderHandset;
    use NomadicBits\CDRatorSoapClient\Action\SubscribeProductOptions;

    use Symfony\Component\Debug\Exception\ContextErrorException;
    use Symfony\Component\HttpFoundation\Session\Session;
	
	class SignupCustomerModel
	{
		//TODO: Create and inject as service, passing session object

        private $_User;
		private $_BillingGroupID;
		private $_BillingGroupName;
		public $ProductCode = 'POST_PAID'; //TODO: Set proper ProductCode based on product is single or shared
		public $_AccountID = null;
		public $_OwnerID = null;
		public $PaymentFormToken;
		public $AuthNetCustomerProfileID = null;
		public $AuthNetPaymentProfileID = null;
		public $SubscriptionID;
		private $_ProductPlan;
        private $_Handset;
        private $_packages = null;
        private $_taxCalculated = false;
        private $_taxAmount = -1;
        const PRODUCT_CACHE_KEY = 'PRODUCT_PLAN_CACHE';
        public $PromotionCode = null;
        public $_ByosdHandset = null;
        public $_Password = null;
        public $_CustomerNumber = null;
        private $_IsActivated = false;

        private $_Meid = null;
		
		public $ProductID = null;
		public $HandsetID = null;

        public $userID = null;
		
		const CURRENT_SIGNUP_CUSTOMER = 'SIGNUP_CUSTOMER_SESSION_KEY';

        public function __construct() {
            $this->userID = rand(10000000, 99999999);
        }

        private function getPackages() {
            $is_apc_installed = extension_loaded('apc');
            if ($is_apc_installed && apc_exists(SignupCustomerModel::PRODUCT_CACHE_KEY)) {
                $this->_packages = apc_fetch(SignupCustomerModel::PRODUCT_CACHE_KEY);
            } else {
                $optionsForRatePlan = new GetOptionsForRatePlan();
                $optionsForRatePlan->ProductID = '201312240052364157'; //TODO: Config setting
                $optionsForRatePlan->RatePlanID = '201312292352141290'; //TODO: Config setting
                $response = $optionsForRatePlan->executeRequest();

                $packages = array();
                foreach($response['PRODUCT_OPTIONS'] as $productOption) {
                    if ($productOption['NAME'] == 'Tariff') {
                        foreach($productOption['PRODUCT_SUB_OPTIONS'] as $package) {
                            $optionKey = $package['OPTION_KEY'];
                            $productPlan = new ProductPlan();
                            $productPlan->Description = $package['DESCRIPTION'];
                            $productPlan->Label = $package['LABEL'];
                            $productPlan->Label = $package['LABEL'];
                            $productPlan->ID = $package['ID'];
                            $productPlan->InitialPrice = $package['INITIAL_PRICE'];
                            $productPlan->RecurrentPrice = $package['RECURRENT_PRICE'];
                            $productPlan->Name = $package['NAME'];
                            $productPlan->OptionKey = $package['OPTION_KEY'];
                            $packages[$optionKey] = $productPlan;
                        }
                    }
                }
                if ($is_apc_installed) {
                    apc_add(SignupCustomerModel::PRODUCT_CACHE_KEY, $packages, 3600);
                }

                $this->_packages = $packages;
            }
        }

        public function setCustomerNumber($responseArray) {
            $this->_CustomerNumber = $responseArray['ACCOUNT']['CUSTOMER_NUMBER'];
        }

        public function getCustomerNumber() {
            return $this->_CustomerNumber;
        }

        public function getAllPackages() {
            if (is_null($this->_packages)) {
                $this->getPackages();
            }
            return $this->_packages;
        }

        public function getPackageByKey($optionKey) {
            $optionKey = strtoupper($optionKey);
            if (is_null($this->_packages)) {
                $this->getPackages();
            }
            if (!array_key_exists($optionKey, $this->_packages)) {
                return null;
            }
            return $this->_packages[$optionKey];
        }
		
		public function setAccountID($responseArray) {
			$this->_AccountID = $responseArray['ACCOUNT']['ID'];
		}

        public function setPassword($password) {
            $this->_Password = $password;
        }

        public function getPassword() {
            return $this->_Password;
        }

		public function setOwnerID($responseArray) {
			$this->_OwnerID = $responseArray['ACCOUNT']['OWNER_ID'];
		}
		
		public function setBillingGroup($responseArray) {
			$this->_BillingGroupID = $responseArray['ACCOUNT']['BILLING_GROUPS']['BILLING_GROUP']['ID'];
			$this->_BillingGroupName = $responseArray['ACCOUNT']['BILLING_GROUPS']['BILLING_GROUP']['NAME'];
		}
		
		public function setUser(User $user) {
			$this->_User = $user;
		}
		
		public function setProductPlan(ProductPlan $productPlan = null) {
			$this->_ProductPlan = $productPlan;
		}
		
		/**
		 * @return \NomadicBits\DemoBundle\Model\ProductPlan
		 */
		public function getProductPlan() {
			return $this->_ProductPlan;
		}

        public function setHandset($handsetID) {
            $this->_Handset = Handset::getHandsetFromID($handsetID);
        }

        /**
         * @return \NomadicBits\DemoBundle\Model\Handset
         */
        public function getHandset() {
            return $this->_Handset;
        }

        public function setActivated() {
            $this->_IsActivated = true;
        }

        public function isActivated() {
            return $this->_IsActivated;
        }
		
		/**
		 * @return \NomadicBits\CDRatorSoapClient\Object\User the product configuration for the family product
		 */
		public function getUser() {
			return $this->_User;
		}
		
		public function getAccountID() {
			return $this->_AccountID;
		}
		
		public function getOwnerID() {
			return $this->_OwnerID;
		}
		
		public function getBillingGroupID() {
			return $this->_BillingGroupID;
		}
		
		public function getBillingGroupName() {
			return $this->_BillingGroupName;
		}

        public function checkCoverage($zipCode) {
            $performCsaCheckRequest = new PerformCsaCheck();
            $performCsaCheckRequest->ZipCode = $zipCode;
            $response = $performCsaCheckRequest->executeRequest();

            if ($response['errorCode'] != '0') {
                return false;
            } else {
                return true;
            }
        }

        public function setByosd($meid, ByosdHandset $handset) {
            $this->_Meid = $meid;
            $this->_ByosdHandset = $handset;
        }

        public function getMEID() {
            return $this->_Meid;
        }

        /**
         * @return ByosdHandset
         */
        public function getByosdHandset() {
            return $this->_ByosdHandset;
        }

        public function isByosd() {
            if (is_null($this->_Meid) || is_null($this->_ByosdHandset)) {
                return false;
            }
            return true;
        }
		
		public function signupSubscription() {
            $productOptionId = null;

            $stdBundleID = '201302141036173331';
            $lteBundleID = '201303071439046857';
            $stdCasualUsagePlanID = '201406170046069541';
            $lteCasualUsagePlanID = '201406170046069542';
            $dataOnlyPlanID = '201403052058035895';

            $isHandsetLteCapable = !is_null($this->getHandset()) ? $this->getHandset()->isLteCapable() : false;
            if (!is_null($this->getByosdHandset())) {
                $isHandsetLteCapable = $this->getByosdHandset()->getIsLte();
            }

            switch($this->getProductPlan()->OptionKey) {
                //x Fixed voice+data plans
                case 'BWW_Package_Small' :
                case 'BWW_Package_Mini' :
                case 'BWW_Package_Medium' :
                case 'BWW_Package_Extra' :
                case 'BWW_Package_Large' : $isHandsetLteCapable ? $productOptionId = $lteBundleID : $productOptionId = $stdBundleID; break;
                case 'BWW_PAYG' : $isHandsetLteCapable ? $productOptionId = $lteCasualUsagePlanID : $productOptionId = $stdCasualUsagePlanID; break;
                case 'BWW_DATA_250' :
                case 'BWW_DATA_500' :
                case 'BWW_DATA_1.2GB' :
                case 'BWW_DATA_2.75GB' :
                case 'BWW_PAYG_Data' : $productOptionId = $dataOnlyPlanID; break;
                default: $productOptionId = $isHandsetLteCapable ? $productOptionId = $lteBundleID : $productOptionId = $stdBundleID;
            }

            $cdmaService = new CDMAService();
			$cdmaService->addProductOptionID($this->getProductPlan()->ID);
            $cdmaService->addProductOptionID($productOptionId);
			$cdmaService->OrderID = "323289378932"; //TODO: Generate proper OrderID
				
			$signupSubscriptions = new SignupSubscriptions();
			$signupSubscriptions->addCDMAService($cdmaService); //This is always CDMA Service, as a workflow creates the shared service (if necessary)
			$signupSubscriptions->ProductCode = 'BWW';
			$signupSubscriptions->AccountID = $this->getAccountID();
			$signupSubscriptions->BillingGroupID = $this->getBillingGroupID();
			$signupSubscriptions->OwnerID = $this->getOwnerID();
			
			$response = $signupSubscriptions->executeRequest(); //TODO: Handle error

            /*$signupSubscriptions->dumpRawResponse();

            echo "<pre>";
            print_r($signupSubscriptions->getLastRequest());
            echo "</pre>";*/

            foreach($response['ACCOUNT']['BILLING_GROUPS']['BILLING_GROUP']['SUBSCRIPTIONS'] as $subscription) {
                if ($subscription['SERVICE']['CODE'] == 'CDMA') {
                    $this->SubscriptionID = $subscription['ID'];
                    break;
                }
            }
            if (!isset($this->SubscriptionID) && $this->SubscriptionID == '') {
                $this->SubscriptionID = $response['ACCOUNT']['BILLING_GROUPS']['BILLING_GROUP']['SUBSCRIPTIONS']['SUBSCRIPTION']['ID'];
            }

            //if the handset being purchased is lte capable, activate the Sprint LTE bundle (But only for pay as you go data plan)
            if ($isHandsetLteCapable && stristr($this->getProductPlan()->OptionKey, 'BWW_PAYG_Data') !== false) {
                $subscribeProductOptionsRequest = new SubscribeProductOptions();
                $subscribeProductOptionsRequest->SubscriptionID = $this->SubscriptionID;
                $subscribeProductOptionsRequest->addProductOption('201303071457156971'); //LTE
                $response = $subscribeProductOptionsRequest->executeRequest();
            }
		}

        public function createRechargeTicket() {
			$rechargeTicketRequest = new CreateRechargeTicket();
			$rechargeTicketRequest->BillingGroupID = $this->getBillingGroupID();
			$rechargeTicketRequest->setTicketID($this->AuthNetCustomerProfileID, $this->AuthNetPaymentProfileID);
			$response = $rechargeTicketRequest->executeRequest(); //TODO: Handle error
		}
		
		public function orderHandset() {
			$orderHandsetRequest = new OrderHandset();
			$orderHandsetRequest->Identifier = $this->getHandset()->getIdentifier();
			$orderHandsetRequest->SubscriptionID = $this->SubscriptionID;
			$response = $orderHandsetRequest->executeRequest();
		}

        public function taxCalculated() {
            return $this->_taxCalculated;
        }

        public function calculateTax($amount = -1) {
            if ($amount == -1) {
                $amount = 0;
                $amount += (float)$this->getHandset()->getPrice();
                $amount += (float)$this->getProductPlan()->RecurrentPrice;
            }
            $previewTaxesRequest = new PreviewTaxes();
            $previewTaxesRequest->CountryCode = 'US';
            $previewTaxesRequest->AddressState = $this->getUser()->State;
            $previewTaxesRequest->City = $this->getUser()->City;
            $previewTaxesRequest->Zip = $this->getUser()->Zip;
            $previewTaxesRequest->Charge = $amount;

            //The tax preview service fails from time to time, try a couple of times, and if it still fails report the error
            $taxPreviewStatus = false;
            $retries = 0;
            //return -1;

            while (!$taxPreviewStatus && $retries < 3) {
                try {
                    $response = $previewTaxesRequest->executeRequest();
                    $taxPreviewStatus = true;
                } catch (\SoapFault $excp) {
                    $retries++;
                }
            }

            $taxAmount = 0;
            if (array_key_exists('TAXES', $response)) {
                foreach($response['TAXES'] as $taxLine) {
                    $taxAmount += $taxLine['AMOUNT'];
                }
                $this->_taxCalculated = true;
            }

            $this->_taxAmount = $taxAmount;
            return $this->_taxAmount;
        }

        public function getTaxAmount() {
            if ($this->_taxAmount == -1) {
                $this->calculateTax();
            }
            return number_format($this->_taxAmount, 2);
        }

		/**
		 * @return \NomadicBits\DemoBundle\Model\SignupCustomerModel the product configuration for the family product
		 */
		public static function getCurrentSignupCustomer($session) {
			if ($session->has(SignupCustomerModel::CURRENT_SIGNUP_CUSTOMER)) {
                return $session->get(SignupCustomerModel::CURRENT_SIGNUP_CUSTOMER);
			}
            return null;
		}
		
		public static function saveCurrentSignupCustomer(SignupCustomerModel $signupCustomer, $session) {
			$session->set(SignupCustomerModel::CURRENT_SIGNUP_CUSTOMER, $signupCustomer);
		}
	}
?>