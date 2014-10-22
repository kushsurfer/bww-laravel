<?php

namespace NomadicBits\CDRatorSoapClient\Object;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class User extends BaseObject implements IBaseObject
{
	public $ID;
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
	
	public function __construct($userArray = null)
    {
        if (is_array($userArray)) {
        	$this->ID = $userArray['ID'];
        	$this->FirstName = $userArray['FIRST_NAME'];
			$this->LastName = $userArray['LAST_NAME'];
			$this->Username = $userArray['USERNAME'];
			$this->Address2 = $userArray['ADDRESS2'];
			$this->City = $userArray['CITY'];
			$this->Zip = $userArray['ZIP'];
			$this->Country = $userArray['COUNTRY'];
			$this->Phone1 = $userArray['PHONE1'];
			$this->Phone2 = $userArray['PHONE2'];
			$this->Phone3 = $userArray['PHONE3'];
			$this->Fax = $userArray['FAX'];
			$this->Email = $userArray['EMAIL'];
			$this->Email2 = $userArray['EMAIL2'];
			$this->Street = $userArray['STREET'];
			$this->StreetNumber = $userArray['STREET_NUMBER'];
			$this->Floor = $userArray['FLOOR'];
			$this->FloorUnit = $userArray['FLOOR_UNIT'];
			$this->PersonalID = $userArray['PERSONAL_ID'];
			$this->Gender = $userArray['GENDER'] != '' ? $userArray['GENDER'] : null;
			$this->StreetUnit = $userArray['STREET_UNIT'];
			$this->State = array_key_exists('ADDRESS_STATE', $userArray) ? strtoupper($userArray['ADDRESS_STATE']) : '';
			$this->City = $userArray['CITY'];
        }
    }
		
	public function getWebServiceObject() {
		$this->validateValue('FirstName', $this->FirstName);
		$this->validateValue('LastName', $this->LastName);
		$this->validateValue('City', $this->City);
		$this->validateValue('Zip', $this->Zip);
		$this->validateValue('Email', $this->Email);
		$this->validateValue('Username', $this->Username);
			
		return $this->cleanArray(array(
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
			new dateValueDTO('BIRTHDAY', $this->BirthDay),
			new stringValueDTO('USERNAME', $this->Username),
			new stringValueDTO('STREET', $this->Street),
			new stringValueDTO('STREET_NUMBER', $this->StreetNumber),
			new stringValueDTO('FLOOR', $this->Floor),
			new stringValueDTO('FLOOR_UNIT', $this->FloorUnit),
			new stringValueDTO('PERSONAL_ID', $this->PersonalID),
			new stringValueDTO('GENDER', $this->Gender),
			new longValueDTO('CREDIT_LIMIT', $this->CreditLimit),
			new stringValueDTO('LANGUAGE_CODE', $this->LanguageCode),
			new stringValueDTO('TITLE', $this->Title),
			new dateValueDTO('PERSONAL_ID_EXPIRY_DATE', $this->PersonalExpiryDate),
			new stringValueDTO('PERSONAL_ID_TYPE', $this->PersonalIdType),
			new stringValueDTO('COMMUNICATION_TYPE', $this->CommunicationType),
			new stringValueDTO('STREET_UNIT', $this->StreetUnit),
			new stringValueDTO('VAT_NUMBER', $this->VatNumber),
			new stringValueDTO('ZIP_EXTENSION', $this->ZipExtension),
			new stringValueDTO('STATE', strtoupper($this->State)),
			new stringValueDTO('STREET_DIRECTION', $this->StreetDirection),
			new stringValueDTO('PASSWORD', $this->Password)
		));
	}
}