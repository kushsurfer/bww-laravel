<?php

namespace NomadicBits\CDRatorSoapClient\Type;

class longValueDTO extends valueDTO
{

  /**
   * 
   * @var int $value
   * @access public
   */
  public $value;

  /**
   * 
   * @param int $value
   * @access public
   */
  public function __construct($key, $value)
  {
   	$this->key = $key; 	
    $this->value = $value;
  }

}
