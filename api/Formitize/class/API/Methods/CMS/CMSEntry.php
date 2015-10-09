<?php 

namespace Formitize\API\Methods\CMS;

class CMSEntry
{
	private $data = array();
	
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