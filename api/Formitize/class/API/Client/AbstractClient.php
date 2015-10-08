<?php 
namespace Formitize\API\Client;

abstract class AbstractClient
{

	const SERVER = "https://service.formitize.com.au/";

	abstract function get($url, $data = array());
	abstract function post($url, $data = array());
	abstract function delete($url, $data = array());
		

	private $cls = array();
	
	private function returnClass($class, $obj)
	{
		if(!isset($this->cls[$class]))
			$this->cls[$class] = new $class($obj);
	
		return $this->cls[$class];
	}
	
	/**
	 *
	 * @return \Formitize\API\Methods\Form\Form
	 */
	public function Form()
	{
		return $this->returnClass("\Formitize\API\Methods\Form\Form", $this);
	}

	/**
	 *
	 * @return \Formitize\API\Methods\Form\SubmittedForm
	 */
	
	public function SubmittedForm()
	{
		return $this->returnClass("\Formitize\API\Methods\Form\SubmittedForm", $this);
	}	
	
	/**
	 *
	 * @return \Formitize\API\Methods\Job\Job
	 */
	public function Job()
	{
		return $this->returnClass("\Formitize\API\Methods\Job\Job", $this);
	}
		
	/**
	 * 
	 * @return \Formitize\API\Methods\Tool\Notification
	 */
	public function Notification()
	{
		return $this->returnClass("\Formitize\API\Methods\Tool\Notification", $this);
	}	
	
	/**
	 *
	 * @return \Formitize\API\Methods\Webhook\SubmittedForm
	 */
	public function Webhooks()
	{
		return $this->returnClass("\Formitize\API\Methods\Webhooks\Webhook", $this);
	}
		
}
?>