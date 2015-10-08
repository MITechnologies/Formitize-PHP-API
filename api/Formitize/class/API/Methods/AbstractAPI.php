<?php 
namespace Formitize\API\Methods;

class AbstractAPI
{
	/**
	 * 
	 * @var \Formitize\API\Client\AbstractClient
	 */
	public $client = null;
	
	function __construct(\Formitize\API\Client\AbstractClient $client)
	{
		$this->client = $client;	
	}
}
?>