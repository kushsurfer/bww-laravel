<?php

namespace NomadicBits\CDRatorSoapClient\Object;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class CDMAService extends BaseObject implements IBaseObject
{
	private $ProductOptionIDs = array();
	public $OrderID = null;
    public $ProductCode = null;
		
	public function getWebServiceObject() {
		
		$this->validateValue('ORDER_ID', $this->OrderID);
			
		return $this->cleanArray(array(
			new complexValueDTO('PRODUCT_OPTION_IDS', $this->ProductOptionIDs),
			new stringValueDTO('ORDER_ID', $this->OrderID)
		));
	}
	
	public function addProductOptionID($productOptionID) {
		$this->ProductOptionIDs[] = new stringValueDTO('PRODUCT_OPTION_ID', $productOptionID); 
	}
}