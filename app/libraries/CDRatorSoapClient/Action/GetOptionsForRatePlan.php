<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class GetOptionsForRatePlan extends BaseAction implements IBaseAction
{
	public $ProductID = null;
	public $RatePlanID = null;
	public $GroupID = null;
								
	protected function prepareRequest() {
		$this->SoapAction = "SOAP_GET_OPTIONS_FOR_RATE_PLAN";
		
		$this->validateValue('ProductID', $this->ProductID);
		$this->validateValue('RatePlanID', $this->RatePlanID);
		
		$this->Values = array(
			new stringValueDTO('PRODUCT_ID', $this->ProductID),
			new stringValueDTO('RATE_PLAN_ID', $this->RatePlanID),
			new stringValueDTO('GROUP_ID', $this->GroupID)
		);
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}