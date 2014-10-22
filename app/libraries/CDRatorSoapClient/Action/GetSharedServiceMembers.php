<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class GetSharedServiceMembers extends BaseAction implements IBaseAction
{
	public $SharedServiceID = null;
	public $GroupID = null;
								
	protected function prepareRequest() {
		$this->SoapAction = "SOAP_GET_SHARED_SERVICE_MEMBERS";
		
		$this->validateValue('SharedServiceID', $this->SharedServiceID);
		
		$this->Values = array(
			new stringValueDTO('SHARED_SERVICE_ID', $this->SharedServiceID)
		);
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}