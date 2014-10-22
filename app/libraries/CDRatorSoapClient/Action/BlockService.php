<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class BlockService extends BaseAction implements IBaseAction
{						
	public $subscriptionID;
    public $blockType = 'BLOCK_AS_STOLEN';

    protected function prepareRequest() {
		$this->SoapAction = "SOAP_BLOCK_SERVICE";

        $this->validateValue('SubscriptionID', $this->subscriptionID);

        $this->Values = array(
            new stringValueDTO('SUBSCRIPTION_ID', $this->subscriptionID),
            new stringValueDTO('BLOCK_TYPE', $this->blockType),
            new dateValueDTO('STOLEN_DATE', date('Y-m-d\TH:i:s'))
        );
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}