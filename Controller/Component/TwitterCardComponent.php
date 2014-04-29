<?php
/**
 * Prepares Twitter meta Tags. See https://dev.twitter.com/docs/cards/types/product-card for more details
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
App::uses('TwitterCard', 'OpenGraphCake.Lib/Twitter');
App::uses('TwitterProduct', 'OpenGraphCake.Lib/Twitter');
App::uses('TwitterSummaryLargeImage', 'OpenGraphCake.Lib/Twitter');
class TwitterCardComponent extends Component {

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
 * global twitter app id
 *
 * @access public
 * @var int
 */
	public $globalTwitterAppId = null;

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
 * by Html CakeHelper for generating a single meta tag. An array with the 2 keyvalue pairs.
 * The fields are property and content.
 * @param $property String
 * @param $content String
 * @return Array An array with 2 key-value pairs like these:
 * a) property => og:title
 * b) content => 'The Rock'
 */
	protected function _buildSingleTagArray($name, $content) {
		return compact('name', 'content');
	}

/**
 *
 * Setup basic metadata for Open Graph tags. Return array that will be used
 * by Html CakeHelper for generating the meta tags. Find out more at https://dev.twitter.com/docs/cards/types/product-card
 *
 * @param $metadata mixed Expect either OpenGraphObject instance or data array of fields stating the expected metadata
 * @param $options Array. Optional. Default is 'twitterTags' as value and viewVarName as key.
 * This will be the view var set by the controller. if the value is false, then we turn off the set.
 * @return Array Each value will be an array. The subarrays will have such key-value pairs:
 * a) property => og:title
 * b) content => 'The Rock'
 */
	public function setViewVar($metadata = array(), $options = array()) {
		$defaultOptions = array(
			'viewVarName' => 'twitterTags',
			'globalTwitterAppId' => false,
		);
		$options = array_merge($defaultOptions, $options);

		if ($metadata instanceof TwitterCard) {
			$metadata = $metadata->getProperties();
		}

		$twitterMetaData = array('twitter' => $metadata);
		$flattened = Hash::flatten($twitterMetaData);
		foreach ($flattened as $key => $content) {
			$name = str_replace(".", ":", $key);
			$singleTag = $this->_buildSingleTagArray($name, $content);
			$result[] = $singleTag;
		}

		// only use this if there is such a thing as twitter app id
		// if (!empty($options['globalTwitterAppId']) && !empty($this->globalTwitterAppId)) {
		// 	$singleTag = $this->_buildSingleTagArray('twitter:app_id', $this->globalTwitterAppId);
		// 	$result[] = $singleTag;
		// }

		if (!empty($options['viewVarName']) && is_string($options['viewVarName'])) {
			$viewVarName = $options['viewVarName'];
			$this->controller->set($viewVarName, $result);
		}

		return $result;
	}

}