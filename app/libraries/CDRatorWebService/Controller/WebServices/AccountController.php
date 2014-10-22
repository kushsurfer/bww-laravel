<?php
namespace NomadicBits\CDRatorWebService\Controller\WebServices;

use BeSimple\SoapBundle\ServiceDefinition\Annotation as Soap;
use Symfony\Component\DependencyInjection\ContainerAware;
use NomadicBits\CDRatorSoapClient\Action\GetWebUserProfileInternal;

use NomadicBits\CDRatorWebService\Model\WebServices\GetPhoneNumberResult;

class AccountController extends ContainerAware
{
    /**
     * @Soap\Method("getPhoneNumber")
     * @Soap\Param("password", phpType = "string")
     * @Soap\Param("phoneNumber", phpType = "string")
     * @Soap\Result(phpType = "NomadicBits\CDRatorWebService\Model\WebServices\GetPhoneNumberResult")
     */
    public function getPhoneNumberAction($password, $phoneNumber)
    {
        $getPhoneNumberResult = new GetPhoneNumberResult();
        if ($password == 'migentemobile123!') {
            $getWebUserRequest = new GetWebUserProfileInternal();
            //$getWebUserRequest->CustomerNumber = $phoneNumber;
            $getWebUserRequest->PhoneNumber = $phoneNumber;
            $response = $getWebUserRequest->executeRequest();

            if ($response['errorCode'] == '0') {
                $getPhoneNumberResult->setErrorCode(0);
                $getPhoneNumberResult->setErrorMessage('SUCCESS');
                $getPhoneNumberResult->setBalance(sprintf('%01.2f', $response['ACCOUNT']['BILLING_GROUPS']['BILLING_GROUP']['BALANCE']));
                $getPhoneNumberResult->setBrand('Migente');
            } else {
                $getPhoneNumberResult->setErrorCode(-1);
                $getPhoneNumberResult->setErrorMessage(sprintf('Account with phonenumber %s not found', $phoneNumber));
                $getPhoneNumberResult->setBalance(-1);
                //$getPhoneNumberResult->setBrand('test');
            }
        } else {
            $getPhoneNumberResult->setErrorCode(-1);
            $getPhoneNumberResult->setErrorMessage('Password incorrect');
            $getPhoneNumberResult->setBalance(-1);
            //$getPhoneNumberResult->setBrand('test');
        }
        return $getPhoneNumberResult;
    }
}