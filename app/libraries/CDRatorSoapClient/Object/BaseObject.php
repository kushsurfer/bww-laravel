<?php

namespace NomadicBits\CDRatorSoapClient\Object;

use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

class BaseObject
{
	public $ObjectArray;
			
	function validateValue($key, $value) {
		if (!isset($key)) {
			throw new \Exception('"Key" must be set');
		}
		if (!isset($value)) {
			throw new \Exception(sprintf('"%s" must be set', $key));
		}
	}
	
	function cleanArray(array $objects) {
		$objectArray = array();
		
		foreach($objects as $curObject) {
			if (isset($curObject->value)) {
				$objectArray[] = $curObject;
			}
		}
		return $objectArray;
	}
}