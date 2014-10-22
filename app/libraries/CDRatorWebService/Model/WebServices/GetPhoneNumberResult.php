<?php

namespace NomadicBits\CDRatorWebService\Model\WebServices;
use BeSimple\SoapBundle\ServiceDefinition\Annotation as Soap;

use NomadicBits\CDRatorWebService\Model\WebServices\BaseResult;

class GetPhoneNumberResult extends BaseResult
{
    /**
     * @Soap\ComplexType("float")
     */
    public $balance;
    /**
     * @Soap\ComplexType("string")
     */
    public $brand = '';

    public function setBalance($balance) {
        $this->balance = $balance;
    }

    public function setBrand($brand) {
        $this->brand = $brand;
    }
}