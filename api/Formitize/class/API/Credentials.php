<?php 

namespace Formitize\API;

class Credentials
{
	private $cname;
	private $username;
	private $pwd;
	private $token = "";
	
	function setCompanyName($companyname)
	{
		$this->cname = $companyname;
	}
	
	function setUserName($username)
	{
		$this->username = $username;
	}
	
	function setPassword($password)
	{
		$this->pwd = $password;		
	}
	
	function getCompanyName()
	{
		return $this->cname;
	}
	
	function getUserName()
	{
		return $this->username;
	}
	
	function getPassword()
	{
		return $this->pwd;
	}
	
	/**
	 * Disabled in this release.
	 */	
	function setToken($token)
	{
		
	}
	
	/**
	 * Disabled in this release.
	 */	
	function setAuthorID($authorID)
	{
		
	}
	
	/**
	 * Disabled in this release.
	 */		
	function requestToken($callbackURL)
	{
		
	}
	
	/**
	 * Disabled in this release.
	 */	
	function requestTokenValidate($authorID, $tokenValidate)
	{
		
	}
	
	/**
	 * Disabled in this release.
	 * @return boolean
	 */
	
	function getToken()
	{
		return false;
	}
}

?>