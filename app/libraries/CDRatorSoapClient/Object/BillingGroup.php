<?php

namespace NomadicBits\CDRatorSoapClient\Object;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

use NomadicBits\DemoBundle\Entity\Subscription;

class BillingGroup extends BaseObject implements IBaseObject
{
	public $ID = null;
	public $BillingAddressID = null;
	public $BankAccountNumber = null;
	public $BankRegNumber = null;
	public $BankIdentifierCode = null;
	public $IbanNumber = null;
	public $InvoiceDeliveryType = null;
	public $PbsNumber = null;
	public $EanNumber = null;
    private $Subscriptions = null;
    private $_balance = null;
    private $_name = null;

    function __construct($billingGroupArray) {
        $this->ID = $billingGroupArray['ID'];
        $this->BillingAddressID = $billingGroupArray['BILLING_ADDRESS_ID'];
        $this->BankAccountNumber = $billingGroupArray['BANK_ACCOUNT_NUMBER'];
        $this->BankRegNumber = ''; //Missing from web service
        $this->BankIdentifierCode = $billingGroupArray['BANK_IDENTIFIER_CODE'];
        $this->IbanNumber = $billingGroupArray['IBAN_NUMBER'];
        $this->InvoiceDeliveryType = ''; //Missing from web service
        $this->PbsNumber = ''; //Missing from web service
        $this->EanNumber = ''; //Missing from web service
        $this->_name = $billingGroupArray['NAME'];
        if (isset($billingGroupArray['SUBSCRIPTIONS']) && is_array($billingGroupArray['SUBSCRIPTIONS'])) {
            foreach($billingGroupArray['SUBSCRIPTIONS'] as $subscription) {
                $this->Subscriptions[] = new Subscription($subscription);
            }
        }
        $this->_balance = $billingGroupArray['BALANCE'];
    }

    /**
     * @return \NomadicBits\DemoBundle\Entity\Subscription[]
     */
    public function getSubscriptions() {
        return $this->Subscriptions;
    }

    /**
     * @return \NomadicBits\DemoBundle\Entity\Subscription
     */
    public function getSubscriptionWithID($ID) {
        foreach($this->getSubscriptions() as $subscription) {
            if ($subscription->getID() == $ID) {
                return $subscription;
            }
        }
    }

    /**
     * @return \NomadicBits\DemoBundle\Entity\Subscription
     */
    public function getName() {
        return $this->_name;
    }

    /**
     * @return \float
     */
    public function getBalance() {
        return $this->_balance * -1;
    }

    /**
     * @return \string
     */
    public function getFormattedBalance() {
        return number_format($this->_balance * -1, 2);
    }

    public function getSharedServiceSubscription() {
        if (is_array($this->getSubscriptions())) {
            foreach($this->getSubscriptions() as $subscription) {
                if ($subscription->getService()->isSharedService()) {
                    return $subscription;
                }
            }
        }

        return null;
    }
		
	public function getWebServiceObject() {
		
		$this->validateValue('ID', $this->ID);
			
		return $this->cleanArray(array(
			new stringValueDTO('ID', $this->ID),
			new stringValueDTO('BILLING_ADDRESS_ID', $this->BillingAddressID),
			new stringValueDTO('BANK_ACCOUNT_NUMBER', $this->BankAccountNumber),
			new stringValueDTO('BANK_REG_NUMBER', $this->BankRegNumber),
			new stringValueDTO('BANK_IDENTIFIER_CODE', $this->BankIdentifierCode),
			new stringValueDTO('IBAN_NUMBER', $this->IbanNumber),
			new stringValueDTO('INVOICE_DELIVERY_TYPE', $this->InvoiceDeliveryType),
			new stringValueDTO('PBS_NUMBER', $this->PbsNumber),
			new stringValueDTO('EAN_NUMBER', $this->EanNumber)
		));
	}
}