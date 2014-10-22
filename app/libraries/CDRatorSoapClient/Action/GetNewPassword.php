<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class GetNewPassword extends BaseAction implements IBaseAction
{
	public $Login = null;
	public $SendType = null;
	
	protected function prepareRequest() {
		$this->validateValue('Login', $this->Login);
		$this->validateValue('SendType', $this->SendType);

		$this->SoapAction = "SOAP_GET_NEW_PASSWORD";
		
		$this->Values = array(
			new stringValueDTO('LOGIN', $this->Login),
			new stringValueDTO('SEND_TYPE', $this->SendType)
		);
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}