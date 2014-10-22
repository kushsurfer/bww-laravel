<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class GetOptionsSubscription extends BaseAction implements IBaseAction
{
	public $SubscriptionID = null;
	public $GroupID = null;
								
	protected function prepareRequest() {
		$this->SoapAction = "SOAP_GET_OPTIONS_SUBSCRIPTION";
		
		$this->validateValue('SubscriptionID', $this->SubscriptionID);
		
		$this->Values = array(
			new stringValueDTO('SUBSCRIPTION_ID', $this->SubscriptionID),
			new stringValueDTO('GROUP_ID', $this->GroupID)
		);
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}