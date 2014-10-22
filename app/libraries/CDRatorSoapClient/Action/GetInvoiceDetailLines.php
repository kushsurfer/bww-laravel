<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class GetInvoiceDetailLines extends BaseAction implements IBaseAction
{
	public $SubscriptionID;
	public $BillingGroupID;
	public $CostCenterID;
	public $InvoiceID;
	public $StartDate;
	public $EndDate;
								
	protected function prepareRequest() {
		$this->SoapAction = "SOAP_GET_INVOICE_DETAIL_LINES";
		
		//$this->validateValue('BillingGroupID', $this->BillingGroupID);
		
		$this->Values = array(
			new stringValueDTO('SUBSCRIPTION_ID', $this->SubscriptionID),
			new stringValueDTO('BILLING_GROUP_ID', $this->BillingGroupID),
			new stringValueDTO('COST_CENTER_ID', $this->CostCenterID),
			new stringValueDTO('INVOICE_ID', $this->InvoiceID),
			new dateValueDTO('START_DATE', $this->StartDate),
			new dateValueDTO('END_DATE', $this->EndDate)
		);
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}