<?php

namespace NomadicBits\CDRatorSoapClient\Action;

use NomadicBits\CDRatorSoapClient\Type\booleanValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\Type\dateValueDTO;
use NomadicBits\CDRatorSoapClient\Type\doubleValueDTO;
use NomadicBits\CDRatorSoapClient\Type\longValueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;

use NomadicBits\CDRatorSoapClient\Type\requestDTO;
use NomadicBits\CDRatorSoapClient\Type\responseDTO;

use NomadicBits\CDRatorSoapClient\InvokerService;
use NomadicBits\CDRatorSoapClient\executeMethod;
use NomadicBits\CDRatorSoapClient\executeMethodResponse;

use Symfony\Component\HttpFoundation\Session\Session;

abstract class BaseAction
{
	protected $SoapAction = null;
	public $Values = array();
	private $_SoapResponse = null;
    private $_service = null;
    const SOAP_CONTEXT = 'SOAP_CONTEXT';
    protected $wsdlUrl = null;
		
	private function getContext() { //TODO: Get values from configuration file
        $context = array(
            new stringValueDTO('LANGUAGE', 'EN'),
            new stringValueDTO('OPERATOR', 'SOAP'),
            new stringValueDTO('PASSWORD', 'SOAP'),
            new stringValueDTO('BRAND_KEY', 'BWWTEST')
        );
		
		return new complexValueDTO('CONTEXT', $context);
	}
	
	function validateValue($key, $value) {
		if (!isset($value)) {
			throw new \Exception(sprintf('"%s" must be set', $key));
		}
	}

    function dumpRawResponse() {
        echo "<pre>";
        print_r($this->_SoapResponse);
        echo "</pre>";
    }
	
	function getLastSoapResponse() {
		return $this->_SoapResponse;
	}

    function getLastRequest() {
        if ($this->_service != null) {
            return $this->_service->__getLastRequest();
        }

    }
	
	abstract protected function prepareRequest();
	
	function sendRequest() {
		$this->Values[] = $this->getContext();
		
		$request = new requestDTO(
			$this->SoapAction,
			$this->cleanArray($this->Values)
		);

        $timeout = 15;

        ini_set('default_socket_timeout', $timeout);
		
		$options = array('trace' => 1, 'connection_timeout' => $timeout, 'exception' => true); //TODO: Only when environment is dev
        if (!is_null($this->wsdlUrl)) {
            $this->_service = new InvokerService($options, $this->wsdlUrl);
        } else {
            $this->_service = new InvokerService($options);
        }

		
		$execMethod = new executeMethod($request);
		
		try {
			$this->_SoapResponse = $this->_service->executeMethod($execMethod);
			
			// echo 'Request : <br/><xmp>'. $this->_service->__getLastRequest(). '</xmp><br/><br/> Error Message : <br/>';
			// var_dump($this->_SoapResponse->return);
			//return $response->return;
			return $this->convertResponse($this->_SoapResponse->return);
		} catch (\SoapFault $excp) {
			// echo 'Request : <br/><xmp>',
   //              $this->_service->__getLastRequest(),
			//   '</xmp><br/><br/> Error Message : <br/>', 
			 return array('errorCode' => $excp->getMessage()); 

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
	
	public function convertResponse($response) {
		$convertedArray = array();
		
		/*echo "<pre>";
		print_r($response);
		echo "</pre>";*/
		$convertedArray['errorCode'] = $response->errorCode;
		$convertedArray['errorMessage'] = $response->errorMessage;
		$convertedArray['status'] = $response->status;
		
		if (is_array($response->values)) {
			foreach($response->values as $curValue) {
				if (is_object($curValue) ){
					if ($this->getObjectType($curValue) == 'complexValueDTO') {
						$array = $this->convertChild($curValue);
						$key = $this->getArrayKey($convertedArray, $curValue->key);
						if (!isset($array)) {
							$convertedArray[$key] = null;
						} else if (array_key_exists($curValue->key, $array)) {
							$convertedArray[$key] = $array[$curValue->key];	
						} else {
							$convertedArray[$key] = $array;
						}
						 
					} else {
						$convertedArray[$curValue->key] = $curValue->value;
					}
				}	
			}	
		}
		
		/*echo "<pre>";
		print_r($convertedArray);
		echo "</pre>";*/
		
		return $convertedArray;
	}
	
	public function convertChild($object) {
		$childArray = array();
		
		if (is_object($object))	{
			if (is_object($object->value)) {
				if ($this->getObjectType($object->value) == 'complexValueDTO') {
					$childArray[$object->key] = $this->convertChild($object->value);
					return $childArray[$object->key];
				} else {
					$childArray[$object->value->key] = $object->value->value;
					return $childArray;
				}	
			} else if (is_array($object->value)) {
				$childArray[$object->key] = $this->convertChild($object->value);
				return $childArray;
			} else {
				$childArray[$object->key] = $object->value;
				return $childArray[$object->key];
			}
		} else if (is_array($object)) {
			foreach($object as $curValue) {
				if (is_object($curValue)) {
					$key = $this->getArrayKey($childArray, $curValue->key);
					if ($this->getObjectType($curValue) == 'complexValueDTO') {
						$array = $this->convertChild($curValue);
						if (is_array($array) && key_exists($curValue->key, $array)) {
							$childArray[$key] = $array[$curValue->key];	
						} else {
							$childArray[$key] = $array;
						}
						
					} else {
						$childArray[$key] = $curValue->value;
					}
				} else if (is_array($curValue)) {
					$childArray[$curValue->key] = $this->convertChild($curValue);
				}
			}
		}
		
		return $childArray;
	}

	public function getArrayKey($array, $key) {
		if (!array_key_exists($key, $array)) {
			return $key;
		}
		
		$index = 1;	
		while (array_key_exists($key."_".$index, $array)) {
			$index++;
		}
		return $key."_".$index;
	}
	
	public function getObjectType($object) {
		$fullObjectNameParts = explode('\\', get_class($object));
		$objectName = $fullObjectNameParts[count($fullObjectNameParts) - 1];
		return $objectName;
	}
}