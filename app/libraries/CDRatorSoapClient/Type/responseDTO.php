<?php

namespace NomadicBits\CDRatorSoapClient\Type;

class responseDTO
{

  /**
   * 
   * @var int $errorCode
   * @access public
   */
  public $errorCode;

  /**
   * 
   * @var string $errorMessage
   * @access public
   */
  public $errorMessage;

  /**
   * 
   * @var int $status
   * @access public
   */
  public $status;

  /**
   * 
   * @var valueDTO $values
   * @access public
   */
  public $values;

  /**
   * 
   * @param int $errorCode
   * @param string $errorMessage
   * @param int $status
   * @param valueDTO $values
   * @access public
   */
  public function __construct($errorCode, $errorMessage, $status, $values)
  {
    $this->errorCode = $errorCode;
    $this->errorMessage = $errorMessage;
    $this->status = $status;
    $this->values = $values;
  }

}
