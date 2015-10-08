<?php 
namespace Formitize\API\Methods;

class AbstractOptions
{
	const SEARCH_CONTAIN = "contain";
	const SEARCH_DOESNT_CONTAIN = "ncontain";
	const SEARCH_EQUAL = "equal";
	const SEARCH_NOTEQUAL = "nequal";
	
	private $options = array();
	
	function setOption($key, $value)
	{
		$this->options[$key] = $value;
	}
	
	function getOption($key)
	{
		if(isset($this->options[$key]))
			return $this->options[$key];
		
		return false;
	}
	
	function getOptions()
	{
		return $this->options;
	}
}
?>