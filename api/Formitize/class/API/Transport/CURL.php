<?php 
namespace Formitize\API\Transport;
	
class CURL extends AbstractTransport
{
	
	private $curl = null;
	
	public function __construct(\Formitize\API\Credentials $Credentials)
	{
		parent::__construct($Credentials);
	}
	
	private function close()
	{
		
		if($this->curl != NULL)
			curl_close($this->curl);
		
		
		$this->curl = null;
	}
	
	
	private function authenticate($url)
	{

		if($this->curl != null)
		{
			$this->close();
		}
		
		$this->curl = null;
		$this->curl = curl_init($url);
		
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->curl, CURLOPT_HTTPAUTH,  CURLAUTH_BASIC);
		
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
		
		curl_setopt($this->curl, CURLOPT_USERAGENT, $this->credentials->getCompanyName());
		curl_setopt($this->curl, CURLOPT_USERPWD, $this->credentials->getUserName() . ":" . $this->credentials->getPassword());		
		
	}
	
	private function http_build_query_for_curl( $arrays, &$new = array(), $prefix = null ) 
	{
	
		if ( is_object( $arrays ) ) 
		{
			$arrays = get_object_vars( $arrays );
		}
	
		foreach ( $arrays AS $key => $value ) 
		{
			$k = isset( $prefix ) ? $prefix . '[' . $key . ']' : $key;
			if ( is_array( $value ) OR is_object( $value )  ) 
			{
				$this->http_build_query_for_curl( $value, $new, $k );
			} 
			else 
			{
				$new[$k] = $value;
			}
		}
	}
	
	function get($url, $data = array())
	{
		
		$l = array();
		foreach($data as $k=>$v)
			$l[] = "{$k}={$v}";
		
		
		$url .= '?' . join("&", $l);
		
		$this->authenticate($url);
		curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'GET');
				
		$response = curl_exec($this->curl);
		
		$this->close();
		
		
		return $response;
	}
	
	function post($url, $data = array())
	{
		$this->authenticate($url);
		
		$data_string = json_encode($data);
		
		
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen($data_string))
		);
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data_string);
		
		$response = curl_exec($this->curl);
		
		$this->close();
		
		
		return $response;		
	}
	
	function delete($url, $data = array())
	{

	}
}
?>