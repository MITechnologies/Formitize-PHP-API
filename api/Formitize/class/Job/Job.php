<?php 

namespace Formitize\Job;

/**
 * 
 * @author dimitriadamou
 *
 */
class Job
{
	
	const PRIORITY_NORMAL = "Normal";
	const PRIORITY_MEDIUM = "Medium";
	const PRIORITY_HIGH = "High";
	const PRIORITY_URGENT = "Urgent";	
	
	public $id = 0;
	public $Title = "";
	public $JobNumber = "";
	public $OrderNumber = "";
	public $Notes = "";
	public $Agent = "";
	public $Priority = self::PRIORITY_NORMAL;
	public $Location = "";
	public $SendNotificaiton = true;
	public $Duration = 1;
	
	/**
	 * Add to this array (key => value dictionary) and this response will be returned to you if you have WebHook Notifications set up for once this Job has been completed on Formitize.
	 */
	public $HookData = array();
	
	

	private $AttachedForms = array();
	
	
	public $Common = array();
	
	/**
	 * DueDate is stored as UNIX TIMESTAMP, can include the DueTime aswell. Use setDueDate to properly set the date.
	 * 
	 * @var int
	 */
	public $DueDate = 0;
	
	public $Forms = array();
	
	public function __construct()
	{
		$this->DueDate = strtotime("now");
	}
	
	public function setDueDate($date)
	{
		if(!is_numeric($date))
			$date = strtotime($date);
		
		$this->DueDate = $date;
	}
	
	public function addFormID($formID)
	{
		$this->Forms[$formID] = $formID;
	}
	
	public function attachJobForm(\Formitize\API\Helper\Job\Form &$form)
	{
		//attach these and process when request to send, to keep data up to date.
		if(isset($this->AttachedForms[$form->formID]))
		{
			throw new \Exception("Form ID " . $form->formID . " is already attached.");	
		}
		
		$this->AttachedForms[$form->formID] = $form;
	}
	
	public function removeFormID($formID)
	{
		unset($this->Forms[$formID]);
	}
	
	public function attachCommonData($objectName, $value, $repeatedCount = 0)
	{
		if(!isset($this->Common[$objectName]))
			$this->Common[$objectName] = array();
		
		$this->Common[$objectName][$repeatedCount] = $value;
	}
	
	public function getData()
	{
		$fd = array("Common" => $this->Common);
		
		
		foreach($this->AttachedForms as $formID => $attached)
		{
			$this->Forms[$formID] = $formID;
			
			$fd[$formID] = $attached->prepareForJobSubmission();
		}
		
		
		return array(
			"id" => $this->id,
			"Title" => $this->Title,
			"JobNumber" => $this->JobNumber,
			"OrderNumber" => $this->OrderNumber,
			"Agent" => $this->Agent,
			"SendNotification" => $this->SendNotificaiton,
			"Priority" => $this->Priority,
			"Form" => $this->Forms,
			"FormData" => $fd,
			"DueDate" => date("Y-m-d H:i:s", $this->DueDate),
			"Duration" => $this->Duration
		);
	}
}



?>