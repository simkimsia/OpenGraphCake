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

	public $type = '';
	public $title = '';
	public $url = '';
	public $image = '';

	public $description = '';

	protected $emptyFields = array();

	CONST BASE = 'base';

	public function __construct($array = array()) {
		$this->convertArrayToVars($array);
	}

	public function convertArrayToVars($array = array()) {
		if (isset($array['type'])) {
			$this->type = $array['type'];
		}
		if (isset($array['title'])) {
			$this->title = ($array['title']);
		}
		if (isset($array['url'])) {
			$this->url = $array['url'];
		}
		if (isset($array['image'])) {
			$this->image = ($array['image']);
		}
		if (isset($array['description'])) {
			$this->description = ($array['description']);
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
		foreach($props as $property) {
			$name = $property->getName();
			$value = $reflect->getProperty($name)->getValue($this);
			if (!empty($value)) {
				$ogProperties[$name] = $value;
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