<?php 

namespace Formitize\API\Methods\Form;

class Form extends \Formitize\API\Methods\AbstractAPI
{
	function getList($simple = false, $orderByLastModified = false)
	{
		return $this->client->get("form/all/", array("simple" => $simple, "orderByLastModified" => $orderByLastModified));
	}
	
	function getForm($id, $simple = false, $orderByLastModified = false)
	{
		return $this->client->get("form/{$id}/", array("simple" => $simple, "orderByLastModified" => $orderByLastModified));
	}
}
?>