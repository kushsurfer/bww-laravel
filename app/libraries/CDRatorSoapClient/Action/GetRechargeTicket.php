<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class GetRechargeTicket extends BaseAction implements IBaseAction
{
	public $BillingGroupID;
								
	protected function prepareRequest() {
		$this->SoapAction = "SOAP_GET_RECHARGE_TICKET";
		
		$this->validateValue('BillingGroupID', $this->BillingGroupID);
		
		$this->Values = array(
			new stringValueDTO('BILLING_GROUP_ID', $this->BillingGroupID)
		);
	}

	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}