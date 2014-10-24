<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class PreviewTaxes extends BaseAction implements IBaseAction
{
	public $CountryCode = 'US';
	public $AddressState = null;
    public $City = null;
    public $Zip = null;
    public $TransactionType = 10;
    public $ServiceType = 15;
    public $Charge = null;
    public $CustomerNumber = '000000';
    public $TaxDate = null;
    public $IsBusinessUser = false;
	
	protected function prepareRequest() {
		$this->wsdlUrl = 'http://172.21.40.101:8080/workflow-soap/InvokerService?wsdl'; //Workaround to ensure the correct url being called

        if (is_null($this->TaxDate)) {
            $this->TaxDate = date('c');
        }

        $this->validateValue('CountryCode', $this->CountryCode);
        $this->validateValue('AddressState', $this->AddressState);
        $this->validateValue('City', $this->City);
        $this->validateValue('Zip', $this->Zip);
        $this->validateValue('TransactionType', $this->TransactionType);
        $this->validateValue('ServiceType', $this->ServiceType);
        $this->validateValue('Charge', $this->Charge);
        $this->validateValue('CustomerNumber', $this->CustomerNumber);
        $this->validateValue('TaxDate', $this->TaxDate);
		$this->validateValue('IsBusinessUser', $this->IsBusinessUser);

		$this->SoapAction = "SOAP_PREVIEW_TAXES";
		
		$this->Values = array(
			new stringValueDTO('COUNTRY_CODE', $this->CountryCode),
            new stringValueDTO('ADDRESS_STATE', $this->AddressState),
            new stringValueDTO('CITY', $this->City),
            new stringValueDTO('ZIP', $this->Zip),
            new longValueDTO('TRANSACTION_TYPE', $this->TransactionType),
            new longValueDTO('SERVICE_TYPE', $this->ServiceType),
            new doubleValueDTO('CHARGE', $this->Charge),
            new stringValueDTO('CUSTOMER_NUMBER', $this->CustomerNumber),
            new dateValueDTO('TAX_DATE', $this->TaxDate),
            new booleanValueDTO('IS_BUSINESS_USER', $this->IsBusinessUser),
		);
	}
	
	public function executeRequest() {
		$this->prepareRequest();
		return $this->sendRequest();
	}
}