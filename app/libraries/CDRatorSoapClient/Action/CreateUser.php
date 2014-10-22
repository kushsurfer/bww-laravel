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

class CreateUser extends BaseAction implements IBaseAction
{
    public $AccountID = null;
    private $_User = null;
	private $_DeliveryAddress = null;

	public function setUser(User $user) {
		$this->_User = $user;
	}

	public function setDeliveryAddress(DeliveryAddress $deliveryAddress) {
		$this->_DeliveryAddress = $deliveryAddress;
	}

	protected function prepareRequest() {
		$this->validateValue('AccountID', $this->AccountID);
		$this->validateValue('User', $this->_User);
			
		$this->SoapAction = "SOAP_CREATE_USER";
		
		$this->Values = array(
            new stringValueDTO('ACCOUNT_ID', $this->AccountID),
			new complexValueDTO('USER', $this->_User->getWebServiceObject()),
		);
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}