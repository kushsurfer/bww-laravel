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

class GetWebUserProfile extends BaseAction implements IBaseAction
{
	public $Login;
	public $Password;	
							
	protected function prepareRequest() {
		$this->SoapAction = "SOAP_GET_WEB_USER_PROFILE";
		
		$this->validateValue('Login', $this->Login);
		$this->validateValue('Password', $this->Password);
		
		$this->Values = array(
			new stringValueDTO('LOGIN', $this->Login),
			new stringValueDTO('PASSWORD', $this->Password)
		);
	}
	
	public function setUser(User $user) {
		$this->_User = $user;
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}