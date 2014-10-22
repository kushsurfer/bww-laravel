<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

use NomadicBits\CDRatorSoapClient\Object\NPFlow;

class ActivateSubscription extends BaseAction implements IBaseAction
{
	public $SubscriptionID = null;
	private $_NPFlow;
	
	protected function prepareRequest() {
		$this->validateValue('SubscriptionID', $this->SubscriptionID);	
		$this->SoapAction = "SOAP_ACTIVATE_SUBSCRIPTION";
		
		$this->Values = array(
			new stringValueDTO('SUBSCRIPTION_ID', $this->SubscriptionID),
			new complexValueDTO('NPFLOW', is_object($this->_NPFlow) ? $this->_NPFlow->getWebServiceObject() : null)
		);
	}
	
	public function setNPFlow(NPFlow $npFlow) {
		$this->_NPFlow = $npFlow;
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}