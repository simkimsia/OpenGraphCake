<?php
/**
 * StoryFixture
 *
 */
class StoryFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'image' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'author_name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'published' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'url' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'og_type' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '2',
			'title' => 'Wall Street',
			'created' => '2012-03-26 02:02:33',
			'modified' => '2012-03-26 02:02:33',
			'description' => 'This is a dummy story',
			'image' => 'http://cdn.localhost/images/2.jpg',
			'author_name' => 'Simon Cowell',
			'published' => '2012-03-26 02:02:33',
			'url' => 'http://localhost/stories/2-Wall-Street',
			'og_type' => 'book'
		),
		array(
			'id' => '3',
			'title' => 'The Pale King',
			'created' => '2012-03-26 02:02:33',
			'modified' => '2012-03-26 02:02:33',
			'description' => 'This is a dummy story',
			'image' => 'http://cdn.localhost/images/3.jpg',
			'author_name' => 'Paula Abdul',
			'published' => '2012-03-26 02:02:33',
			'url' => 'http://localhost/stories/3-The-Pale-King',
			'og_type' => 'book'
		),
		array(
			'id' => '4',
			'title' => 'Milk',
			'created' => '2012-03-26 02:02:33',
			'modified' => '2012-03-26 02:02:33',
			'description' => 'This is a dummy story',
			'image' => 'http://cdn.localhost/images/4.jpg',
			'author_name' => 'Randy Jackson',
			'published' => '2012-03-26 02:02:33',
			'url' => 'http://localhost/stories/4-Milk',
			'og_type' => 'book'
		),
	);
}
