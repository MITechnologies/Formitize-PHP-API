<?php 	


	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	require 'config.local.php';
	require '../api/Formitize/autoload.inc.php';
	
	$cred = Formitize\API::CreateCredentials();
	
	$client = Formitize\API::RESTClient($cred);
	
	$cred->setCompanyName(USER_COMPANY);
	$cred->setUserName(USER_NAME);
	$cred->setPassword(USER_PW);

	$formID = 10355;
	
	if($formID == 0) throw new Exception("Please grab the formID from the Formitize website and replace here.");
	
	//This creates Header Files for the specified form ID
	Formitize\API\Helper\Helper::createFormJobHeader($client, $formID);
?>