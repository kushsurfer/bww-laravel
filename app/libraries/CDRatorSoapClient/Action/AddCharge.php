<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class AddCharge extends BaseAction implements IBaseAction
{
	public $BillingGroupID;
	private $_ChargeItemID = '201208081436121213';
	public $Description;
	public $Amount;
	private $_isCredit;
								
	protected function prepareRequest() {
		$this->SoapAction = "SOAP_ADD_CHARGE";
		
		$this->validateValue('BillingGroupID', $this->BillingGroupID);
		$this->validateValue('ChargeItemID (call setChargeType)', $this->_ChargeItemID);
		$this->validateValue('Description', $this->Description);
		$this->validateValue('Amount', $this->Amount);
		
		//If it's a debit, add as a negative amount
		if (!$this->_isCredit) {
			$this->Amount = $this->Amount * -1;
		}
		
		$this->Values = array(
			new stringValueDTO('BILLING_GROUP_ID', $this->BillingGroupID),
			new stringValueDTO('CHARGE_ITEM_ID', $this->_ChargeItemID),
			new stringValueDTO('DESCRIPTION', $this->Description),
			new doubleValueDTO('AMOUNT', $this->Amount)
		);
	}

	public function setChargeItemID($chargeItemID) {
        $this->_ChargeItemID = $chargeItemID;
    }

    //201208081435091205, Manual Debit
    //201208081436121213, Manual Credit
    public function setChargeType($chargeType) {
		switch($chargeType) {
			case 'Credit' : $_isCredit = true; $this->_ChargeItemID = '201208081436121213'; break;
			case 'Debit' : $_isCredit = false; $this->_ChargeItemID = '201208081435091205'; break;
			default: throw new \Exception('Unknown chargeType passed, only use "Credit", "Debit" or "Handset"', 1);
		}
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}