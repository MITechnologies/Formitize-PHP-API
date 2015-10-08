<?php 

namespace Formitize\API\Helper;

class Helper
{
	private static function createFriendlyConst($name)
	{
		if($name == '-')
			return 'NA';
		//replace space bars with _
		$name = str_replace(array(" ",".","-", "(",")","/","\\"), "_", $name);
		
		while(strpos($name, "__") !== false)
			$name = str_replace("__","_", $name);
		
		
		//now strip out everything else.
		return preg_replace("/(^(A-Za-z_0-9+))/", "", $name);
		
	}
	
	private static function createFriendlyclass($name)
	{
		return preg_replace("/(^A-Za-z_0-9+)/", "", $name);
	}
	
	/**
	 * This function will create helper headers which will give you visible aid for submitting a particular job request.
	 * 
	 * @param \Formitize\API\Client\AbstractClient $client
	 * @param unknown $formID
	 * @throws \Exception
	 */
	static function createFormJobHeader(\Formitize\API\Client\AbstractClient $client, $formID)
	{
		$elems = $client->Form()->getForm($formID);
		
		
		
		$classes = array();
		
		foreach($elems['elements'] as $subheader)
		{
			$classes[$subheader['name']] = array("type" => "formSubheader", "name" => $subheader['name'], "children" => array());
			
			foreach($subheader['children'] as $question)
			{
				$add = array
				(
					"name" => $question['name'],
					"type" => $question['type'],
				);
				
				if(isset($question['options']))
				{
					$add['options'] = $question['options'];
				}
				
				if(isset($question['children']))
				{
					$add['children'] = array();
					foreach($question['children'] as $rc)
					{
						$add['children'][$rc['name']] = $rc;
					}
				}
				
				$classes[$subheader['name']]['children'][$question['name']] = $add;
			}
		}
		
		//load the template helpers
		$dir = rtrim(str_replace(DIRECTORY_SEPARATOR, '/', realpath(dirname(__FILE__))), '/') . '/Job/HeaderTemplate/';
		
		
		$pos = strpos($dir, "/Formitize/class/");
		
		$store =  substr($dir, 0, $pos) . '/Formitize/class/Job/Form/Form' . $formID . '/';
		
		if(!file_exists($store))
		{
			mkdir($store,0777, true);
			
			if(!file_exists($store))
			{
				throw new \Exception('Unable to create Folder ' . $store . ' - please chmod 0777 ' . $store =  substr($dir, 0, $pos) . '/Job/Header/');
			}
		}
		
		
			
		
		
		$tHeader = file_get_contents($dir . 'header.ptmp');
		$tHeaderFunc = file_get_contents($dir . 'headerFunc.ptmp');
		$tSubheaderClass = file_get_contents($dir . 'subheaderClass.ptmp');
		$tSubheaderVar = file_get_contents($dir . 'subheaderVar.ptmp');
		$tSHChildren = file_get_contents($dir . 'subheaderChildren.ptmp');
		$tSHChildrenMC = file_get_contents($dir . 'subheaderChildrenMC.ptmp');
		$tSHChildrenVar = file_get_contents($dir . 'subheaderClassChildrenVar.ptmp');
		

		$tHeader = str_replace(array("%id%"), $formID, $tHeader);
		$tHeaderFunc = str_replace(array("%id%"), $formID, $tHeaderFunc);
		$tSubheaderClass = str_replace(array("%id%"), $formID, $tSubheaderClass);
		$tSubheaderVar = str_replace(array("%id%"), $formID, $tSubheaderVar);
		$tHeaderFunc = str_replace(array("%id%"), $formID, $tHeaderFunc);
		$tSHChildren = str_replace(array("%id%"), $formID, $tSHChildren);
		$tSHChildrenMC = str_replace(array("%id%"), $formID, $tSHChildrenMC);
		$tSHChildrenVar = str_replace(array("%id%"), $formID, $tSHChildrenVar);
		
		$constructor = array();
		ob_start();
		foreach($classes as $subheader)
		{
			$shClass = self::createFriendlyclass($subheader['name']);
			
			echo str_replace("%subheaderClass%", $shClass, $tSubheaderVar);
			

			$constructor[] = "\t\t" . '$this->' . $shClass . '[0] = new ' . $shClass. '();';
			$list[] = '"' . $shClass . '"';
			
			$tSHCopy = str_replace("%subheaderClass%", $shClass, $tSubheaderClass);
			$children = array();

			$cvar = array();
			$cConstructor = array();
			ob_start();

			$cList = array();
			foreach($subheader['children'] as $children)
			{
				$objClass = self::createFriendlyclass($children['name']);
				$cClass = self::createFriendlyclass($children['name']);
				
				
				switch($children['type'])
				{
					case 'formMultiple':
						$const = array();
					
						
						
						foreach($children['options'] as $option)
						{
							$const[] = "\tconst VALUE_" . self::createFriendlyConst($option) . ' = "' . addslashes($option) . '";';
						}
						
						
						echo str_replace(
							array("%objectType%", "%objectName%", "%objectClass%", "%const%", "%subheaderClass%"),
							array("formMultiple", addslashes($children['name']), $cClass, join("\n", $const), $shClass),
							$tSHChildrenMC);

						$cConstructor[] = "\t\t" . '$this->' . $cClass . ' = new ' . $cClass. '($this);';
						$cList[] = '"' . $cClass . '"';
						
						$cvar[] = str_replace("%objectClass%", $cClass,$tSHChildrenVar);
						break;
					case 'formText':
					case 'formBarcode':
						
						echo str_replace(
								array("%objectType%", "%objectName%", "%objectClass%", "%subheaderClass%"),
								array("formMultiple", addslashes($children['name']), $cClass, $shClass),
								$tSHChildren);
						
						$cConstructor[] = "\t\t" . '$this->' . $cClass . ' = new ' . $cClass. '($this);';
						$cList[] = '"' . $cClass . '"';
						
						
						$cvar[] = str_replace("%objectClass%", $cClass,$tSHChildrenVar);
												
						break;
					default:
				}
				
				
			}
			$cObjects = ob_get_clean();

			$tSHCopy = str_replace(array("%objects%", "%children%", "%construct%", "%list%"), array($cObjects, join("\n", $cvar), join("\n", $cConstructor), join(", ", $cList)), $tSHCopy);
			
			file_put_contents($store . $shClass . ".php", $tSHCopy);
		}
		
		ob_start();
		
		foreach($classes as $subheader)
		{
			$shClass = self::createFriendlyclass($subheader['name']);
			echo str_replace("%subheaderClass%", $shClass, $tHeaderFunc);
		}
		
		$functions = ob_get_clean();
		
		$tHeader = str_replace(array("%subheaders%", "%construct%", "%functions%", "%list%"), array(ob_get_clean(), join("\n", $constructor), $functions, join(", ", $list)), $tHeader);
		
		file_put_contents($store . "Form.php", $tHeader);
		
		
				
		
	}
	
	/**
	 * This function will create helper headers which will give you visible aid for editing or submitted forms.
	 * This seperation will exist between Job And Submitted Forms, once Jobs can handle Photo uploads.
	 *
	 * @param \Formitize\API\Client\AbstractClient $client
	 * @param unknown $formID
	 * @throws \Exception
	 */
	static function createFormSubmittedFormHeader(\Formitize\API\Client\AbstractClient $client, $formID)
	{
		$elems = $client->Form()->getForm($formID);
	
	
	
		$classes = array();
	
		foreach($elems['elements'] as $subheader)
		{
			$classes[$subheader['name']] = array("type" => "formSubheader", "name" => $subheader['name'], "children" => array());
				
			foreach($subheader['children'] as $question)
			{
				$add = array
				(
						"name" => $question['name'],
						"type" => $question['type'],
				);
	
				if(isset($question['options']))
				{
					$add['options'] = $question['options'];
				}
	
				if(isset($question['children']))
				{
					$add['children'] = array();
					foreach($question['children'] as $rc)
					{
						$add['children'][$rc['name']] = $rc;
					}
				}
	
				$classes[$subheader['name']]['children'][$question['name']] = $add;
			}
		}
	
		//load the template helpers
		$dir = rtrim(str_replace(DIRECTORY_SEPARATOR, '/', realpath(dirname(__FILE__))), '/') . '/Job/HeaderTemplate/';
	
	
		$pos = strpos($dir, "/Formitize/class/");
	
		$store =  substr($dir, 0, $pos) . '/Formitize/class/Job/Form/Form' . $formID . '/';
	
		if(!file_exists($store))
		{
			mkdir($store,0777, true);
				
			if(!file_exists($store))
			{
				throw new \Exception('Unable to create Folder ' . $store . ' - please chmod 0777 ' . $store =  substr($dir, 0, $pos) . '/Job/Header/');
			}
		}
	
	
			
	
	
		$tHeader = file_get_contents($dir . 'header.ptmp');
		$tHeaderFunc = file_get_contents($dir . 'headerFunc.ptmp');
		$tSubheaderClass = file_get_contents($dir . 'subheaderClass.ptmp');
		$tSubheaderVar = file_get_contents($dir . 'subheaderVar.ptmp');
		$tSHChildren = file_get_contents($dir . 'subheaderChildren.ptmp');
		$tSHChildrenMC = file_get_contents($dir . 'subheaderChildrenMC.ptmp');
		$tSHChildrenPhoto = file_get_contents($dir . 'subheaderChildrenPhoto.ptmp');
		$tSHChildrenVar = file_get_contents($dir . 'subheaderClassChildrenVar.ptmp');
	
		$tHeader = str_replace(array("%id%"), $formID, $tHeader);
		$tHeaderFunc = str_replace(array("%id%"), $formID, $tHeaderFunc);
		$tSubheaderClass = str_replace(array("%id%"), $formID, $tSubheaderClass);
		$tSubheaderVar = str_replace(array("%id%"), $formID, $tSubheaderVar);
		$tHeaderFunc = str_replace(array("%id%"), $formID, $tHeaderFunc);
		$tSHChildren = str_replace(array("%id%"), $formID, $tSHChildren);
		$tSHChildrenMC = str_replace(array("%id%"), $formID, $tSHChildrenMC);
		$tSHChildrenPhoto = str_replace(array("%id%"), $formID, $tSHChildrenPhoto);
		$tSHChildrenVar = str_replace(array("%id%"), $formID, $tSHChildrenVar);
	
		$constructor = array();
		ob_start();
		foreach($classes as $subheader)
		{
			$shClass = self::createFriendlyclass($subheader['name']);
				
			echo str_replace("%subheaderClass%", $shClass, $tSubheaderVar);
				
	
			$constructor[] = "\t\t" . '$this->' . $shClass . '[0] = new ' . $shClass. '();';
			$list[] = '"' . $shClass . '"';
				
			$tSHCopy = str_replace("%subheaderClass%", $shClass, $tSubheaderClass);
			$children = array();
	
			$cvar = array();
			$cConstructor = array();
			ob_start();
	
			$cList = array();
			foreach($subheader['children'] as $children)
			{
				$objClass = self::createFriendlyclass($children['name']);
				$cClass = self::createFriendlyclass($children['name']);
	
	
				switch($children['type'])
				{
					case 'formMultiple':
						$const = array();
							
	
	
						foreach($children['options'] as $option)
						{
							$const[] = "\tconst VALUE_" . self::createFriendlyConst($option) . ' = "' . addslashes($option) . '";';
						}
	
	
						echo str_replace(
								array("%objectType%", "%objectName%", "%objectClass%", "%const%", "%subheaderClass%"),
								array("formMultiple", addslashes($children['name']), $cClass, join("\n", $const), $shClass),
								$tSHChildrenMC);
	
						$cConstructor[] = "\t\t" . '$this->' . $cClass . ' = new ' . $cClass. '($this);';
						$cList[] = '"' . $cClass . '"';
	
						$cvar[] = str_replace("%objectClass%", $cClass,$tSHChildrenVar);
						break;
					case 'formPhoto':
						$const = array();
							
					
					
						echo str_replace(
								array("%objectType%", "%objectName%", "%objectClass%", "%subheaderClass%"),
								array("formMultiple", addslashes($children['name']), $cClass,  $shClass),
								$tSHChildrenPhoto
							);
					
						$cConstructor[] = "\t\t" . '$this->' . $cClass . ' = new ' . $cClass. '($this);';
						$cList[] = '"' . $cClass . '"';
					
						$cvar[] = str_replace("%objectClass%", $cClass,$tSHChildrenVar);
						break;						
					case 'formText':
					case 'formBarcode':
	
						echo str_replace(
						array("%objectType%", "%objectName%", "%objectClass%", "%subheaderClass%"),
						array("formMultiple", addslashes($children['name']), $cClass, $shClass),
						$tSHChildren);
	
						$cConstructor[] = "\t\t" . '$this->' . $cClass . ' = new ' . $cClass. '($this);';
						$cList[] = '"' . $cClass . '"';
	
	
						$cvar[] = str_replace("%objectClass%", $cClass,$tSHChildrenVar);
	
						break;
					default:
				}
	
	
			}
			$cObjects = ob_get_clean();
	
			$tSHCopy = str_replace(array("%objects%", "%children%", "%construct%", "%list%"), array($cObjects, join("\n", $cvar), join("\n", $cConstructor), join(", ", $cList)), $tSHCopy);
				
			file_put_contents($store . $shClass . ".php", $tSHCopy);
		}
	
		ob_start();
	
		foreach($classes as $subheader)
		{
			$shClass = self::createFriendlyclass($subheader['name']);
			echo str_replace("%subheaderClass%", $shClass, $tHeaderFunc);
		}
	
		$functions = ob_get_clean();
	
		$tHeader = str_replace(array("%subheaders%", "%construct%", "%functions%", "%list%"), array(ob_get_clean(), join("\n", $constructor), $functions, join(", ", $list)), $tHeader);
	
		file_put_contents($store . "Form.php", $tHeader);
	
	
	
	
	}	
}
?>