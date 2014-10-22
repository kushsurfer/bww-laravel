<?php

namespace NomadicBits\CDRatorSoapClient\Type;

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
