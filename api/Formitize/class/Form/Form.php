<?php 

namespace Formitize\Form;

/**
 * 
 * @author dimitriadamou
 *
 */
class Form
{
	private $form;
	
	function loadFromString($string)
	{
		$this->form = json_decode($string, true);
					
	}
	
	function loadFromID($id, $company, $username, $password)
	{
		
	}
}



?>