<?php

namespace NomadicBits\CDRatorSoapClient\Type;

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
