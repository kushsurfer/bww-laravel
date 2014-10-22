<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class UnsubscribeProductOptions extends BaseAction implements IBaseAction
{
	public $SubscriptionID;
	private $_ProductOptions = array();
	
	protected function prepareRequest() {
		$this->SoapAction = "SOAP_UNSUBSCRIBE_PRODUCT_OPTIONS";
		
		$this->validateValue('SubscriptionID', $this->SubscriptionID);
		
		$this->Values = array(
			new stringValueDTO('SUBSCRIPTION_ID', $this->SubscriptionID),
			new complexValueDTO('PRODUCT_OPTION_IDS', $this->_ProductOptions)
		);
	}
	
	public function addProductOption($ID) {
		$this->_ProductOptions[] = new stringValueDTO('ID', $ID);
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}