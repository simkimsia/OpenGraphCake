<?php
/**
 * Plain Old PHP Object that represents a unit of open graph tag data
 *
 *
 * Copyright 2013, Kim Stacks
 * Singapore
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2013, Kim Stacks.
 * @link http://stacktogether.com
 * @author Kim Stacks <kim@stacktogether.com>
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class OpenGraphObject {

	public $type	= '';
	public $title	= '';
	public $url		= '';
	public $image	= '';
	public $image_secure_url	= '';

	public $description = '';
	public $release_date = '';

	public $allowedFields = array(
		'type' => '', 'title' => '', 'url' => '',
		'image' => '', 'image:secure_url' => '', 'description' => '',
		'release_date' => '',
	);

	protected $emptyFields = array();

	CONST BASE = 'base';

	public function __construct($array = array()) {
		$this->convertArrayToVars($array);
	}

	public function convertArrayToVars($array = array()) {
		$allowedKeys = array_keys($this->allowedFields);
		foreach($allowedKeys as $key) {
			if (isset($array[$key])) {
				$this->allowedFields[$key] = $array[$key];
				$propName = str_replace(":", "_", $key);
				$this->$propName = $array[$key];
			}
		}
	}

/**
 * get back the public properties as an array
 * uses ReflectionClass. requires php5 http://www.php.net/manual/en/reflectionclass.getproperties.php
 * http://php.net/manual/en/reflectionproperty.getvalue.php
 */
	public function getProperties() {
		$reflect = new ReflectionClass($this);
		$props = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);
		$ogProperties = array();
		/*
		foreach($props as $property) {
			$name = $property->getName();
			$value = $reflect->getProperty($name)->getValue($this);
			if (!empty($value)) {
				$ogProperties[$name] = $value;
			}
		}
		*/
		foreach($this->allowedFields as $key => $value) {
			if (!empty($value)) {
				$ogProperties[$key] = $value;
			}
		}
		return $ogProperties;
	}

/**
 *
 * ensure all the properties of this type OpenGraph object are all non-empty
 */
	public function validate() {
		$this->emptyFields = array();
		$props = $this->getProperties();
		foreach($props as $name=>$value) {
			if (empty($value)) {
				$this->emptyFields[] = $name;
			}
		}
		return (empty($this->emptyFields));
	}

	public function getEmptyFields() {
		return $this->emptyFields;
	}

}