<?php
/* Post Fixture generated on: 2010-10-16 15:10:46 : 1287257986 */
class PostFixture extends CakeTestFixture {
	var $name = 'Post';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'title' => array('type' => 'string', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'content' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'name' => array('column' => 'title', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'user_id' => 1,
			'title' => 'The Story of John',
			'content' => 'Hi,\r\nMy name is John. This is my story. It\'s pretty short though.',
			'created' => '2010-10-31 15:30:00',
		),
		array(
			'id' => 2,
			'user_id' => 2,
			'title' => 'Jane\'s Post',
			'content' => 'Jane here,\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque nulla turpis, rhoncus et commodo eu, bibendum non nunc. Phasellus iaculis euismod risus ut faucibus. Proin mauris lacus, vestibulum sit amet convallis eget, elementum quis sapien. Phasellus est tellus, aliquet laoreet sodales a, posuere id massa. Cras tellus lorem, adipiscing id ornare non, posuere eget dolor. Pellentesque id hendrerit magna. Phasellus quis sapien tellus, vel aliquam risus. Proin convallis nulla id tellus facilisis id imperdiet dui dictum. Donec blandit sapien in purus accumsan ac hendrerit tortor volutpat. Sed hendrerit interdum luctus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse consectetur ullamcorper nunc, ut congue lorem dictum eget. In volutpat porta ligula in lobortis. Nam eros lorem, hendrerit sit amet lobortis quis, molestie eu lacus.\r\n\r\nNulla vitae tristique neque. Nam tincidunt tristique ligula vitae egestas. Maecenas urna lacus, blandit lacinia pellentesque at, bibendum a magna. Nullam scelerisque sagittis neque, vel pellentesque nisl vulputate non. Proin ultrices ante nec nisl cursus tincidunt. Aenean arcu dui, sollicitudin non aliquet eu, tempor fermentum lectus. Suspendisse et adipiscing arcu. Donec vel mi vel massa lobortis interdum vel eu mauris. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Ut quis nulla nulla, rhoncus molestie nunc. Nunc sit amet porta urna. Donec sagittis dolor vel arcu ultrices in luctus nunc convallis. Integer sed elit lorem. Donec pulvinar turpis lectus, eu pretium sem. Aliquam elementum ultricies tincidunt. Vestibulum accumsan luctus sagittis.\r\n\r\nEtiam laoreet ligula eget dolor porttitor lacinia. Aliquam commodo lacinia eros in luctus. Nulla consequat tortor eget est congue posuere. Vestibulum sed diam ut tellus consequat varius. Quisque libero metus, ultricies a lacinia in, tempor a ipsum. Sed pretium consectetur scelerisque. Vestibulum eu odio sit amet enim adipiscing convallis. Nullam tortor tellus, pharetra id volutpat vel, porta non metus. Sed at erat dui. Nam id nisi nulla. Suspendisse potenti. Sed vestibulum porttitor sem, at vehicula mauris accumsan quis. Fusce vel turpis at arcu tincidunt tempus vel at erat. Nullam ac velit eget ligula suscipit commodo id ut orci. Ut dictum nulla sit amet augue faucibus sit amet aliquet dolor ultricies. Vestibulum sit amet tortor ac lacus sodales rutrum vel non tellus.\r\n\r\nMauris venenatis, dui non accumsan molestie, libero tellus molestie felis, at commodo sapien eros ac mi. Integer semper accumsan est, nec mattis magna porta ac. Sed eu purus a magna laoreet venenatis in a sem. Duis dui lacus, rutrum ac molestie in, pellentesque ac magna. Phasellus consequat fringilla purus non molestie. Curabitur pharetra consequat tincidunt. Proin at urna ut est consequat volutpat. Fusce porttitor, felis in ullamcorper accumsan, turpis nisi hendrerit lorem, vel tempus ante ipsum id ante. Cras tortor orci, vulputate sit amet placerat at, eleifend eget ante. Ut molestie, enim ac volutpat euismod, orci libero semper eros, eu egestas ipsum purus ac velit. Nullam mollis scelerisque nunc sit amet pretium. Cras sed purus lectus, ut suscipit erat. Donec sed leo dolor, at rhoncus mi. Aliquam elit felis, ullamcorper non pellentesque ut, volutpat suscipit ipsum.\r\n\r\nUt mi lorem, accumsan non tincidunt non, pulvinar eget urna. Nullam scelerisque turpis et libero imperdiet ultricies. Phasellus euismod hendrerit elementum. Vivamus eu dolor vitae massa luctus scelerisque et non risus. Cras sagittis nulla a nisi fringilla vitae auctor nisl sagittis. Nulla eu dolor sed dolor dignissim hendrerit. Curabitur vulputate tempus sapien, et sagittis urna suscipit nec. Donec hendrerit lacus vitae est facilisis nec varius nulla semper. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Etiam semper elit quis tellus ultricies quis tempus velit imperdiet. Ut adipiscing dolor sed mauris vestibulum cursus. Donec fringilla vulputate mi nec auctor. Morbi ut eros nulla. Maecenas mauris est, elementum nec pellentesque at, varius eget sapien. ',
			'created' => '2010-11-05 10:00:00',
		),
	);
}
?>
