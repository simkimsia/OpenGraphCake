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
App::uses('OpenGraphCakeAppModel', 'OpenGraphCake.Model');
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
		'plugin.OpenGraphCake.story'
	);

/**
 * Method executed before each test
 *
 */
	public function setUp() {
		parent::setUp();
		$this->Story = ClassRegistry::init('OpenGraphCake.Story');
		$this->Story->Behaviors->load('OpenGraphCake.OpenGraphable', array(
			'fields' => array(
				'type' => 'og_type',
				'description',
				'release_date' => 'published'
			)
		));
		// retrieve the original data records from fixtures
		$storyFixture = new StoryFixture();
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
		$this->assertEqual($openGraphObject->url, $this->stories[0]['url']);
		$this->assertEqual($openGraphObject->image, $this->stories[0]['image']);
		$this->assertEqual($openGraphObject->image_secure_url, $this->stories[0]['image']);
		$this->assertEqual($openGraphObject->type, $this->stories[0]['og_type']);
		$this->assertEqual($openGraphObject->title, $this->stories[0]['title']);
		$this->assertEqual($openGraphObject->description, $this->stories[0]['description']);
		$this->assertEqual($openGraphObject->release_date, $this->stories[0]['published']);
	}
}