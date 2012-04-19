<?php
/* Tag Fixture generated on: 2010-10-16 15:10:17 : 1287258017 */
class TagFixture extends CakeTestFixture {
	var $name = 'Tag';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'tag' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 60),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'tag' => 'too short'
		),
		array(
			'id' => 2,
			'tag' => 'understandable'
		),
		array(
			'id' => 3,
			'tag' => 'good'
		),
		array(
			'id' => 4,
			'tag' => 'john'
		),
		array(
			'id' => 5,
			'tag' => 'too long'
		),
		array(
			'id' => 6,
			'tag' => 'unfathomable'
		),
		array(
			'id' => 7,
			'tag' => 'Lor Ipsum'
		),
	);
}
?>