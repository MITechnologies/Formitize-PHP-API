<?php 

namespace Formitize\API\Methods\CMS;

class CMSEntry
{
	private $data = array();
	
	function __construct($d = array()) 
	{
		$this->data = $d;
	}
	
	public function setValue($key, $val)
	{
		$this->data[$key] =  $val;
		
		return $this;
	}
	
	
	public function getData()
	{
		return $this->data;
	}
	
}
?>