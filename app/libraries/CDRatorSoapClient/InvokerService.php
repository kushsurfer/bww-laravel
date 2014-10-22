<?php

namespace NomadicBits\CDRatorSoapClient;
use Symfony\Component\Debug\Exception\ContextErrorException;

/**
 * 
 */
class InvokerService extends \SoapClient
{

  /**
   * 
   * @var array $classmap The defined classes
   * @access private
   */
  private static $classmap = array(
    'executeMethod' => 'NomadicBits\CDRatorSoapClient\executeMethod',
    'requestDTO' => 'NomadicBits\CDRatorSoapClient\Type\requestDTO',
    'valueDTO' => 'NomadicBits\CDRatorSoapClient\Type\valueDTO',
    'dateValueDTO' => 'NomadicBits\CDRatorSoapClient\Type\dateValueDTO',
    'complexValueDTO' => 'NomadicBits\CDRatorSoapClient\Type\complexValueDTO',
    'stringValueDTO' => 'NomadicBits\CDRatorSoapClient\Type\stringValueDTO',
    'longValueDTO' => 'NomadicBits\CDRatorSoapClient\Type\longValueDTO',
    'doubleValueDTO' => 'NomadicBits\CDRatorSoapClient\Type\doubleValueDTO',
    'floatValueDTO' => 'NomadicBits\CDRatorSoapClient\Type\floatValueDTO',
    'booleanValueDTO' => 'NomadicBits\CDRatorSoapClient\Type\booleanValueDTO',
    'executeMethodResponse' => 'NomadicBits\CDRatorSoapClient\executeMethodResponse',
    'responseDTO' => 'NomadicBits\CDRatorSoapClient\Type\responseDTO');

  /**
   * 
   * @param array $config A array of config values
   * @param string $wsdl The wsdl file to use
   * @access public
   */
  public function __construct(array $options = array(), $wsdl = 'http://172.21.40.101:8080/workflow-soap/InvokerService?wsdl') //TODO: make WSDL endpoint configurable from config file
  {
    foreach(self::$classmap as $key => $value)
    {
      if(!isset($options['classmap'][$key]))
      {
        $options['classmap'][$key] = $value;
      }
    }
    
    try {
        parent::__construct($wsdl, $options);
    } catch (\SoapFault $e) {
        throw new \Exception(sprintf('No connection to webservice at: %s', $wsdl));
    } catch (\Exception $e) {
        throw new \Exception(sprintf('No connection to webservice at: %s', $wsdl));
    }
  }

  /**
   * 
   * @param executeMethod $parameters
   * @access public
   */
  public function executeMethod(executeMethod $parameters)
  {
    return $this->__soapCall('executeMethod', array($parameters));
  }

}
