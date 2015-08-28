<?php 
namespace Formitize;
	
class API
{
	/**
	 * 
	 * @var \Formitize\API\Credentials
	 */
	private static $credentials = null;
	
	/**
	 * 
	 * @param \Formitize\API\Credentials $credentials
	 * @return \Formitize\API\Client\Rest
	 */
	static function RESTClient(\Formitize\API\Credentials $credentials)
	{
		$REST = new \Formitize\API\Client\Rest($credentials);
		return $REST;
	}
	
	/**
	 * 
	 * @return \Formitize\API\Credentials
	 */
	static function CreateCredentials()
	{
		self::$credentials = new \Formitize\API\Credentials();
		
		return self::$credentials;
		
	}
}

?>