<?php

namespace NomadicBits\CDRatorSoapClient;

class executeMethodResponse
{

  /**
   * 
   * @var responseDTO $return
   * @access public
   */
  public $return;

  /**
   * 
   * @param responseDTO $return
   * @access public
   */
  public function __construct($return)
  {
    $this->return = $return;
  }

}
