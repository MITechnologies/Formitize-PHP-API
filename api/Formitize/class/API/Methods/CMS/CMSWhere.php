<?php 

namespace Formitize\API\Methods\CMS;

class CMSWhere
{
	private $data = array();
	
	const SEARCH_CONTAINS = "contain";
	const SEARCH_EQUAL = "equal";
	const SEARCH_NOTEQUAL = "notequal";
	
	/**
	 * If left as 0, will use other search terms instead.
	 */
	public $id = 0;
	
	public function addCriteria($key, $value, $searchType = self::SEARCH_EQUAL)
	{
		$this->data[$key] =  array("value" => $value, "search" => $searchType);
		
		return $this;
	}
	
	
	public function getData()
	{
		return array("id" => $this->id) + $this->data;
	}
	
}
?>