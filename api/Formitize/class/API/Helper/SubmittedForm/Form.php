<?php 

namespace Formitize\API\Helper\SubmittedForm;

class Form
{
	public $formID = 0;
	public $objectlist = array();
	
	function prepareForSubmission()
	{
		$prepare = array();
		
		
		foreach($this->objectlist as $var)
		{
			foreach($this->returnArray($var) as $rc => $sh)
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