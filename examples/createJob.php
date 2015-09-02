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
	
	//only need to run this once as it will create source files under Formitize/Class/Job/Form/Form{$formID}/ - comment out after first run.
	Formitize\API\Helper\Helper::createFormJobHeader($client, $formID);
	
	$form = new \Formitize\Job\Form\Form10355\Form();
	$form->get_subheaderDetails()->clientName->setValue("Test Name");

	$form->get_subheaderFieldTest()->formDate_1->setValue(date("Y-m-d", strtotime("+1 week"))) //you can chain setValue	
								   ->formLocation_1->setValue("TestLocation")
								   ->formCheckbox_1->setValue("Test Value A", "Test Value B", "Test Value C");
	
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