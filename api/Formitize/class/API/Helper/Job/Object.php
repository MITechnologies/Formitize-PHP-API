<?php 

namespace Formitize\API\Helper\Job;


	abstract class Object extends ObjectAbstract
	{
		abstract function setValue($value);
		abstract function getValue();
		abstract function getObjectName();
		abstract function getObjectType();
	}
?>