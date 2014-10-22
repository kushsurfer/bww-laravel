<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class PerformCsaCheck extends BaseAction implements IBaseAction
{
	public $ZipCode = null;
	
	protected function prepareRequest() {
	    $this->validateValue('ZipCode', $this->ZipCode);
		$this->SoapAction = "SOAP_PERFORM_CSA_CHECK";
		
		$this->Values = array(
			new stringValueDTO('ZIP_CODE', $this->ZipCode)
		);
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}