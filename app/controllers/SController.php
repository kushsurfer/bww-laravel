<?php

use NomadicBits\CDRatorSoapClient\Type\requestDTO;
use NomadicBits\CDRatorSoapClient\Type\valueDTO;
use NomadicBits\CDRatorSoapClient\Type\stringValueDTO;
use NomadicBits\CDRatorSoapClient\Type\complexValueDTO;
use NomadicBits\CDRatorSoapClient\executeMethod;
use NomadicBits\CDRatorSoapClient\executeMethodResponse;
use NomadicBits\CDRatorSoapClient\Action\GetProductConfigs;
use NomadicBits\DemoBundle\Manager\DeviceManager;
use NomadicBits\CDRatorSoapClient\Action\GetOptionsForRatePlan;
use NomadicBits\DemoBundle\Model\SignupCustomerModel;



class SController extends BaseController {

   
    public function testconnection(){

        $optionsForRatePlan = new GetOptionsForRatePlan();
        $optionsForRatePlan->ProductID = '201312240052364157';
        $optionsForRatePlan->RatePlanID = '201312292352141290';
        $response = $optionsForRatePlan->executeRequest();
        echo "<pre>";
        print_r($response);
        echo "</pre>";
    }



    public function demo(){
    	// $session = $this->get('session');

        $formResponse = array();
		$formResponse['response'] = '';
		
		$productKey = 'BWW_Package_Mini'; // plan code ()
		$handsetID = 'SAM-SPHM580';
        $meid = ''; // MEID number for BYOSD


        if ($productKey != null && $handsetID != null) {
            $signupCustomer = new SignupCustomerModel();
        } else {
            $signupCustomer = SignupCustomerModel::getCurrentSignupCustomer($session);
            if ($signupCustomer == null) {
                $signupCustomer = new SignupCustomerModel();
            }
        }

		if ($productKey != null) {
			$productPlan = $signupCustomer->getPackageByKey($productKey);
            $signupCustomer->setProductPlan($productPlan);
		}
		if ($handsetID != null) {
			$signupCustomer->setHandset($handsetID);
		}
        if ($meid != null) {
            $repository = $this->getDoctrine()->getManager()->getRepository('NomadicBitsDemoBundle:ByosdHandset');
            $byosdHandset = $repository->find($handsetID);
            if ($byosdHandset) {
                $signupCustomer->setByosd($meid, $byosdHandset);
            } else {
                ///TODO: What should happen?
            }
        }

    }
}



?>