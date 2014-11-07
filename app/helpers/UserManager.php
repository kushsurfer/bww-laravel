<?php
    namespace NomadicBits\DemoBundle\Model;

    use NomadicBits\CDRatorSoapClient\Action\ActivateSubscription;
    use NomadicBits\CDRatorSoapClient\Action\CanAddSubscription;
    use NomadicBits\CDRatorSoapClient\Action\UpdateUser as UpdateUserRequest;
    use NomadicBits\CDRatorSoapClient\Action\ChangePassword;
    use NomadicBits\CDRatorSoapClient\Action\CreateRechargeTicket;
    use NomadicBits\CDRatorSoapClient\Action\DeleteRechargeTicket;
    use NomadicBits\CDRatorSoapClient\Action\GetRechargeTicket;
    use NomadicBits\CDRatorSoapClient\Action\GetInvoices;
    use NomadicBits\CDRatorSoapClient\Action\GetOptionsSubscription;
    use NomadicBits\CDRatorSoapClient\Action\AddCharge;
    use NomadicBits\CDRatorSoapClient\Action\GetSubOrders;
    use NomadicBits\CDRatorSoapClient\Action\AddSharedServiceMember;
    use NomadicBits\CDRatorSoapClient\Action\OrderHandset;
    use NomadicBits\CDRatorSoapClient\Action\SubscribeProductOptions;
    use NomadicBits\CDRatorSoapClient\Action\SignupSubscriptions;
    use NomadicBits\CDRatorSoapClient\Action\UnsubscribeProductOptions;
    use NomadicBits\CDRatorSoapClient\Action\GetInvoiceDetailLines;
    use NomadicBits\CDRatorSoapClient\Action\SavePayment;
    use NomadicBits\DemoBundle\Model\ProductPlan;

    use NomadicBits\CDRatorSoapClient\Object\User;
    use NomadicBits\CDRatorSoapClient\Object\CDMAService;
    use NomadicBits\CDRatorSoapClient\Object\BillingGroup;

    // use NomadicBits\DemoBundle\Model\AuthorizeNet;

    class UserManager {

        private $_account;
        private $_billingGroups;
        private $_users;
        private $_authNetCustomerProfileID;
        private $_authNetPaymentProfileID;
        private $_hasRechargeTicket;
        private $_internalID;
        private $_accountID;
        private $_webUserArray;
        private $_accountNumber;
        private $_accountOwnerID;
        //private $_currentBillingGroup;
        //private $_currentSubscription;

        public function __construct($webUserArray) {
            //Initialize users
            $this->_webUserArray = $webUserArray;
            $this->users = array();
            foreach($webUserArray['USERS'] as $user) {
                $this->_users[] = new User($user);
            }

            /*echo "<pre>";
            print_r($webUserArray);
            echo "</pre>";*/

            //Initialize BillingGroups
            $this->_billingGroups = array();
            foreach($webUserArray['ACCOUNT']['BILLING_GROUPS'] as $billingGroup) {
                $this->_billingGroups[] = new BillingGroup($billingGroup);
            }
            $this->_accountID = $webUserArray['ACCOUNT']['ID'];
            $this->_accountNumber = $webUserArray['ACCOUNT']['CUSTOMER_NUMBER'];
            $this->_internalID = str_replace('.', '', microtime(true)).rand(1000, 9999);
            $this->_accountOwnerID = $webUserArray['ACCOUNT']['OWNER_ID'];
        }

        public function getWebUserArray() {
            return $this->_webUserArray;
        }

        public function getInternalID() {
            return $this->_internalID;
        }

        public function getAccountID() {
            return $this->_accountID;
        }

        public function getAccountNumber() {
            return $this->_accountNumber;
        }

        /**
         * @return \NomadicBits\CDRatorSoapClient\Object\User
         */
        public function getAccountOwner() {
            foreach($this->_users as $user) {
                if ($user->ID == $this->_accountOwnerID) {
                    return $user;
                }
            }
        }

        /**
         * @return \NomadicBits\CDRatorSoapClient\Object\User
         */
        function getCurrentUser() {
            return $this->_users[0];
        }

        /**
         * @return \NomadicBits\CDRatorSoapClient\Object\BillingGroup
         */
        public function getCurrentBillingGroup() {
            return $this->_billingGroups[0];
        }

        /**
         * @return \NomadicBits\DemoBundle\Entity\Subscription
         */
        public function getCurrentSubscription() {
            $subscriptions = $this->getCurrentBillingGroup()->getSubscriptions();
            return $subscriptions[0];
        }

        /**
         * @return \NomadicBits\DemoBundle\Entity\Subscription
         */
        public function getSubscription($subscriptionID) {

            if (is_array($this->getCurrentBillingGroup()->getSubscriptions())) {
                foreach($this->getCurrentBillingGroup()->getSubscriptions() as $subscription) {
                    if ($subscription->getID() == $subscriptionID) {
                        return $subscription;
                    }
                }
            }
            return null;
        }

        /**
         * @return \NomadicBits\DemoBundle\Entity\Subscription[]
         */
        public function getSubscriptionsToActivate() {
            $subscriptionList = array();
            if (is_array($this->getCurrentBillingGroup()->getSubscriptions())) {
                foreach($this->getCurrentBillingGroup()->getSubscriptions() as $subscription) {
                    if ($subscription->canActivate()) {
                        $subscriptionList[] = $subscription;
                    }
                }
            }
            return $subscriptionList;
        }

        public function ownsSubscription($subscriptionID) {
            foreach($this->getCurrentBillingGroup()->getSubscriptions() as $subscription) {
                if ($subscription->getID() == $subscriptionID) {
                    return true;
                }
            }
            return false;
        }

        /**
         * @return \boolean
         */
        public function hasSharedService() {
            if ($this->getCurrentBillingGroup()->getSharedServiceSubscription() != null) {
                return true;
            } else {
                return false;
            }
        }

        public function generateOrderID() {
            return sprintf('%s%s%s', $this->getAccountNumber(), date('dmY'), rand(1000, 9999));
        }

        public function updateRechargeTicket($ticketID) {
            $ticketParts = explode(':', $ticketID);
            $this->_authNetCustomerProfileID = $ticketParts[0];
            $this->_authNetPaymentProfileID = $ticketParts[1];
            $this->_hasRechargeTicket = true;
        }

        public function deleteRechargeTicket() {
            $deleteRechargeTicketRequest = new DeleteRechargeTicket();
            $deleteRechargeTicketRequest->BillingGroupID = $this->getCurrentBillingGroup()->ID;
            $response = $deleteRechargeTicketRequest->executeRequest();
            $this->_hasRechargeTicket = false;
            return $response;
        }

        private function getRechargeTicket() {
            $getRechargeTicketRequest = new GetRechargeTicket();
            $getRechargeTicketRequest->BillingGroupID = $this->getCurrentBillingGroup()->ID;
            $response = $getRechargeTicketRequest->executeRequest();

            if ($response['errorCode'] == '0') {
                $ticketParts = explode(':', $response['TICKET_ID']);
                $this->_authNetCustomerProfileID = $ticketParts[0];
                $this->_authNetPaymentProfileID = $ticketParts[1];
                $this->_hasRechargeTicket = true;
            } else {
                $this->_hasRechargeTicket = false;
            }
        }

        public function hasRechargeTicket() {
            if (!isset($this->_hasRechargeTicket)) {
                $this->getRechargeTicket();
            }

            return $this->_hasRechargeTicket;
        }

        function getAuthNetCustomerProfileID() {
            if (!isset($this->_authNetCustomerProfileID)) {
                $this->getRechargeTicket();
            }
            return $this->_authNetCustomerProfileID;
        }

        function getAuthNetPaymentProfileID() {
            if (!isset($this->_authNetPaymentProfileID)) {
                $this->getRechargeTicket();
            }
            return $this->_authNetPaymentProfileID;
        }

        public function addCharge($amount, $description, $chargeType = 'Debit') {
            $addChargeRequest = new AddCharge();
            $addChargeRequest->Amount = $amount;
            $addChargeRequest->BillingGroupID = $this->getCurrentBillingGroup()->ID;
            $addChargeRequest->Description = $description;
            $chargeItemID = "";
            switch($chargeType) {
                case 'Credit' : $chargeItemID = '201208081436121213';break;
                case 'Debit' : $chargeItemID = '201208081435091205';break;
                case 'HandsetFee' : $chargeItemID = '201406141600076507';break;
                case 'PortingFee' : $chargeItemID = '201406141600076507';break;
                case 'ShippingFee' : $chargeItemID = '201406141600076507';break;
            }

            $addChargeRequest->setChargeItemID($chargeItemID);
            $addChargeRequest->executeRequest();
        }

        public function capturePayment($amount, $orderID = null, $container) {
            $authModel = new AuthorizeNet($container);
            $orderID = $this->generateOrderID();

            $response = $authModel->captureTransaction($this->getCurrentBillingGroup()->ID, $amount, $this->getAuthNetCustomerProfileID(), $this->getAuthNetPaymentProfileID(), $orderID);
            return $response;
        }

        public function hasPendingOrders($subscriptionID = null) {
            $getSubOrdersRequest = new GetSubOrders();
            if (is_null($subscriptionID)) {
                $subscriptionID = $this->getCurrentSubscription()->getID();
            }
            $getSubOrdersRequest->SubscriptionID = $subscriptionID;
            $response = $getSubOrdersRequest->executeRequest();
            if (array_key_exists('SHOP_ORDER_LIST', $response) && is_array($response['SHOP_ORDER_LIST'])) {
                foreach($response['SHOP_ORDER_LIST'] as $order) {
                    if ($order['STATUS'] == 'PENDING') {
                        return true;
                    }
                }
            }
            return false;
        }

        public function addSubscription($productKey, $handsetID, $container, $payByRechargeTicket = true, $addFamilyCounter = true) {


        }
    }