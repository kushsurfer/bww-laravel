<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class CreateRechargeTicket extends BaseAction implements IBaseAction
{
	public $BillingGroupID;
	private $_TicketID;
	private $TicketType = 'BASE';
	public $RechargeAmount;
	public $RechargeToAmount;
	public $DayOfMonth;
	public $RechargeLimit;
	public $CreditCardExpireDate;
	public $CardType;
	public $LastDigits;
	public $ExpMonth;
	public $ExpYear;
								
	protected function prepareRequest() {
		$this->SoapAction = "SOAP_CREATE_RECHARGE_TICKET";
		
		$this->validateValue('BillingGroupID', $this->BillingGroupID);
		$this->validateValue('TicketID', $this->_TicketID);
		$this->validateValue('TicketType', $this->TicketType);
		
		$this->Values = array( //TODO: Is it necessary to set amount and type
			new stringValueDTO('BILLING_GROUP_ID', $this->BillingGroupID),
			new stringValueDTO('REFERENCE', $this->_TicketID), //This was changed from TICKET_ID to REFERENCE after a bugfix by CDRator
			new stringValueDTO('TICKET_ID', $this->_TicketID), //This was changed from TICKET_ID to REFERENCE after a bugfix by CDRator
			new stringValueDTO('TICKET_TYPE', $this->TicketType),
			new stringValueDTO('RECHARGE_AMOUNT', $this->RechargeAmount),
			new stringValueDTO('RECHARGE_TO_AMOUNT', $this->RechargeToAmount),
			new stringValueDTO('RECHARGE_LIMIT', $this->RechargeLimit),
		);
	}
	
	public function setTicketID($customerProfileID, $paymentProfileID) {
		$this->_TicketID = sprintf('%s:%s',
			$customerProfileID, $paymentProfileID);
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}