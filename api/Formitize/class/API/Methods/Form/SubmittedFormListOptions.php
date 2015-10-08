<?php 
namespace Formitize\API\Methods\Form;

class SubmittedFormListOptions extends \Formitize\API\Methods\AbstractOptions
{
	
	function setTitle($value, $searchType = self::SEARCH_CONTAIN)
	{
		$this->setOption('title', $value);
		$this->setOption('titlesearch', $searchType);
	}
	
	
	/**
	 * 
	 * @param array $ids - an array of form IDs
	 */
	function setFormID(array $ids, $searchType = self::SEARCH_EQUAL)
	{
		$this->setOption('formsearch', $value);
	}

	function setCreatedAfterDate($date)
	{
		if(!is_numeric($date)) $date = strtotime($date);
	
		$this->setOption("createdAfterDate", $date);
	}

	function setModifiedAfterDate($date)
	{
		if(!is_numeric($date)) $date = strtotime($date);
	
		$this->setOption("modifiedAfterDate", $date);
	}
	
	
	function setIDOrder($sort)
	{
		switch(strtolower($sort))
		{
			case 'desc':
				$this->setOption("idorder", "desc");
				break;
			default:
				$this->setOption("idorder", "asc");
				break;
				
		}
	}
	
	function __construct()
	{
		$this->setIDOrder("desc");
	}
}

?>