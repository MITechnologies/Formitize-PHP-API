<?php 

namespace Formitize\Form\SubmittedFormObjects;

/**
 * 
 * @author dimitriadamou
 *
 */
class formSubheader extends formObject
{
	public $type = "formSubheader";
	public $children = array();
	
	function getValue()
	{
		return false;
	}
}



?>