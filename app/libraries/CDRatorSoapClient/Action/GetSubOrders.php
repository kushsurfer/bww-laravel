<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class GetSubOrders extends BaseAction implements IBaseAction
{
	public $SubscriptionID;
								
	protected function prepareRequest() {
		$this->SoapAction = "SOAP_GET_SUB_ORDERS";
		
		$this->validateValue('SubscriptionID', $this->SubscriptionID);
		
		$this->Values = array(
			new stringValueDTO('SUBSCRIPTION_ID', $this->SubscriptionID)
		);
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}