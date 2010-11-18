<?php
/* Comment Fixture generated on: 2010-10-16 15:10:50 : 1287257270 */
class CommentFixture extends CakeTestFixture {
	var $name = 'Comment';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'post_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'content' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'user_id' => 2,
			'post_id' => 1,
			'content' => 'John, your post is too short!'
		),
		array(
			'id' => 2,
			'user_id' => 3,
			'post_id' => 1,
			'content' => 'His post is short, but it is also easily understandable.'
		),
		array(
			'id' => 3,
			'user_id' => 4,
			'post_id' => 1,
			'content' => 'Nice post John'
		),
		array(
			'id' => 4,
			'user_id' => 1,
			'post_id' => 1,
			'content' => 'Hehe\r\n\r\n@Jane :p\r\n\r\n@George understandable indeed!\r\n\r\n@James thanks :)'
		),
		array(
			'id' => 5,
			'user_id' => 4,
			'post_id' => 2,
			'content' => 'Nice post Jane'
		),
		array(
			'id' => 6,
			'user_id' => 1,
			'post_id' => 2,
			'content' => '@.@'
		),
		array(
			'id' => 7,
			'user_id' => 3,
			'post_id' => 2,
			'content' => 'I find it a little hard to understand.'
		),
		array(
			'id' => 8,
			'user_id' => 2,
			'post_id' => 2,
			'content' => '@James thanks :)\r\n\r\n@John ?\r\n\r\n@George Using your brain is good for you!'
		),
	);
}
?>