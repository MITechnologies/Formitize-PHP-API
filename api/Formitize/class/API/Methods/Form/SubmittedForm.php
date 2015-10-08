<?php 

namespace Formitize\API\Methods\Form;

class SubmittedForm extends \Formitize\API\Methods\AbstractAPI
{
	function create()
	{
		
	}
	
	function updateAnswers()
	{
		
	}
	
	function getAnswers()
	{
		
	}
	
	/**
	 * 
	 * @param unknown $submittedFormID - the submitted form ID for which reports to grab. Can provide an array for up to 50 elements.
	 * @param string $report if left blank, will retrieve link to all available reports.
	 */
	function getReport($submittedFormID, $report = "")
	{
		if(is_array($submittedFormID))
			$submittedFormID = join(",", $submittedFormID);
			
		return $this->client->get("form/submit/report/", array(
			"id" => $submittedFormID,
			"report" => $report	
		));
	}
	
	function getReportList($submittedFormID)
	{
		
	}
	
	function getList($page = 1, SubmittedFormListOptions $opts = null)
	{
		$params = array("simple" => true, "page" => $page);
		
		if(!is_null($opts))
		{
			$params += $opts->getOptions();
			
		}
		
		return $this->client->get("form/submit/list/", $params);
		
	}
}

?>