<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

use NomadicBits\CDRatorSoapClient\Object\User;
use NomadicBits\CDRatorSoapClient\Object\DeliveryAddress;

class SignupCustomer extends BaseAction implements IBaseAction
{
	public $SalesChannel = null;
	public $SalesAgentId = null;
	public $AccountType = '0'; //TODO: Implement AccountType properly. 0 = Private, 1 = Company
	public $ProductCode = 'POST_PAID'; //Default ProductCode is POST_PAID for now
	public $BillingGroup = null;
	public $RechargeTicket = null;
	private $_User = null;
	private $_DeliveryAddress = null;
    public $ReferencedBy = null;
    public $Campaign = null;
	
	public function setUser(User $user) {
		$this->_User = $user;	
	}
	
	public function setDeliveryAddress(DeliveryAddress $deliveryAddress) {
		$this->_DeliveryAddress = $deliveryAddress;	
	}
						
	protected function prepareRequest() {
		$this->validateValue('AccountType', $this->AccountType);
		$this->validateValue('ProductCode', $this->ProductCode);
		$this->validateValue('User', $this->_User);
			
		$this->SoapAction = "SOAP_SIGNUP_CUSTOMER";
		
		$this->Values = array(
            new stringValueDTO('REFERENCED_BY', $this->ReferencedBy),
            new stringValueDTO('SALES_CHANNEL', $this->SalesChannel),
			new stringValueDTO('SALES_AGENT_ID', $this->SalesAgentId),
			new stringValueDTO('ACCOUNT_TYPE', $this->AccountType),
			new stringValueDTO('PRODUCT_CODE', $this->ProductCode),
			new complexValueDTO('RECHARGE_TICKET', $this->RechargeTicket),
			new complexValueDTO('BILLING_GROUP', $this->BillingGroup),
			new complexValueDTO('USER', $this->_User->getWebServiceObject()),
			new complexValueDTO('DELIVERY_ADDRESS', is_object($this->_DeliveryAddress) ? $this->_DeliveryAddress->getWebServiceObject() : null)
		);
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}