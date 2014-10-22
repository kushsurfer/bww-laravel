<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class AddSharedServiceMember extends BaseAction implements IBaseAction
{
	public $SharedServiceID = null;
	public $GroupID = null;
    private $_targetObject = null;
								
	protected function prepareRequest() {
		$this->SoapAction = "SOAP_ADD_SHARED_SERVICE_MEMBER";
		
		$this->validateValue('SharedServiceID', $this->SharedServiceID);

		
		$this->Values = array(
			new stringValueDTO('SHARED_SERVICE_ID', $this->SharedServiceID),
            new complexValueDTO('TARGET_OBJECTS', $this->_targetObject)
		);
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}

    public function addTargetObject($subscriptionID, $billingGroupID = null, $accountID = null) {
        $this->_targetObject = array(
            new stringValueDTO('SUBSCRIPTION_ID', $subscriptionID),
            new stringValueDTO('BILLING_GROUP_ID', $billingGroupID),
            new stringValueDTO('ACCOUNT_ID', $accountID)
        );
    }
}