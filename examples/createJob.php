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
	
	$formID = 0;
	
	if($formID == 0) throw new Exception("Please grab the formID from the Formitize website and replace here.");
	
	//only need to run this once as it will create source files under Formitize/Class/Job/Header/Form{$formID}/ - comment out after first run.
	
	Formitize\API\Helper\Helper::createFormJobHeader($client, $formID);
	$ns = "Formitize\Job\Header\Form{$formID}\Form{$formID}";
	$form = new $ns();
	
	$newJob = new Formitize\Job\Job();

	$newJob->Title = "Test";
	$newJob->Agent = USER_NAME;
	$newJob->JobNumber = "123";
	$newJob->OrderNumber = "456";
	$newJob->Location = "123 Test St, Test Suburb";
	$newJob->Notes = "Some notes for the agent.";
	$newJob->Priority = $newJob::PRIORITY_HIGH;
	
	
	$newJob->attachJobForm($form);
	$newJob->setDueDate("05th Sep 2015 15:00"); //can be in any format as long as it can be intrepetted into UNIX_TIMESTAMP.
	$newJob->Duration = 2.5;

	
	$results = $client->Job()->createJob($newJob);
	
	
	print_r($results);
?>