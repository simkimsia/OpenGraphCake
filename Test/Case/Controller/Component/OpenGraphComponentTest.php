<?php
App::uses('Controller', 'Controller');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');
App::uses('ComponentCollection', 'Controller');
App::uses('OpenGraphComponent', 'OpenGraphCake.Controller/Component');

// A fake controller to test against
class TestStoriesController extends Controller {

	public $paginate = null;
}

class OpenGraphComponentTest extends CakeTestCase {

	public $OpenGraphComponent = null;

	public $Controller = null;

	public function setUp() {
		parent::setUp();
		// Setup our component and fake test controller
		$Collection = new ComponentCollection();
		$this->OpenGraphComponent = new OpenGraphComponent($Collection);
		$CakeRequest = new CakeRequest();
		$CakeResponse = new CakeResponse();
		$this->Controller = new TestStoriesController($CakeRequest, $CakeResponse);
		$this->OpenGraphComponent->startup($this->Controller);
	}

	public function testSetViewVar() {
		/*
		// Test our adjust method with different parameter settings
		$this->OpenGraphComponent->adjust();
		$this->assertEquals(20, $this->Controller->paginate['limit']);

		$this->OpenGraphComponent->adjust('medium');
		$this->assertEquals(50, $this->Controller->paginate['limit']);

		$this->OpenGraphComponent->adjust('long');
		$this->assertEquals(100, $this->Controller->paginate['limit']);
		*/
	}

	public function tearDown() {
		parent::tearDown();
		// Clean up after we're done
		unset($this->OpenGraphComponent);
		unset($this->Controller);
	}
}
