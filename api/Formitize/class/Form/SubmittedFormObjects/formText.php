<?php 

namespace Formitize\Form\SubmittedFormObjects;

/**
 * 
 * @author dimitriadamou
 *
 */
class formText extends formObject
{
	public $type = "formText";
	public $value = "";
	
	function setValue($val)
	{
		$this->value = $val;
	}
	
	function getValue()
	{
		return $this->value;
	}
}



?>