<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class GetCampaigns extends BaseAction implements IBaseAction
{
	public $ProductID;
								
	protected function prepareRequest() {
		$this->SoapAction = "SOAP_GET_CAMPAIGNS";
		
		$this->validateValue('ProductID', $this->ProductID);
		
		$this->Values = array(
			new stringValueDTO('PRODUCT_ID', $this->ProductID)
		);
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}