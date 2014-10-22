<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

use NomadicBits\CDRatorSoapClient\Object\CDMAService;
use NomadicBits\CDRatorSoapClient\Object\SharedService;

class SignupSubscriptions extends BaseAction implements IBaseAction
{
	public $SalesChannel = null;
	public $SalesAgentId = null;
	public $ProductCode = 'POST_PAID'; //Default ProductCode is POST_PAID for now
	public $AccountID = null;
	public $BillingGroupID = null;
	public $OwnerID = null;
	public $DeliveryAddressID = null;
	private $SignupServices = array();
						
	protected function prepareRequest() {
		$this->validateValue('ProductCode', $this->ProductCode);
		$this->validateValue('AccountID', $this->AccountID);
		$this->validateValue('BillingGroupID', $this->BillingGroupID);
		$this->validateValue('OwnerID', $this->OwnerID);
		$this->validateValue('SignupServices', $this->SignupServices);
		
		$this->SoapAction = "SOAP_SIGNUP_SUBSCRIPTIONS";
		
		$this->Values = $this->cleanArray(array(
			new stringValueDTO('SALES_CHANNEL', $this->SalesChannel),
			new stringValueDTO('SALES_AGENT_ID', $this->SalesAgentId),
			new stringValueDTO('PRODUCT_CODE', $this->ProductCode),
			new stringValueDTO('ACCOUNT_ID', $this->AccountID),
			new stringValueDTO('BILLING_GROUP_ID', $this->BillingGroupID),
			new stringValueDTO('OWNER_ID', $this->OwnerID),
			new stringValueDTO('DELIVERY_ADDRESS_ID', $this->DeliveryAddressID),
			new complexValueDTO('SIGNUP_SERVICES', $this->SignupServices)
		));
	}
	
	public function addCDMAService(CDMAService $CDMAService) {
		$this->SignupServices[] = new complexValueDTO('CDMA_SERVICE', $CDMAService->getWebServiceObject());
	}
	
	public function addSharedService(SharedService $SharedService) {
		$this->SignupServices[] = new complexValueDTO('SHARED_SERVICE', $SharedService->getWebServiceObject());
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}