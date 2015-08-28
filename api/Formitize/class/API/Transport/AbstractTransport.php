<?php 

namespace Formitize\API\Transport;

abstract class AbstractTransport
{
	/**
	 * 
	 * @var \Formitize\API\Credentials
	 */
	public $credentials = null;
	
	function __construct(\Formitize\API\Credentials $Credentials)
	{
		$this->credentials = $Credentials;
	}
	
	abstract function get($url, $data = array());
	abstract function post($url, $data = array());
	abstract function delete($url, $data = array());
	
}

?>