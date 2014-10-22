<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

use NomadicBits\CDRatorSoapClient\Object\NPFlow;

class ManageDevice extends BaseAction implements IBaseAction
{
	public $MEID = null;
    public $OwnerShipCode = 'PLBL';
	
	protected function prepareRequest() {
		$this->validateValue('MEID', $this->MEID);
        $this->validateValue('OwnerShipCode', $this->OwnerShipCode);
		$this->SoapAction = "SOAP_MANAGE_DEVICE";
		
		$this->Values = array(
			new stringValueDTO('MEID', $this->MEID),
            new stringValueDTO('OWNERSHIPCODE', $this->OwnerShipCode),
		);
	}

	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}


	public function testaccount(){

		$this->SoapAction = "SOAP_GET_PRODUCT_CONFIGS";
		return $this->sendRequest();

	}
}