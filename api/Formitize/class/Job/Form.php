<?php
namespace Formitize\Job;

class Form
{
	public $formID = 0;
	public $Data = array();
	
	function __construct($formID)
	{
		$this->formID = $formID;
	}
	
	/**
	 * 
	 * @return \Formitize\Job\Form\Form
	 */
	function setValue($index, $objectName, $value)
	{
		if(is_array($value)) $value = join(",", $value);
		
		if(!isset($this->Data[$objectName])) $this->Data[$objectName] = array();
		
		$this->Data[$objectName][$index] =  $value;
		
		return $this;
		
		
	}


}

?>