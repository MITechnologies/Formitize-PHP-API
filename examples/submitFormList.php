<?php 	

	use Formitize\API\Methods\Form\SubmittedFormListOptions;
error_reporting(E_ALL);
	ini_set('display_errors', 1);

	require 'config.local.php';
	require '../api/Formitize/autoload.inc.php';
	
	$cred = Formitize\API::CreateCredentials();
	
	$client = Formitize\API::RESTClient($cred);
	
	$cred->setCompanyName(USER_COMPANY);
	$cred->setUserName(USER_NAME);
	$cred->setPassword(USER_PW);
	
	$options = new SubmittedFormListOptions();
	
	//$options->setModifiedAfterDate(strtotime("-1 month"));

	
	
	$page = 1;
	
	while($data = $client->SubmittedForm()->getList($page, $options))
	{
		
		$keys = array_keys($data);
		
		
		while($list = array_splice($keys, 0, 50))
		{
			
			//we have a list now.
			print_r($client->SubmittedForm()->getReport($list));
		}
		
		
		if(count($data) == 200)
		{
			$page++;
		}
		else 
		{
			break;
		}
		
	}
	
	
	
?>