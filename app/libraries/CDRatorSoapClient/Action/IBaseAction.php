<?php

namespace NomadicBits\CDRatorSoapClient\Action;

interface IBaseAction {
	/*
	 * Used for preparing the request and validating values
	 */	
	
	function executeRequest(); //Call prepareRequest and then sendRequest
}