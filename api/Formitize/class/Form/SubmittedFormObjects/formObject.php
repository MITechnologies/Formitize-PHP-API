<?php 

namespace Formitize\Form\SubmittedFormObjects;

/**
 * 
 * @author dimitriadamou
 *
 */
class formObject
{
	public $id = 0;
	public $repeatedCount = 0;
	public $type = "";
	public $objectname = "";
	
	abstract function getValue();
	abstract function setValue();
}

?>