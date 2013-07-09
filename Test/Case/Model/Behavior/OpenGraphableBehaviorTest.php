<?php
/**
 * Test case for OpenGraphableBehavior class
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
App::uses('Model', 'Model');
App::uses('AppModel', 'Model');
App::uses('OpenGraphObject', 'OpenGraphCake.Lib');
/**
 * OpenGraphableBehaviorTest class
 *
 * @package       OpenGraphCake.Test.Case.Model.Behavior
 */
class OpenGraphableBehaviorTest extends CakeTestCase {
/**
 * Fixtures associated with this test case
 *
 * @var array
 */
	public $fixtures = array(
		'OpenGraphCake.story'
	);

/**
 * Method executed before each test
 *
 */
	public function setUp() {
		parent::setUp();
		$this->Story = ClassRegistry::init('Story');
		$this->Story->Behaviors->load('OpenGraphable', array(
			'fields' => array(
				'type' => 'og_type'
				)
			));
		// retrieve the original data records from fixtures
		$storyFixture = new storyFixture();
		$this->stories = $storyFixture->records;
	}

/**
 * Method executed after each test
 *
 */
	public function tearDown() {
		// unset any models called
		unset($this->Story);
		// unset any records
		unset($this->stories);
		parent::tearDown();
	}

/**
 * test getOpenGraphObject assuming base
 */
	public function testGetOpenGraphObject() {
		// GIVEN we retrieve data from Story id 2
		$data = $this->Story->read(null, 2);
		// WHEN we execute the getOpenGraphObject on the data
		$openGraphObject = $this->Story->getOpenGraphObject($data);
		// THEN we expect an OpenGraphObject instance
		$isOGObjInstance = ($openGraphObject instanceof OpenGraphObject);
		$this->assertTrue($isOGObjInstance);
		// AND we expect the 4 basic fields of title, image, url, and type to match the same values in fixture
		$this->assertEqual($openGraphObject->url, $this->records[0]['url']);
		$this->assertEqual($openGraphObject->image, $this->records[0]['image']);
		$this->assertEqual($openGraphObject->type, $this->records[0]['type']);
		$this->assertEqual($openGraphObject->title, $this->records[0]['title']);
	}
}