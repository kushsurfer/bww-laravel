<?php

namespace NomadicBits\CDRatorSoapClient\Object;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class DeliveryAddress extends BaseObject implements IBaseObject
{
	public $Company;
	public $FirstName;
	public $LastName;
	public $Address2;
	public $City;
	public $Zip;
	public $Country;
	public $Phone1;
	public $Phone2;
	public $Phone3;
	public $Fax;
	public $Email;
	public $Email2;
	public $BirthDay;
	public $Username;
	public $Street;
	public $StreetNumber;
	public $Floor;
	public $FloorUnit;
	public $PersonalID;
	public $Gender;
	public $CreditLimit;
	public $LanguageCode;
	public $Title;
	public $PersonalExpiryDate;
	public $PersonalIdType;
	public $CommunicationType;
	public $StreetUnit;
	public $VatNumber;
	public $ZipExtension;
	public $State;
	public $StreetDirection;
	public $Password;
		
	public function getWebServiceObject() {
		//$this->validateValue('Company', $this->Company);
		$this->validateValue('FirstName', $this->FirstName);
		$this->validateValue('LastName', $this->LastName);
		//$this->validateValue('Address2', $this->Address2);
		$this->validateValue('City', $this->City);
		$this->validateValue('Zip', $this->Zip);
		//$this->validateValue('Country', $this->Country);
		//$this->validateValue('Phone1', $this->Phone1);
		//$this->validateValue('Phone2', $this->Phone2);
		//$this->validateValue('Phone3', $this->Phone3);
		//$this->validateValue('Fax', $this->Fax);
		$this->validateValue('Email', $this->Email);
		//$this->validateValue('Email2', $this->Email2);
		//$this->validateValue('BirthDay', $this->BirthDay);
		$this->validateValue('Username', $this->Username);
		//$this->validateValue('Street', $this->Street);
		//$this->validateValue('StreetNumber', $this->StreetNumber);
		//$this->validateValue('Floor', $this->Floor);
		//$this->validateValue('FloorUnit', $this->FloorUnit);
		//$this->validateValue('PersonalID', $this->PersonalID);
		//$this->validateValue('Gender', $this->Gender);
		//$this->validateValue('CreditLimit', $this->CreditLimit);
		//$this->validateValue('LanguageCode', $this->LanguageCode);
		//$this->validateValue('Title', $this->Title);
		//$this->validateValue('PersonalExpiryDate', $this->PersonalExpiryDate);
		//$this->validateValue('PersonalIdType', $this->PersonalIdType);
		//$this->validateValue('CommunicationType', $this->CommunicationType);
		//$this->validateValue('StreetUnit', $this->StreetUnit);
		//$this->validateValue('VatNumber', $this->VatNumber);
		//$this->validateValue('ZipExtension', $this->ZipExtension);
		//$this->validateValue('State', $this->State);
		//$this->validateValue('StreetDirection', $this->StreetDirection);
		//$this->validateValue('Password', $this->Password);
			
		return array(
			new stringValueDTO('COMPANY', $this->Company),
			new stringValueDTO('FIRST_NAME', $this->FirstName),
			new stringValueDTO('LAST_NAME', $this->LastName),
			new stringValueDTO('ADDRESS2', $this->Address2),
			new stringValueDTO('CITY', $this->City),
			new stringValueDTO('ZIP', $this->Zip),
			new stringValueDTO('COUNTRY', $this->Country),
			new stringValueDTO('PHONE1', $this->Phone1),
			new stringValueDTO('PHONE2', $this->Phone2),
			new stringValueDTO('PHONE3', $this->Phone3),
			new stringValueDTO('FAX', $this->Fax),
			new stringValueDTO('EMAIL', $this->Email),
			new stringValueDTO('EMAIL2', $this->Email2),
			new stringValueDTO('BIRTHDAY', $this->BirthDay),
			new stringValueDTO('USERNAME', $this->Username),
			new stringValueDTO('STREET', $this->Street),
			new stringValueDTO('STREET_NUMBER', $this->StreetNumbere),
			new stringValueDTO('FLOOR', $this->Floor),
			new stringValueDTO('FLOOR_UNIT', $this->FloorUnit),
			new stringValueDTO('PERSONAL_ID', $this->PersonalID),
			new stringValueDTO('GENDER', $this->Gender),
			new stringValueDTO('CREDIT_LIMIT', $this->CreditLimit),
			new stringValueDTO('LANGUAGE_CODE', $this->LanguageCode),
			new stringValueDTO('TITLE', $this->Title),
			new stringValueDTO('PERSONAL_ID_EXPIRY_DATE', $this->PersonalExpiryDate),
			new stringValueDTO('PERSONAL_ID_TYPE', $this->PersonalIdType),
			new stringValueDTO('COMMUNICATION_TYPE', $this->CommunicationType),
			new stringValueDTO('STREET_UNIT', $this->StreetUnit),
			new stringValueDTO('VAT_NUMBER', $this->VatNumber),
			new stringValueDTO('ZIP_EXTENSION', $this->ZipExtension),
			new stringValueDTO('STATE', $this->State),
			new stringValueDTO('STREET_DIRECTION', $this->StreetDirection),
			new stringValueDTO('PASSWORD', $this->Password)
		);
	}
}