<?php 

namespace Formitize\API\Methods\Tool;

class Notification extends \Formitize\API\Methods\AbstractAPI
{
	function getList($page = 0, $completed = false)
	{
		return $this->client->get("tools/notification/all/", array("completed" => $completed, "page" => $page));
	}
}
?>