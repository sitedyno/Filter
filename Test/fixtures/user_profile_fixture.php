<?php
/* UserProfile Fixture generated on: 2010-10-16 15:10:46 : 1287259186 */
class UserProfileFixture extends CakeTestFixture {
	var $name = 'UserProfile';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'first_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 60),
		'middle_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 60),
		'last_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 60),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'user_id' => 3,
			'first_name' => 'George',
			'middle_name' => 'Thomas',
			'last_name' => 'Jones'
		),
		array(
			'id' => 2,
			'user_id' => 4,
			'first_name' => 'Jimmy',
			'middle_name' => 'Jameson',
			'last_name' => 'Johnson'
		),
		array(
			'id' => 3,
			'user_id' => 2,
			'first_name' => 'Jane',
			'middle_name' => 'Smith',
			'last_name' => 'Doe'
		),
		array(
			'id' => 4,
			'user_id' => 1,
			'first_name' => 'John',
			'middle_name' => '',
			'last_name' => 'Doe'
		),
	);
}
?>