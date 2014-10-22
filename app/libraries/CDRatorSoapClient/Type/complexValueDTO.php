<?php

namespace NomadicBits\CDRatorSoapClient\Type;

use NomadicBits\CDRatorSoapClient\Type\valueDTO;

class complexValueDTO extends valueDTO
{

  /**
   * 
   * @var valueDTO $value
   * @access public
   */
  public $value;

  /**
   * 
   * @param valueDTO $value
   * @access public
   */
  public function __construct($key, $value)
  {
   	$this->key = $key; 	
    $this->value = $value;
  }

}
