<?php

namespace NomadicBits\CDRatorSoapClient\Type;

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
