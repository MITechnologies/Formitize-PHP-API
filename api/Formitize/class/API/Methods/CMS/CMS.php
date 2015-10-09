<?php 

namespace Formitize\API\Methods\CMS;

class CMS extends \Formitize\API\Methods\AbstractAPI
{
	function editEntry($table, CMSEntry $entry, CMSWhere $where = null)
	{
		if($where == null) $where = new CMSWhere();
		
		return $this->client->post(
			"cms/{$table}/entry/",
			array("data" => $entry->getData(), "where" => $where->getData())
		);
		
	}
	function deleteEntry($table, CMSWhere $where)
	{
		if($where == null) $search = new CMSWhere();
		
		return $this->client->delete(
			"cms/{$table}/entry/",
			array("where" => $where->getData())
		);
		
	}
}
?>