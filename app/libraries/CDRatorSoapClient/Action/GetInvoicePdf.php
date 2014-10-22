<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class GetInvoicePdf extends BaseAction implements IBaseAction
{
	public $InvoiceID;
								
	protected function prepareRequest() {
		$this->SoapAction = "SOAP_GET_INVOICE_PDF";
		
		$this->validateValue('InvoiceID', $this->InvoiceID);
		
		$this->Values = array(
			new stringValueDTO('INVOICE_ID', $this->InvoiceID)
		);
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}