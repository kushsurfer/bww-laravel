<?php
	namespace NomadicBits\DemoBundle\Model;
	
	use AuthorizeNet\lib\AuthorizeNetCIM;
	use AuthorizeNet\lib\AuthorizeNetSIM;
	use AuthorizeNet\lib\AuthorizeNetSIMFrm;
	use AuthorizeNet\lib\AuthorizeNetCIM_Response;
	use AuthorizeNet\lib\shared\AuthorizeNetAddress;
	use AuthorizeNet\lib\shared\AuthorizeNetCustomer;
	use AuthorizeNet\lib\shared\AuthorizeNetPaymentProfile;

    use Symfony\Bridge\Monolog\Logger;
	
	use Symfony\Component\HttpFoundation\Session\Session;
	
	use NomadicBits\CDRatorSoapClient\Action\SavePayment;

	//define("AUTHORIZENET_API_LOGIN_ID", "28ZrQx2X93");
	//define("AUTHORIZENET_TRANSACTION_KEY", "34tSMSb4e564uM6V");
	//define("AUTHORIZENET_SANDBOX", true);
	
	define('AUTHORIZENET_CUSTOMER_PROFILE_ID', 'CustomerProfileID'); 
	
	class AuthorizeNet
	{

        private $container;
        private $session;

        function __construct($container) {
            $this->container = $container;
            $this->session = $this->container->get('session');
        }

        /**
	     * Create a customer profile.
	     *
	     * @param AuthorizeNetCustomer $customerProfile
	     * @param string               $validationMode
	     *
	     * @return AuthorizeNetCIM_Response
	     */
		function createCustomerProfile(AuthorizeNetCustomer $customer, $validationMode = "none") {
            $request = $this->container->get('authorize_net')->getCIMRequest();
			
			$response = $request->createCustomerProfile($customer, $validationMode);
			
			if($response->isOk()) {
				$this->session->set(AUTHORIZENET_CUSTOMER_PROFILE_ID, $response->getCustomerProfileId());
			}
			
			return $response;
		}
		
		function getCustomerProfileID() {
			return $this->session->get(AUTHORIZENET_CUSTOMER_PROFILE_ID);
		}
		
		function getHostedPaymentFormToken($customerProfileID) {
            $request = $this->container->get('authorize_net')->getCIMRequest();

            $protocol = isset($_SERVER['HTTPS']) ? 'https' : 'http';
            $serverName = $_SERVER['SERVER_NAME'];
            $logger = new Logger('app');

			$isOK = false;
            $i = 0;
            
            while(!$isOK) {
                $response = $request->getHostedPaymentFormToken($customerProfileID, sprintf('%s://%s/auth.net/contentx/IframeCommunicator.html', $protocol, $serverName), sprintf('http://%s/auth.net/testing.html', $serverName), 'testing'); //TODO: Get from session, user?
				
                if ($response->isOk()) {
                    $this->container->get('logger')->info('Payment token successfully retrieved');
                    $isOK = true;
                } else {
                    $this->container->get('logger')->err('Failed to get payment token');
                }

                $i++;
                if ($i >= 10) {
                    $this->container->get('logger')->err(sprintf('Failed to get payment token in %s tries, breaking out', $i));
                    break;
                }
            }

			return $response;
		}
		
		function getPaymentProfile($customerProfileID) {
            $request = $this->container->get('authorize_net')->getCIMRequest();
			$response = $request->getCustomerProfile($customerProfileID);	
			
			return $response;
		}
		
		function deleteCustomerPaymentProfile($customerProfileID, $customerPaymentProfileID) {
            $request = $this->container->get('authorize_net')->getCIMRequest();
			$response = $request->deleteCustomerPaymentProfile($customerProfileID, $customerPaymentProfileID);
			
			if($response->isOk()) {
				//$session = new Session();
				//$session->start();
				return true;
			} else {
				return false;
			}	
		}
		
		function getSIMFormParameters($amount, $billingGroupID, $orderID = null, $relayUrl) {
			if ($orderID == null) {
				$fp_sequence = "1234" . time();
			} else {
				$fp_sequence = $orderID;
			}
			$au = $this->container->get('authorize_net')->getSimForm();
			$fp_timestamp = time();
			$fingerprint = AuthorizeNetSIMFrm::getFingerprint($this->container->get('authorize_net')->getApiLoginID(), $this->container->get('authorize_net')->getTransactionKey(), $amount, $fp_sequence, $fp_timestamp);
			$parameters['x_login'] = $this->container->get('authorize_net')->getApiLoginID();
			$parameters['x_fp_hash'] = $fingerprint;
			$parameters['x_amount'] = $amount;
			$parameters['x_fp_timestamp'] = $fp_timestamp;
			$parameters['x_fp_sequence'] = $fp_sequence;
			$parameters['x_invoice_num'] = $fp_sequence;
			$parameters['x_test_request'] = 'false';
			$parameters['x_relay_response'] = 'true';
			$parameters['x_relay_url'] = $relayUrl;
			$parameters['x_version'] = '3.1';
			$parameters['x_method'] = 'cc';
            $parameters['x_description'] = '';
			$parameters['x_show_form'] = 'payment_form';
			$parameters['x_header_html_payment_form'] = "<style type='text/css' media='all'> body {background-color: #F5F5F5} #divBillingInformation, #divShippingInformation, #divMerchantHeader, #tableOrderInformation, #divOrderDetailsTop, #hrDescriptionAfter {display:none}</style> Please enter your payment and shipping information.";

			return $parameters;
		}

		/**
	     * Authorizes and captures a payment from Authorize.NET and on success save the payment on the respective BillingGroup
	     *
	     *
	     * @return AuthorizeNetCIM_Response
	     */
		function captureTransaction($billingGroupID, $amount, $customerProfileID, $customerPaymentProfileID, $orderID) {
            $request = $this->container->get('authorize_net')->getCIMRequest();
			$response = $request->createCustomerProfileTransaction($amount, $customerProfileID, $customerPaymentProfileID, $orderID);

            $directResponse = $response->getDirectResponse(); //Parse response based on the docs here: http://www.authorize.net/support/AIM_guide.pdf
            $this->container->get('logger')->info(sprintf('captureTransaction directResponse: %s, ProfileID: %s, PaymentProfileID: %s', $response->response, $customerProfileID, $customerPaymentProfileID));

			if ($response->isOk()) {
                $directResponse = $response->getDirectResponse(); //Parse response based on the docs here: http://www.authorize.net/support/AIM_guide.pdf
				$parts = explode(',', $directResponse);
                $responseCode = $parts[0];
                $this->container->get('logger')->info(sprintf('captureTransaction responseCode: %s, ProfileID: %s, PaymentProfileID: %s', $responseCode, $customerProfileID, $customerPaymentProfileID));
                if ($responseCode != '1') { //Transaction was declined or an error occurred
                    return false;
                }
				$transactionID = $parts[6];
				$isCaptured = $parts[11] == 'auth_capture' ? 'true' : 'false';
				
				$savePaymentRequest = new SavePayment();
				$savePaymentRequest->BillingGroupID = $billingGroupID;
				$savePaymentRequest->Amount = $amount;
				$savePaymentRequest->PaymentDate = date('YmD');
				$savePaymentRequest->PaymentReference = $orderID;
				$savePaymentRequest->PaymentCaptured = $isCaptured;
				$savePaymentRequest->TransactionID = $transactionID;
				$savePaymentRequest->executeRequest();

                $this->container->get('logger')->info(sprintf('SavePayment: %s', $amount));
					
				return true;
			} else {
				return false;
			}
		}
	}
?>