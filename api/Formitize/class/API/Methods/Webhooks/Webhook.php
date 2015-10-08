<?php 

namespace Formitize\API\Methods\Webhooks;

class Webhook extends \Formitize\API\Methods\AbstractAPI
{
	/**
	 * Will create a webhook, on error will return typical error message - can catch with the Exception class.
	 * On successful return the JSON will look like {"id": "1234"}
	 * @param string $endpoint - the URL endpoint that will 
	 * @param int $formid - the Form ID, if left 0 then every submitted form will go to this end-point.
	 * @throws Formitize\API\Exception\Exception
	 */
	function createWebhook( $endpoint, $formID = 0 )
	{
		return $this->client->post("/webhooks/submittedforms/", array("endpoint" => $endpoint, "formID" => $formID));
	}
	
	/**
	 * Will list all webhooks, responses will look like this.
	 * {"123": {"id": "123", "url": "http://../", "formID": "345"}, "125": {"id": "125", "url": "http://../", "formID":"345"}}
	 * @param number $formID - if left as 0, will list all webhooks, otherwise will only list webhooks for this form.
	 */
	function listWebhooks($formID = 0)
	{
		return $this->client->get("/webhooks/submittedforms/list/{$formID}/", array());
	}
	
	/**
	 * This function will test a webhook. If there are no available submitted forms, it will send a made up one.
	 * @param int $webhookID - returned from either listWebhooks or createWebhook
	 * @throws Formitize\API\Exception\Exception
	 */
	function submitTest($webhookID)
	{
		return $this->client->get("/webhooks/submittedforms/{$webhookID}/test/", array());		
	}
}


?>