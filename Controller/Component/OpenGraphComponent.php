<?php
/**
 * Prepares OpenGraph Tags. See http://ogp.me/ for more details
 *
 * Cake2.x compatible Component
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
App::uses('ArrayLib', 'UtilityLib.Lib');
App::uses('Hash', 'Utility');
App::uses('Component', 'Controller');
App::uses('OpenGraphObject', 'OpenGraphCake.Lib/OpenGraph');
class OpenGraphComponent extends Component {

/**
 * Behavior settings
 *
 * @access public
 * @var array
 */
	public $settings = array();

/**
 * Cake Controller
 *
 * @access public
 * @var array
 */
	public $controller = null;

/**
 * Initialize function
 *
 *
 * @param controller object $controller
 * @param array $settings
 */
	public function initialize(Controller $controller) {
		$this->controller = $controller;
	}

/**
 *
 * @param controller object $controller
 */
	public function startup(Controller $controller) {
		$this->controller = $controller;
	}

/**
 * Return array that will be used
 by Html CakeHelper for generating a single meta tag. An array with the 2 keyvalue pairs.
 The fields are property and content.
 * @param $property String
 * @param $content String
 * @return Array An array with 2 key-value pairs like these:
 a) property => og:title
 b) content => 'The Rock'
*/
	protected function _buildSingleTagArray($property, $content) {
		return compact('property', 'content');
	}

/**
 *
 * Setup basic metadata for Open Graph tags. Return array that will be used
 by Html CakeHelper for generating the meta tags. Find out more at http://ogp.me/#metadata
 *
 * @param $metadata mixed Expect either OpenGraphObject instance or data array of fields stating the expected metadata
 * @param $options Array. Optional. Default is 'openGraphTags' as value and viewVarName as key.
  This will be the view var set by the controller. if the value is false, then we turn off the set.
 * @return Array Each value will be an array. The subarrays will have such key-value pairs:
 a) property => og:title
 b) content => 'The Rock'
 */
	public function setViewVar($metadata = array(), $options = array()) {
		$defaultOptions = array(
			'viewVarName' => 'openGraphTags',
		);
		$options = array_merge($defaultOptions, $options);

		if($metadata instanceof OpenGraphObject) {
			$metadata = $metadata->getProperties();
		}

		$ogMetaData = array('og' => $metadata);
		$flattened = Hash::flatten($ogMetaData);
		foreach($flattened as $key=>$content) {
			$property = str_replace(".", ":", $key);
			$singleTag = $this->_buildSingleTagArray($property, $content);
			$result[] = $singleTag;
		}

		if (!empty($options['viewVarName']) && is_string($options['viewVarName'])) {
			$viewVarName = $options['viewVarName'];
			$this->controller->set($viewVarName, $result);
		}

		// $this->controller->log($missingKeys);

		return $result;
	}
}