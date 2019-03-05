<?php 	


	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	require 'config.local.php';
	require '../api/Formitize/autoload.inc.php';
	
	$cred = Formitize\API::CreateCredentials();
	
	$cred->setCompanyName(USER_COMPANY);
	$cred->setUserName(USER_NAME);
	$cred->setPassword(USER_PW);
	
	$client = Formitize\API::RESTClient($cred);
	
	$req = new \Formitize\Job\GetJobRequest();
	//$req->setJobNumber("xxx"); //search by job number.
	$results = $client->Job()->getJobs($req);
	
?>