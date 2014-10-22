<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class SubscribeProductOptions extends BaseAction implements IBaseAction
{
	public $SubscriptionID;
	private $_ProductOptions = array();
	
	protected function prepareRequest() {
		$this->SoapAction = "SOAP_SUBSCRIBE_PRODUCT_OPTIONS";
		
		$this->validateValue('SubscriptionID', $this->SubscriptionID);
		
		$this->Values = array(
			new stringValueDTO('SUBSCRIPTION_ID', $this->SubscriptionID),
			new complexValueDTO('PRODUCT_OPTIONS', $this->_ProductOptions)
		);
	}
	
	public function addProductOption($ID, $parameters = null) {
		$productOption = array(
			new stringValueDTO('ID', $ID) 
			//TODO: Get Parameters
		);
		$this->_ProductOptions[] = new complexValueDTO('PRODUCT_OPTION', $productOption); 
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}