<?php
/**
 * Plain Old PHP Object that represents a unit of twitter tag data
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
App::uses('Inflector', 'Utility');
class TwitterCard {

	public $card	= 'summary';

	public $title	= '';

	public $image	= '';

	public $description = '';

	public $site = '';

	public $allowedFields = array(
		'card' => 'summary', 'title' => '',
		'image' => '', 'description' => '',
		'site' => ''
	);

	protected $_emptyFields = array();

	const BASE = 'base';

	const SUMMARY_LARGE_IMAGE = 'summary_large_image';

	const PRODUCT = 'product';

	public function __construct($array = array()) {
		$this->convertArrayToVars($array);
	}

	public function convertArrayToVars($array = array()) {
		$allowedKeys = array_keys($this->allowedFields);
		foreach ($allowedKeys as $key) {
			if (isset($array[$key])) {
				$this->allowedFields[$key] = $array[$key];
				$propName = str_replace(":", "_", $key);
				$propName = Inflector::variable($propName);
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
		foreach ($props as $property) {
			$name = $property->getName();
			$value = $reflect->getProperty($name)->getValue($this);
			if (!empty($value)) {
				$ogProperties[$name] = $value;
			}
		}
		*/
		foreach ($this->allowedFields as $key => $value) {
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
		$this->_emptyFields = array();
		$props = $this->getProperties();
		foreach ($props as $name => $value) {
			if (empty($value)) {
				$this->_emptyFields[] = $name;
			}
		}
		return (empty($this->_emptyFields));
	}

	public function getEmptyFields() {
		return $this->_emptyFields;
	}

}