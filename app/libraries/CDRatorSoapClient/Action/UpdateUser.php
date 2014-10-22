<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

use NomadicBits\CDRatorSoapClient\Object\UpdateUser as UpdateUserObject;
use NomadicBits\CDRatorSoapClient\Object\DeliveryAddress;

class UpdateUser extends BaseAction implements IBaseAction
{
	private $_User;
							
	protected function prepareRequest() {
		$this->SoapAction = "SOAP_UPDATE_USER";
		
		$this->validateValue('User', $this->_User);
		
		$this->Values = array(
			new complexValueDTO('USER', $this->_User->getWebServiceObject())
		);
	}
	
	public function setUser(UpdateUserObject $user) {
		$this->_User = $user;
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}