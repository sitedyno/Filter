<?php
/* User Fixture generated on: 2010-10-16 16:10:03 : 1287259203 */
class UserFixture extends CakeTestFixture {
	var $name = 'User';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 60, 'key' => 'index'),
		'email' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 60),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'username' => array('column' => array('name', 'email'), 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 3,
			'name' => 'George',
			'email' => 'george@example.com'
		),
		array(
			'id' => 4,
			'name' => 'James',
			'email' => 'james@example.com'
		),
		array(
			'id' => 2,
			'name' => 'Jane',
			'email' => 'jane@example.com'
		),
		array(
			'id' => 1,
			'name' => 'John',
			'email' => 'john@example.com'
		),
	);
}
?>