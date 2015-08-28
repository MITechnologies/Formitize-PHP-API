<?php 

namespace Formitize\Form\SubmittedFormObjects;

/**
 * 
 * @author dimitriadamou
 *
 */
class formMultiple extends formObject
{
	public $type = "formMultiple";
	public $value = array();
	
	function setValue($key, $val)
	{
		$this->value[$key] = $val;
	}
	
	function getValue($key)
	{
		return $this->value[$key];
	}
}



?>