<?php

namespace NomadicBits\CDRatorSoapClient\Type;

class dateValueDTO extends valueDTO
{

  /**
   * 
   * @var dateTime $value
   * @access public
   */
  public $value;

  /**
   * 
   * @param dateTime $value
   * @access public
   */
  public function __construct($key, $value)
  {
   	$this->key = $key; 	
    $this->value = $value;
  }

}
