<?php
/* PostsTag Fixture generated on: 2010-10-16 15:10:02 : 1287258002 */
class PostsTagFixture extends CakeTestFixture {
	var $name = 'PostsTag';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'post_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'tag_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'post_id' => 1,
			'tag_id' => 1
		),
		array(
			'id' => 2,
			'post_id' => 1,
			'tag_id' => 2
		),
		array(
			'id' => 3,
			'post_id' => 2,
			'tag_id' => 3
		),
		array(
			'id' => 4,
			'post_id' => 1,
			'tag_id' => 3
		),
		array(
			'id' => 5,
			'post_id' => 1,
			'tag_id' => 4
		),
		array(
			'id' => 6,
			'post_id' => 2,
			'tag_id' => 5
		),
		array(
			'id' => 7,
			'post_id' => 2,
			'tag_id' => 6
		),
		array(
			'id' => 8,
			'post_id' => 2,
			'tag_id' => 7
		),
	);
}
?>