<?php 
namespace Formitize\API\Client;

/**
 * 
 * @author dimitriadamou
 *
 */
class REST extends AbstractClient
{


	const VERSION = "v1";	
	
	/**
	 * 
	 * @var \Formitize\API\Transport\AbstractTransport
	 */
	private $Transport = null;
	
	function __construct(\Formitize\API\Credentials $Credentials, $Transport = "CURL")
	{
		$str = "\\Formitize\\API\\Transport\\{$Transport}";
		
		$this->Transport = new $str($Credentials);	
	}
	
	private function getBaseURL()
	{
		return self::SERVER . 'api/rest/' . self::VERSION . '/';
	}
	
	/**
	 * 
	 * @param unknown $url
	 * @return string
	 */
	
	function getURL($url)
	{
		return $this->getBaseURL() . $url;
	}
	
	private function validateResponse($resp)
	{

		$parsedresp = json_decode($resp, true);
		
		
		if($parsedresp == false)
		{
			echo $resp;
			die();
		}

		if(isset($parsedresp['error']))
		{
			throw new \Formitize\API\Exception\Exception($parsedresp['error']['message'], $parsedresp['error']['code']);
		}
		
		
		return $parsedresp;
	}
	
	function get($url, $data = array())
	{
		return $this->validateResponse($this->Transport->get($this->getURL($url), $data));
	}
	
	
	function post($url, $data = array())
	{
		return $this->validateResponse($this->Transport->post($this->getURL($url), $data));
	}
	
	function delete($url, $data = array())
	{
		return $this->validateResponse( $this->Transport->delete($this->getURL($url), $data) );
	}
}

?>