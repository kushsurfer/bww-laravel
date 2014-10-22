<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class AuthenticateOperator extends BaseAction implements IBaseAction
{
	public $CheckOperator;
    public $CheckPassword;
    public $CheckHookpointKey;
								
	protected function prepareRequest() {
		$this->SoapAction = "SOAP_AUTHENTICATE_OPERATOR";
		
		$this->validateValue('CheckOperator', $this->CheckOperator);
		$this->validateValue('CheckPassword', $this->CheckPassword);
		$this->validateValue('CheckHookPointKey', $this->CheckHookpointKey);

		$this->Values = array(
			new stringValueDTO('CHECK_OPERATOR', $this->CheckOperator),
			new stringValueDTO('CHECK_PASSWORD', $this->CheckPassword),
			new stringValueDTO('CHECK_HOOKPOINT_KEY', $this->CheckHookpointKey)
		);
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}