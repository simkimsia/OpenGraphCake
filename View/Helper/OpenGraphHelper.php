<?php
/**
 * Creates OpenGraph Tags. See http://ogp.me/ for more details
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
App::uses('AppHelper', 'View/Helper');

class OpenGraphHelper extends AppHelper {

	// use CakePHP Native HtmlHelper
	public $helpers = array('Html');

/**
 *
 * Generates a single meta HTML element for Open Graph use. The element is in string format.
 *
 * @param $singleOGTagArray Array. Expect property and content as keys and nothing else.
 * @return String. The HTML element in string form E.g. <meta property="og:site_name" content="Amazon.com" xmlns:og="http://opengraphprotocol.org/schema/">
 */
	public function metaOG($singleOGTagArray, $includeNameSpace = true) {
		$missingKeys = array();
		$requiredFields = array('property', 'content');
		if (ArrayLib::checkIfKeysExist($singleOGTagArray, $requiredFields, $missingKeys)) {
			$extractedData = ArrayLib::extractIfKeysExist($singleOGTagArray, $requiredFields);
			if ($includeNameSpace) {
				$this->_addXmlNamespace($extractedData);
			}
			return $this->Html->meta($extractedData);
		}
		return '';
	}

/**
 *
 * usually the meta element <meta property="og:site_name" content="Amazon.com" xmlns:og="http://opengraphprotocol.org/schema/">
 * contains xmlns attribute, so we need to have it
 *
 */
	protected function _addXmlNamespace(&$metadata) {
		if (!isset($metadata['xmlns:og'])) {
			$metadata['xmlns:og'] = 'http://opengraphprotocol.org/schema/';
		}
		return $metadata;
	}

/**
 *
 * generates many meta HTML elements for Open Graph
 *
 * @param $multipleOGTagArray Array. Array of subarrays where each subarray is expected to have property and content as keys and nothing else.
 * @return String. The HTML element in string form
 */
	public function metaMany($multipleOGTagArray, $type = 'og') {
		$result = '';
		foreach ($multipleOGTagArray as $og) {
			if ($type == 'og') {
				$result .= $this->metaOG($og) . "\n";
			}
			if ($type == 'twitter') {
				$result .= $this->meta($og) . "\n";
			}
		}
		return $result;
	}

/**
 *
 * Generates a single meta HTML element for Twitter use. The element is in string format.
 *
 * @param $singleOGTagArray Array. Expect property and content as keys and nothing else.
 * @return String. The HTML element in string form E.g. <meta property="og:site_name" content="Amazon.com" xmlns:og="http://opengraphprotocol.org/schema/">
 */
	public function meta($singleOGTagArray) {
		$missingKeys = array();
		$requiredFields = array('name', 'content');
		if (ArrayLib::checkIfKeysExist($singleOGTagArray, $requiredFields, $missingKeys)) {
			$extractedData = ArrayLib::extractIfKeysExist($singleOGTagArray, $requiredFields);
			return $this->Html->meta($extractedData);
		}
		return '';
	}

}