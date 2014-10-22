<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class UpdateBillingGroup extends BaseAction implements IBaseAction
{
	private $_BillingGroup;	
							
	protected function prepareRequest() {
		$this->SoapAction = "SOAP_UPDATE_BILLING_GROUP";
		
		$this->validateValue('BillingGroup', $this->BillingGroup);
		
		$this->Values = array(
			new complexValueDTO('BILLING_GROUP', $this->BillingGroup)
		);
	}
	
	public function setBillingGroup(BillingGroup $billingGroup) {
		$this->_BillingGroup = $billingGroup;
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}