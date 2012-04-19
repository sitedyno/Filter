<?php

class AdFixture extends CakeTestFixture {
/**
 * name property
 *
 * @var string
 */
	public $name = 'Ad';

/**
 * fields property
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'key' => 'primary'),
		'post_id' => array('type' => 'integer'),
		'content' => array('type' => 'string', 'length' => 255, 'null' => false)
	);

/**
 * Records property
 *
 * @var array
 */
	public $records = array(
		array('id' => 1, 'post_id' => 1, 'content' => 'buy my really cheap stuff!'),
		array('id' => 2, 'post_id' => 2, 'content' => 'buy my really overpriced stuff!!')
	);
}
