<?php

namespace NomadicBits\CDRatorSoapClient\Type;

class doubleValueDTO extends valueDTO
{

  /**
   * 
   * @var float $value
   * @access public
   */
  public $value;

  /**
   * 
   * @param float $value
   * @access public
   */
  public function __construct($key, $value)
  {
   	$this->key = $key; 	
    $this->value = $value;
  }

}
