<?php
/**
 * Filter Component Tests
 *
 * @author		Heath Nail
 * @license		http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package		filter
 * @subpackage	filter.tests.cases.components
 */

App::import('Model', 'AppModel');
App::import('Component', 'Filter.Filter');

class Comment extends AppModel {
	var $name = 'Comment';
	var $belongsTo = array('Post', 'User');
}
class Post extends AppModel {
	var $name = 'Post';
	var $belongsTo = array('User');
	var $hasAndBelongsToMany = array('Tag');
	var $hasMany = array('Comment');
}
class Tag extends AppModel {
	var $name = 'Tag';
	var $hasAndBelongsToMany = array('Post');
}
class User extends AppModel {
	var $name = 'User';
	var $hasMany = array('Comment', 'Post');
	var $hasOne = array('UserProfile');
}
class UserProfile extends AppMOdel {
	var $name = 'UserProfile';
	var $belongsTo = array('User');
}


class TestFilterComponent extends FilterComponent {
	public function addInnerJoin(&$model, $hasManyModel) {
		return $this->_addInnerJoin($model, $hasManyModel);
	}
	public function addInnerJoins(&$model, $field, $values) {
		return $this->_addInnerJoins($model, $field, $values);
	}
	public function addWildcards($values) {
		return $this->_addWildcards($values);
	}
	public function assignQuery() {
		return $this->_assignQuery();
	}
	public function buildRedirectUrl() {
		return $this->_buildRedirectUrl();
	}
	public function collectNamedParams() {
		return $this->_collectNamedParams();
	}
	public function collectPostData() {
		return $this->_collectPostData();
	}
	public function parseDotField($field) {
		return $this->_parseDotField($field);
	}
	public function processForQuery() {
		return $this->_processForQuery();
	}
	public function sanitizeForQuery() {
		return $this->_sanitizeForQuery();
	}
	public function sanitizeForRedirect() {
		return $this->_sanitizeForRedirect();
	}
}

class FilterTestController extends Controller {

/**
 * Components property
 *
 * @var array
 * @access public
 */
	var $components = array('TestFilter');

/**
 * Data property
 *
 * @var array
 * @access public
 */
	var $data = array();

/**
 * Paginate property
 *
 * @var array
 * @access public
 */
	var $paginate = array();

/**
 * Params property
 *
 * @var array
 * @access public
 */
	var $params = array('url' => array('url' => 'posts'));

/**
 * Uses property
 *
 * @var array
 * @access public
 */
	var $uses = array('Post');

}

class FilterComponentTestCase extends CakeTestCase {

/**
 * Controller property
 *
 * @var FilterTestController
 * @access public
 */
	var $Controller;

/**
 * Fixtures property
 *
 * @var array
 * @access public
 */
	var $fixtures = array(
		'plugin.filter.comment',
		'plugin.filter.post',
		'plugin.filter.posts_tag',
		'plugin.filter.tag',
		'plugin.filter.user',
		'plugin.filter.user_profile',
	);

/**
 * Start the tests.
 *
 * @access public
 * @return void
 */
	function startTest() {
		$this->controller = new FilterTestController();
		$this->controller->constructClasses();
		$this->controller->Component->init($this->controller);
		$this->controller->filter = $this->controller->TestFilter;
		$this->filter = $this->controller->TestFilter;
		$this->filter->initialize($this->controller);
	}

/**
 * End the tests.
 *
 * @access public
 * @return void
 */
	public function endTest() {
		ClassRegistry::flush();
	}

	public function testAddInnerJoins() {
		$expected = array(
			'joins' => array(
				array(
					'table' => 'posts_tags',
					'alias' => 'PostsTag',
					'type' => 'INNER',
					'foreignKey' => false,
					'conditions' => array(
						'Post.id = PostsTag.post_id',
					),
				),
				array(
					'table' => 'tags',
					'alias' => 'Tag',
					'type' => 'INNER',
					'foreignKey' => false,
					'conditions' => array(
						'Tag.id = PostsTag.tag_id',
						'Tag.tag' => array(
							'good',
						),
					),
				),
			),
			'group' => array(
				'Post.id',
			),
		);
		$this->filter->queryData = array(
			'Tag.tag' => 'good',
		);
		$model = $this->controller->modelClass;
		$result = $this->filter->addInnerJoins($this->controller->{$model}, 'Tag.tag', 'good');
		$this->assertEqual($result, $expected);
	}

	public function testAddWildcards() {
		$testString = 'some query';
		$testArray = array('query 1', 'query 2');

		// (default) spaceIsWildcard = true, wrapWildcards = true
		$expected = '%some%query%';
		$result = $this->filter->addWildcards($testString);
		$this->assertEqual($result, $expected);

		$expected = array('%query%1%', '%query%2%');
		$result = $this->filter->addWildcards($testArray);
		$this->assertEqual($result, $expected);

		// spaceIsWildcard = false, wrapWildcards = true
		$this->filter->spaceIsWildcard = false;
		$expected = '%some query%';
		$result = $this->filter->addWildcards($testString);
		$this->assertEqual($result, $expected);

		$expected = array('%query 1%', '%query 2%');
		$result = $this->filter->addWildcards($testArray);
		$this->assertEqual($result, $expected);

		// spaceIsWildcard = true, wrapWildcards = false
		$this->filter->spaceIsWildcard = true;
		$this->filter->wrapWildcards = false;
		$expected = 'some%query';
		$result = $this->filter->addWildcards($testString);
		$this->assertEqual($result, $expected);

		$expected = array('query%1', 'query%2');
		$result = $this->filter->addWildcards($testArray);
		$this->assertEqual($result, $expected);

		// spaceIsWildcard = false, wrapWildcards = false
		$this->filter->spaceIsWildcard = false;
		$this->filter->wrapWildcards = false;
		$expected = $testString;
		$result = $this->filter->addWildcards($testString);
		$this->assertEqual($result, $expected);

		$expected = $testArray;
		$result = $this->filter->addWildcards($testArray);
		$this->assertEqual($result, $expected);
	}

	public function testAssignQuery() {
		$this->filter->autoAssign = true;
		$this->filter->query = $expected = array(
			'query1' => 'query2',
		);
		$this->filter->assignQuery();
		$this->assertEqual($this->controller->paginate, $expected);
	}

	public function testAssignQueryAutoAssignFalse() {
		$this->filter->autoAssign = false;
		$this->filter->query = $expected = array(
			'query1' => 'query2',
		);
		$this->controller->paginate = $expected = array();
		$this->filter->assignQuery();
		$this->assertEqual($this->controller->paginate, $expected);
	}

	public function testBuildQueryBasic() {
		$this->filter->queryData = array(
			'Post.title' => 'Post',
		);
		$expected = array(
			'Post' => array(
				'conditions' => array(
					'Post.title LIKE' => '%Post%',
				),
			),
		);
		$model = $this->controller->{$this->controller->modelClass};
		$result = $this->filter->buildQuery($model);
		$this->assertEqual($result, $expected);
	}

	public function testBuildQueryBelongsTo() {
		$this->filter->queryData = array(
			'User.name' => 'John',
		);
		$expected = array(
			'Post' => array(
				'conditions' => array(
					'User.name LIKE' => '%John%',
				),
			)
		);
		$model = $this->controller->{$this->controller->modelClass};
		$result = $this->filter->buildQuery($model);
		$this->assertEqual($result, $expected);
	}

	public function testBuildQueryHabtm() {
		$this->filter->queryData = array(
			'Tag.tag' => 'understandable',
		);
		$expected = array(
			'Post' => array(
				'joins' => array(
					array(
						'table' => 'posts_tags',
						'alias' => 'PostsTag',
						'type' => 'INNER',
						'foreignKey' => false,
						'conditions' => array(
							'Post.id = PostsTag.post_id',
						),
					),
					array(
						'table' => 'tags',
						'alias' => 'Tag',
						'type' => 'INNER',
						'foreignKey' => false,
						'conditions' => array(
							'Tag.id = PostsTag.tag_id',
							'Tag.tag' => array(
								'understandable',
							),
						),
					),
				),
				'group' => array(
					'Post.id',
				)
			)
		);
		$model = $this->controller->{$this->controller->modelClass};
		$result = $this->filter->buildQuery($model);
		$this->assertEqual($result, $expected);
	}

	public function testBuildQueryHasMany() {
		$this->filter->queryData = array(
			'Comment.content' => 'short',
		);
		$expected = array(
			'Post' => array(
				'joins' => array(
					array(
						'table' => 'comments',
						'alias' => 'Comment',
						'type' => 'INNER',
						'conditions' => array(
							'Post.id = Comment.post_id',
						),
					),
				),
				'group' => array(
					'Post.id',
				),
				'conditions' => array(
					'Comment.content LIKE' => '%short%',
				)
			)
		);
		$model = $this->controller->{$this->controller->modelClass};
		$result = $this->filter->buildQuery($model);
		$this->assertEqual($result, $expected);
	}

	public function testBuildQueryHasOne() {
		$this->filter->queryData = array(
			'UserProfile.last_name' => 'Jones',
		);
		$expected = array(
			'User' => array(
				'conditions' => array(
					'UserProfile.last_name LIKE' => '%Jones%',
				),
			),
		);
		$model = $this->controller->{$this->controller->modelClass}->User;
		$this->controller->modelClass = $model->alias;
		$this->controller->User = $model;
		$result = $this->filter->buildQuery($model);
		$this->assertEqual($result, $expected);
	}

	public function testBuildQueryBelongsToAndHabtm() {
		$this->filter->queryData = array(
			'Post.title' => 'Post',
			'User.name' => 'Jane', // belongsTo
			'Tag.tag' => 'good',   // hasAndBelongsToMany
		);
		$expected = array(
			'Post' => array(
				'conditions' => array(
					'Post.title LIKE' => '%Post%',
					'User.name LIKE' => '%Jane%',
				),
				'joins' => array(
					array(
						'table' => 'posts_tags',
						'alias' => 'PostsTag',
						'type' => 'INNER',
						'foreignKey' => false,
						'conditions' => array(
							'Post.id = PostsTag.post_id',
						),
					),
					array(
						'table' => 'tags',
						'alias' => 'Tag',
						'type' => 'INNER',
						'foreignKey' => false,
						'conditions' => array(
							'Tag.id = PostsTag.tag_id',
							'Tag.tag' => array(
								'good',
							),
						),
					),
				),
				'group' => array(
					'Post.id',
				),
			),
		);
		$model = $this->controller->{$this->controller->modelClass};
		$result = $this->filter->buildQuery($model);
		$this->assertEqual($result, $expected);
	}

	public function testBuildQueryHabtmAndHasMany() {
		$this->filter->queryData = array(
			'Tag.tag' => 'good',
			'Comment.content' => 'short'
		);
		$expected = array(
			'Post' => array(
				'joins' => array(
					array(
						'table' => 'posts_tags',
						'alias' => 'PostsTag',
						'type' => 'INNER',
						'foreignKey' => false,
						'conditions' => array(
							'Post.id = PostsTag.post_id',
						),
					),
					array(
						'table' => 'tags',
						'alias' => 'Tag',
						'type' => 'INNER',
						'foreignKey' => false,
						'conditions' => array(
							'Tag.id = PostsTag.tag_id',
							'Tag.tag' => array(
								'good',
							),
						),
					),
					array(
						'table' => 'comments',
						'alias' => 'Comment',
						'type' => 'INNER',
						'conditions' => array(
							'Post.id = Comment.post_id',
						),
					),
				),
				'group' => array(
					'Post.id',
				),
				'conditions' => array(
					'Comment.content LIKE' => '%short%',
				),
			),
		);
		$model = $this->controller->{$this->controller->modelClass};
		$result = $this->filter->buildQuery($model);
		$this->assertEqual($result, $expected);
	}

	public function testBuildQueryWithVirtualField() {
		$this->filter->queryData = array(
			'Post.range_start' => '2010-11-01',
			'Post.range_end' => '2010-11-05',
		);
		$expected = array(
			'Post' => array(
				'conditions' => array(
					'Post.created >=' => '2010-11-01',
					'Post.created <=' => '2010-11=05',
				)
			)
		);
		/**
		 * Maybe add FilterComponent::$virtualFieldDefinitions and use FilterComponent::$virtualFields
		 * for field mappings.
		 */
		$this->filter->virtualFields = array(
			'range' => array(
				'mapped_field' => 'Post.created',
				'fields' => array(
					'start' => array(
						'type' => 'date',
						'operator' => '>=',
					),
					'end',
				)
			)
		);
		$model = $this->controller->{$this->controller->modelClass};
		$result = $this->filter->buildQuery($model);
		$this->assertEqual($result, $expected);
	}

	public function testBuildRedirectUrl() {
		$this->filter->queryData = array(
			'Post.title' => 'Post',
			'User.name' => 'Jane', // belongsTo
			'Tag.tag' => 'good',   // hasAndBelongsToMany
			'Comment.content' => 'short' // hasMany
		);
		$expected = array(
			'action' => 'index',
			'Comment.content' => 'short',
			'controller' => 'filter_test',
			'plugin' => null,
			'Post.title' => 'Post',
			'Tag.tag' => 'good',
			'User.name' => 'Jane',
		);
		$this->controller->action = 'index';
		$result = $this->filter->buildRedirectUrl();
		$this->assertEqual($result, $expected);
	}

	public function testCollectNamedParams() {
		$this->controller->params['named'] = array(
			'Post.title' => 'Post',
			'page' => 3,
			'direction' => 'asc',
			'User.name' => 'Jane',
		);
		$expected = array(
			'Post.title' => 'Post',
			'User.name' => 'Jane',
		);
		$this->filter->collectNamedParams();
		$result = $this->filter->queryData;
		$this->assertEqual($result, $expected);
	}

	public function testCollectNamedParamsWithFakeModel() {
		$this->controller->params['named'] = array(
			'Fakemodel.some_field' => 'blah',
		);
		$model = 'Fakemodel';
		$expected = array();
		$this->expectError(sprintf(__('Model %s is not an object of Controller::$modelClass', true), $model));
		$this->filter->collectNamedParams();
		$result = $this->filter->queryData;
		$this->assertEqual($result, $expected);
	}

	public function testCollectNamedParamsWithFakeFields() {
		$this->controller->params['named'] = array(
			'fake_field' => 'blah',
			'User.fake_field' => 'bleh',
		);
		$expected = array();
		$this->filter->collectNamedParams();
		$result = $this->filter->queryData;
		$this->assertEqual($result, $expected);
	}

	public function testCollectNamedParamsPaginateFields() {
		$this->controller->params['named'] = array(
			'direction' => 'desc',
			'limit' => 20,
			'page' => 1,
			'sort' => 'name',
		);
		$expected = array(
			'direction' => 'desc',
			'limit' => 20,
			'page' => 1,
			'sort' => 'name',
		);
		$this->filter->collectNamedParams();
		$result = $this->filter->paginateData;
		$this->assertEqual($result, $expected);
	}

	public function testCollectNamedParamsWithIgnoredField() {
		$this->controller->params['named'] = array(
			'Post.name' => 'Jane',
		);
		$this->filter->ignoredFields[] = 'Post.name';
		$expected = array();
		$this->filter->collectNamedParams();
		$result = $this->filter->queryData;
		$this->assertEqual($result, $expected);
	}

	public function testCollectPostData() {
		$this->controller->data = array(
			'Post' => array(
				'title' => 'Post',
			),
			'User' => array(
				'name' => 'Jane',
			),
		);
		$expected = array(
			'Post.title' => 'Post',
			'User.name' => 'Jane',
		);
		$this->filter->collectPostData();
		$result = $this->filter->queryData;
		$this->assertEqual($result, $expected);
	}

	public function testCollectPostDataWithFakeModel() {
		$this->controller->data = array(
			'FakeModel' => array(
				'name' => 'Jane',
			),
		);
		$expected = array();
		$this->filter->collectPostData();
		$result = $this->filter->queryData;
		$this->assertEqual($result, $expected);
	}

	public function testCollectPostDataWithFakeField() {
		$this->controller->data = array(
			'Post' => array(
				'fake_field' => 'blah',
			),
		);
		$expected = array();
		$this->filter->collectPostData();
		$result = $this->filter->queryData;
		$this->assertEqual($result, $expected);
	}

	public function testCollectPostDataWithIgnoredField() {
		$this->controller->data = array(
			'Post' => array(
				'title' => 'Post',
			),
		);
		$this->filter->ignoredFields[] = 'Post.title';
		$expected = array();
		$this->filter->collectPostData();
		$result = $this->filter->queryData;
		$this->assertEqual($result, $expected);
	}

	public function testCollectPostDataWithEmptyField() {
		$this->controller->data = array(
			'Post' => array(
				'title' => 'John',
				'created' => '',
			),
		);
		$expected = array(
			'Post.title' => 'John',
		);
		$this->filter->collectPostData();
		$result = $this->filter->queryData;
		$this->assertEqual($result, $expected);
	}

	public function testParseDotFieldAssociatedModel() {
		$test = 'Tag.tag';
		$expected = array(
			'model' => 'Tag',
			'field' => 'tag',
		);
		$result = $this->filter->parseDotField($test);
		$this->assertEqual($result, $expected);
	}

	public function testParsDotFieldNoModel() {
		$test = 'title';
		$expected = array(
			'model' => $this->controller->modelClass,
			'field' => 'title',
		);
		$result = $this->filter->parseDotField($test);
		$this->assertEqual($result, $expected);
	}

	public function testParseDotFieldInvalidInput() {
		$test = 'foo.bar.baz';
		$this->expectError(sprintf(__('Unable to parse field %s', true), $test));
		$this->filter->parseDotField($test);
		$test = 'FakeModel.name';
		$model = 'FakeModel';
		$this->expectError(sprintf(__('Model %s is not an object of Controller::$modelClass', true), $model));
		$this->filter->parseDotField($test);
	}

	public function testProcessForQuery() {
		$this->filter->queryData = array(
			'Post.title' => 'John',
			'Post.created' => 'Nov 1',
		);
		$expected = array(
			'Post.title' => 'John',
			'Post.created' => '2010-11-01',
		);
		$this->filter->processForQuery();
		$result = $this->filter->queryData;
		$this->assertEqual($result, $expected);
	}

	public function testSanitizeForQuery() {
		$this->filter->queryData = array(
			'Post.content' => '!@#$%^&*()?/\\[]{}|:;<>',
			'Post.created' => '2010-10-31 15:30:00',
		);
		$expected = array(
			'Post.content' => '!@#$%^&*()?/\\\\[]{}|:;<>',
			'Post.created' => '2010-10-31 15:30:00',
		);
		$this->filter->sanitizeForQuery();
		$result = $this->filter->queryData;
		$this->assertEqual($result, $expected);
	}

	public function testSanitizeForQueryWithoutSanitize() {
		$this->filter->queryData = array(
			'Post.content' => '!@#$%^&*()?/\\[]{}|:;<>',
			'Post.created' => '2010-10-31 15:30:00',
		);
		$expected = array(
			'Post.content' => '!@#$%^&*()?/\\[]{}|:;<>',
			'Post.created' => '2010-10-31 15:30:00',
		);
		$this->filter->sanitizeForQuery = false;
		$this->filter->sanitizeForQuery();
		$result = $this->filter->queryData;
		$this->assertEqual($result, $expected);
	}

	public function testSanitizeForQueryWithFormattedField() {
		$this->filter->queryData = array(
			'Post.created' => '2010-10-31 15:30:00',
		);
		$expected = array(
			'Post.created' => '2010-10-31 15:30:00',
		);
		$this->filter->formattedFields = array(
			'Post.created' => '/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/',
		);
		$this->filter->sanitizeForQuery();
		$result = $this->filter->queryData;
		$this->assertEqual($result, $expected);
	}

	public function testSanitizeForRedirect() {
		// urlencode = true, sanitizeForRedirect = true
		$this->filter->queryData = array(
			'Post.created' => '2010-10-31 15:30:00',
		);
		$expected = array(
			'Post.created' => '2010-10-31%2015%3A30%3A00',
		);
		$this->filter->sanitizeForRedirect();
		$result = $this->filter->queryData;
		$this->assertEqual($result, $expected);
	}

	public function testSanitizeForRedirectWithoutSanitizie() {
		// urlencode = true, sanitizeForRedirect = false
		$this->filter->queryData = array(
			'Post.content' => '<p>some html</p>',
		);
		$expected = array(
			'Post.content' => '%3Cp%3Esome%20html%3C%2Fp%3E',
		);
		$this->filter->sanitizeForRedirect = false;
		$this->filter->sanitizeForRedirect();
		$result = $this->filter->queryData;
		$this->assertEqual($result, $expected);
	}

	public function testSanitizeForRedirectWithoutUrlEncode() {
		// urlencode = false, sanitizeForRedirect = true
		$this->filter->queryData = array(
			'Post.created' => '2010-10-31 15:30:00',
		);
		$expected = array(
			'Post.created' => '2010-10-31 15:30:00',
		);
		$this->filter->urlencode = false;
		$this->controller->action = 'index';
		$this->filter->sanitizeForRedirect();
		$result = $this->filter->queryData;
		$this->assertEqual($result, $expected);
	}

	public function testSanitizeForRedirectRemovesHtml() {
		// urlencode = true, sanitizeForRedirect = false
		$this->filter->queryData = array(
			'Post.content' => '<p>some html</p>',
		);
		$expected = array(
			'Post.content' => 'some%20html',
		);
		$this->filter->sanitizeForRedirect();
		$result = $this->filter->queryData;
		$this->assertEqual($result, $expected);
	}

	public function testSanitizeForRedirectFormattedField() {
		// urlencode = true, sanitizeForRedirect = true
		$this->filter->queryData = array(
			'Post.created' => '2010-10-31 15:30:00',
		);
		$expected = array(
			'Post.created' => '2010-10-31 15:30:00',
		);
		$this->filter->formattedFields = array(
			'Post.created' => '/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/',
		);
		$this->filter->sanitizeForRedirect();
		$result = $this->filter->queryData;
		$this->assertEqual($result, $expected);
	}

}
?>