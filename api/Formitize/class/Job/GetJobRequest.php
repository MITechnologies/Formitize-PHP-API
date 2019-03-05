<?php 

namespace Formitize\Job;

/**
 * 
 * @author dimitriadamou
 *
 */
class GetJobRequest extends \Formitize\API\Methods\Request\Get
{
	function setAgentName($agent)
	{
		$this->params['AgentName'] = $agent;
	}
	
	function setID($id)
	{
		$this->params['id'] = $id;
	}

	function setOrderNumber($orderNumber)
	{
		$this->params['ordernumber'] = $orderNumber;
	}

	function setJobNumber($jobNumber)
	{
		$this->params['jobnumber'] = $jobNumber;
	}
}



?>