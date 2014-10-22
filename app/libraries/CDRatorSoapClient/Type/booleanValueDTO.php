<?php

namespace NomadicBits\CDRatorSoapClient\Type;

class  booleanValueDTO extends valueDTO
{

  /**
   * 
   * @var boolean $value
   * @access public
   */
  public $value;

  /**
   * 
   * @param boolean $value
   * @access public
   */
  public function __construct($key, $value)
  {
   	$this->key = $key; 	
    $this->value = $value;
  }

}
