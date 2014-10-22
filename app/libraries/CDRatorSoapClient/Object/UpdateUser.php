<?php

namespace NomadicBits\CDRatorSoapClient\Object;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

use NomadicBits\CDRatorSoapClient\Object\User;

class UpdateUser extends BaseObject implements IBaseObject
{
	private $_ID;
	private $_User;
	
	public function __construct(User $user, $ID) {
        $this->_User = $user;
		$this->_ID = $ID;
    }
	
	public function getWebServiceObject() {
		$userWebServiceObject = $this->_User->getWebServiceObject();
		$userWebServiceObject[] = new stringValueDTO('ID', $this->_ID);
		
		$this->validateValue('UserID', $this->_ID);
		$this->validateValue('FirstName', $this->_User->FirstName);
		$this->validateValue('LastName', $this->_User->LastName);
		$this->validateValue('City', $this->_User->City);
		$this->validateValue('Zip', $this->_User->Zip);
		$this->validateValue('Email', $this->_User->Email);
			
		return $this->cleanArray(array(
			new stringValueDTO('ID', $this->_ID),
			new stringValueDTO('COMPANY', $this->_User->Company),
			new stringValueDTO('FIRST_NAME', $this->_User->FirstName),
			new stringValueDTO('LAST_NAME', $this->_User->LastName),
			new stringValueDTO('ADDRESS2', $this->_User->Address2),
			new stringValueDTO('CITY', $this->_User->City),
			new stringValueDTO('ZIP', $this->_User->Zip),
			new stringValueDTO('COUNTRY', $this->_User->Country),
			new stringValueDTO('PHONE1', $this->_User->Phone1),
			new stringValueDTO('PHONE2', $this->_User->Phone2),
			new stringValueDTO('PHONE3', $this->_User->Phone3),
			new stringValueDTO('FAX', $this->_User->Fax),
			new stringValueDTO('EMAIL', $this->_User->Email),
			new stringValueDTO('EMAIL2', $this->_User->Email2),
			new dateValueDTO('BIRTHDAY', $this->_User->BirthDay),
			new stringValueDTO('STREET', $this->_User->Street),
			new stringValueDTO('STREET_NUMBER', $this->_User->StreetNumber),
			new stringValueDTO('FLOOR', $this->_User->Floor),
			new stringValueDTO('FLOOR_UNIT', $this->_User->FloorUnit),
			new stringValueDTO('PERSONAL_ID', $this->_User->PersonalID),
			new stringValueDTO('GENDER', $this->_User->Gender),
			new longValueDTO('CREDIT_LIMIT', $this->_User->CreditLimit),
			new stringValueDTO('LANGUAGE_CODE', $this->_User->LanguageCode),
			new stringValueDTO('TITLE', $this->_User->Title),
			new dateValueDTO('PERSONAL_ID_EXPIRY_DATE', $this->_User->PersonalExpiryDate),
			new stringValueDTO('PERSONAL_ID_TYPE', $this->_User->PersonalIdType),
			new stringValueDTO('COMMUNICATION_TYPE', $this->_User->CommunicationType),
			new stringValueDTO('STREET_UNIT', $this->_User->StreetUnit),
			new stringValueDTO('VAT_NUMBER', $this->_User->VatNumber),
			new stringValueDTO('ZIP_EXTENSION', $this->_User->ZipExtension),
			new stringValueDTO('STATE', $this->_User->State),
			new stringValueDTO('STREET_DIRECTION', $this->_User->StreetDirection)
		));
	}
}