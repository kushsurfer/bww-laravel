<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\floatValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class SavePayment extends BaseAction implements IBaseAction
{
	public $BillingGroupID;
	public $Amount;
	public $PaymentDate;
	public $PaymentReference;
	public $TransactionID;
	public $TransactionNumber;
	public $Channel;
	public $FeeAmount;
	public $PaymentCaptured;

	
	protected function prepareRequest() {
		$this->SoapAction = "SOAP_SAVE_PAYMENT";
		
		$this->validateValue('BillingGroupID', $this->BillingGroupID);
		
		$this->Values = array(
			new stringValueDTO('BILLING_GROUP_ID', $this->BillingGroupID),
			new doubleValueDTO('AMOUNT', $this->Amount),
			new dateValueDTO('PAYMENT_DATE', $this->PaymentDate),
			new stringValueDTO('PAYMENT_REFERENCE', $this->PaymentReference),
			new stringValueDTO('TRANSACTION_ID', $this->TransactionID),
			new stringValueDTO('TRANSACTION_NUMBER', $this->TransactionNumber),
			new stringValueDTO('CHANNEL', $this->Channel),
			new doubleValueDTO('FEE_AMOUNT', $this->FeeAmount),
			new stringValueDTO('PAYMENT_CAPTURED', $this->PaymentCaptured)
		);
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}
