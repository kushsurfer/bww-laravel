<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

use NomadicBits\CDRatorSoapClient\Object\User;
use NomadicBits\CDRatorSoapClient\Object\DeliveryAddress;

class GetWebUserProfileInternal extends BaseAction implements IBaseAction
{
	public $CustomerNumber;
    public $PhoneNumber;
							
	protected function prepareRequest() {
		$this->SoapAction = "SOAP_GET_WEB_USER_PROFILE_INTERNAL";

        $this->Values = array(
            new stringValueDTO('CUSTOMER_NUMBER', $this->CustomerNumber),
            new stringValueDTO('PHONE_NUMBER', $this->PhoneNumber)
		);
	}

	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}