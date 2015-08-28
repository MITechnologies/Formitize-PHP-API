<?php 

namespace Formitize\API\Helper\Job;


	abstract class ObjectMultipleChoice extends ObjectAbstract
	{
		abstract function setValue();
		abstract function getValue();
		abstract function getObjectName();
		abstract function getObjectType();
	}
?>