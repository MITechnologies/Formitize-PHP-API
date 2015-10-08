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
}



?>