<?php


class SoapController {

   
    public function demo(){
       // Create the SoapClient instance 
        $url         = "http://199.83.137.122:8101/workflow-soap/InvokerService?wsdl"; 
        $client     = new SoapClient($url, array("trace" => 1, "exception" => 0)); 
        $Values[] = $this->getContext();
        $parameters = new requestDTO(
            'SOAP_GET_WEB_USER_PROFILE_INTERNAL',
            self::cleanArray($Values)
        );

        $testing = $client->__soapCall('executeMethod', array($parameters));
        var_dump($testing);
    }


    private function getContext() { //TODO: Get values from configuration file
        $context = array(
            new stringValueDTO('LANGUAGE', 'EN'),
            new stringValueDTO('OPERATOR', 'mbinder'),
            new stringValueDTO('PASSWORD', 'mbinder'),
            new stringValueDTO('BRAND_KEY', 'BWWTEST')
        );
        
        return new complexValueDTO('CONTEXT', $context);
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


class requestDTO
{

  /**
   * 
   * @var string $hookpointKey
   * @access public
   */
  public $hookpointKey;

  /**
   * 
   * @var valueDTO $values
   * @access public
   */
  public $values;

  /**
   * 
   * @param string $hookpointKey
   * @param valueDTO $values
   * @access public
   */
  public function __construct($hookpointKey, $values)
  {
    $this->hookpointKey = $hookpointKey;
    $this->values = $values;
  }
}

class valueDTO
{

  /**
   * 
   * @var string $key
   * @access public
   */
  public $key;

  /**
   * 
   * @param string $key
   * @access public
   */
  public function __construct($key)
  {
    $this->key = $key;
  }

}

class stringValueDTO extends valueDTO
{

  /**
   * 
   * @var string $value
   * @access public
   */
  public $value;

  /**
   * 
   * @param string $value
   * @access public
   */
  public function __construct($key, $value)
  {
    $this->key = $key;  
    $this->value = $value;
  }

}



?>