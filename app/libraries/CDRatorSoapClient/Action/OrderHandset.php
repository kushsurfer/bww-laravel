<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class OrderHandset extends BaseAction implements IBaseAction
{
	public $SubscriptionID;
	public $Identifier;
	
	protected function prepareRequest() {
		$this->SoapAction = "SOAP_ORDER_HANDSET";
		
		$this->validateValue('SubscriptionID', $this->SubscriptionID);
		$this->validateValue('Identifier', $this->Identifier);
		
		$this->Values = array(
			new stringValueDTO('SUBSCRIPTION_ID', $this->SubscriptionID),
			new stringValueDTO('IDENTIFIER', $this->Identifier)
		);
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}