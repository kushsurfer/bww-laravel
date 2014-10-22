<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class ChangePassword extends BaseAction implements IBaseAction
{
	public $UserID = null;
	public $Password = null;
	
	protected function prepareRequest() {
		$this->validateValue('UserID', $this->UserID);
		$this->validateValue('Password', $this->Password);	

		$this->SoapAction = "SOAP_CHANGE_PASSWORD";
		
		$this->Values = array(
			new stringValueDTO('USER_ID', $this->UserID),
			new stringValueDTO('PASSWORD', $this->Password)
		);
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}