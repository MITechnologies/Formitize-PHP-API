<?php 

namespace Formitize\API\Helper\Job;

class Form
{
	public $formID = 0;
	public $objectlist = array();
	
	function prepareForJobSubmission()
	{
		$prepare = array();
		
		
		foreach($this->objectlist as $var)
		{
			foreach($this->$var as $rc => $sh)
			{
				foreach($sh->objectlist as $obj)
				{
					$prepare[$sh->$obj->getObjectName()][$rc] = $sh->$obj->getValue();
					
				}
			}	
		}
		
		return $prepare;
		
	}
}
?>