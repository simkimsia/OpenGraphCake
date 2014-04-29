<?php
/**
 * Format array data for use in OpenGraph.
 *
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
App::uses('Hash', 'Utility');
App::uses('ModelBehavior', 'Model');
App::uses('OpenGraphObject', 'OpenGraphCake.Lib/OpenGraph');
class OpenGraphableBehavior extends ModelBehavior {

/**
 * Behavior settings
 *
 * @access public
 * @var array
 */
	public $settings = array();

/**
 * Cake Model
 *
 * @access public
 * @var array
 */
	public $model = null;

/**
 * Configuration method.
 *
 * @param object $Model Model object
 * @param array $settings Settings array
 * @access public
 * @return boolean
 */
	public function setup(Model $Model, $settings = array()) {
		$this->model = $Model;
		$defaultSettings = array(
			'fields' => array(
				'title'	=> 'title',
				'type'	=> 'type',
				'image'	=> 'image',
				'url'	=> 'url',
				'image:secure_url' => 'image',
			)
		);

		foreach ($settings['fields'] as $property => $databaseFieldName) {
			if (!is_string($property)) {
				unset($settings['fields'][$property]);
				$settings['fields'][$databaseFieldName] = $databaseFieldName;
			}
		}
		$this->settings = Hash::merge($defaultSettings, $settings);
		return true;
	}

/**
 *
 * Format a given data array to match fields for common OpenGraph fields
 * @param array $data.
 * @param array $type Default OpenGraph::BASE
 * @return OpenGraph object Either an instance of OpenGraphObject or one of its subclasses.
 */
	public function getOpenGraphObject(Model $model, $data = array(), $type = OpenGraphObject::BASE) {
		$suppliedData = array();
		if (isset($data[$model->alias])) {
			$suppliedData = $data[$model->alias];
		} else {
			$suppliedData = $data;
		}
		$formattedData = array();
		foreach ($this->settings['fields'] as $property => $databaseFieldName) {
			$return = $this->_formatOneOGProperty($suppliedData, $property, $formattedData);
		}

		$ogObject = $this->_createOGObjectByType($type);

		$ogObject->convertArrayToVars($formattedData);

		if (!$ogObject->validate()) {
			// throw missing data exception??
		}
		return $ogObject;
	}

	protected function _createOGObjectByType($type = OpenGraphObject::BASE) {
		switch($type) {
			case OpenGraphObject::BASE :
			default:
				return new OpenGraphObject();
			break;
		}
	}

/**
 *
 * Format single OG property using $this->settings acting on $cleanedData.
 *
 * @param $cleanedData Array of the supplied data which is cleaned. ie no subarray
 * @param $property String Property name
 * @param &$formatted Array of formatted og data. Pass by reference
 * @return String value of the property
 * @throws RequiredFieldInArrayMissingException
 */
	protected function _formatOneOGProperty($cleanedData, $property = 'title', &$formatted = array()) {
		// find out what database field name corresponds to this property
		$databaseFieldName	= $this->settings['fields'][$property];
		// find out the value for this property
		if (isset($cleanedData[$databaseFieldName])) {
			$value					= $cleanedData[$databaseFieldName];
			// now we update the $formatted array
			$formatted[$property]	= $value;
			return $value;
		}
		return false;
	}
}