<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class CanAddSubscription extends BaseAction implements IBaseAction
{
	public $AccountID = null;
	
	protected function prepareRequest() {
		$this->validateValue('AccountID', $this->AccountID);	
		$this->SoapAction = "SOAP_CAN_ADD_SUBSCRIPTION";
		
		$this->Values = array(
			new stringValueDTO('ACCOUNT_ID', $this->AccountID)
		);
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}