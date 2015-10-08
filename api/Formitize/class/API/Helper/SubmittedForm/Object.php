<?php 

namespace Formitize\API\Helper\SubmittedForm;


	abstract class Object extends ObjectAbstract
	{
		public $parent = null;

		function __construct(&$parent)
		{
			$this->parent = $parent;
		}
				
		abstract function setValue($value);
		abstract function getValue();
		abstract function getObjectName();
		abstract function getObjectType();
	}
?>