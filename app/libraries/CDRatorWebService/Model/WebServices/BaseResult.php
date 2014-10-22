<?php

namespace NomadicBits\CDRatorWebService\Model\WebServices;

use BeSimple\SoapBundle\ServiceDefinition\Annotation as Soap;

abstract class BaseResult
{
    /**
     * @Soap\ComplexType("int")
     */
    public $errorCode;
    /**
     * @Soap\ComplexType("string")
     */
    public $errorMessage;

    public function setErrorCode($errorCode) {
        $this->errorCode = $errorCode;
    }

    public function setErrorMessage($errorMessage) {
        $this->errorMessage = $errorMessage;
    }
}