<?php

namespace NomadicBits\CDRatorSoapClient\Object;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class NPFlow extends BaseObject implements IBaseObject
{
	public $IsNP = false;
	public $AuthorizedBy = null;
	public $BusinessName = null;
	public $BillFirstName = null;
	public $BillLastName = null;
	public $BillStreetName = null;
	public $BillStreetNumber = null;
	public $BillStreetDirectionIndicator = null;
	public $BillCityName = null;
	public $BillStateCode = null;
	public $UspsPostalCD = null;
	public $UspsPostalCDExtension = null;
	public $SSN = null;
	public $TaxID = null;
	public $AccountNumber = null;
	public $PasswordPin = null;
	public $PhoneNumber = null;
	public $PortDate = null;
		
	public function getWebServiceObject() {
		
		$this->validateValue('AuthorizedBy', $this->AuthorizedBy);
		$this->validateValue('BillStreetName', $this->BillStreetName);
		$this->validateValue('BillCityName', $this->BillCityName);
		$this->validateValue('BillStateCode', $this->BillStateCode);
		$this->validateValue('UspsPostalCD', $this->UspsPostalCD);
		$this->validateValue('SSN', $this->SSN);
		//$this->validateValue('TaxID', $this->TaxID);
		$this->validateValue('AccountNumber', $this->AccountNumber);
		$this->validateValue('PhoneNumber', $this->PhoneNumber);
		$this->validateValue('PortDate', $this->PortDate);
			
		return $this->cleanArray(array(
			new stringValueDTO('AUTHORIZED_BY', $this->AuthorizedBy),
			new stringValueDTO('BUSINESS_NAME', $this->BusinessName),
			new stringValueDTO('BILL_FIRST_NAME', $this->BillFirstName),
			new stringValueDTO('BILL_LAST_NAME', $this->BillLastName),
			new stringValueDTO('BILL_STREET_NAME', $this->BillStreetName),
			new stringValueDTO('BILL_STREET_NUMBER', $this->BillStreetNumber),
			new stringValueDTO('BILL_STREET_DIRECTION_INDICATOR', $this->BillStreetDirectionIndicator),
			new stringValueDTO('BILL_CITY_NAME', $this->BillCityName),
			new stringValueDTO('BILL_STATE_CODE', $this->BillStateCode),
			new stringValueDTO('USPS_POSTAL_CD', $this->UspsPostalCD),
			new stringValueDTO('USPS_POSTAL_CD_EXTENSION', $this->UspsPostalCDExtension),
			new stringValueDTO('SSN', $this->SSN),
			new stringValueDTO('TAX_ID', $this->TaxID),
			new stringValueDTO('ACCOUNT_NUMBER', $this->AccountNumber),
			new stringValueDTO('PASSWORD_PIN', $this->PasswordPin),
			new stringValueDTO('PHONE_NUMBER', $this->PhoneNumber),
			new dateValueDTO('PORT_DATE', $this->PortDate)
		));
	}
}