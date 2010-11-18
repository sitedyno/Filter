<?php
/**
 * Filter Compoent
 *
 * @author		Heath Nail
 * @license		http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package		filter
 * @subpackage	filter.controller.components
 */
class FilterComponent extends Object {


/**
 * Array of actions the component is allowed to filter on.
 *
 * @var array
 * @access public
 */
	public $actions = array('index');

/**
 * If true then assign the query to Controller::$paginate.
 *
 * @var bool
 * @access public
 */
	public $autoAssign = true;

/**
 * Holds the controller object.
 *
 * @var object
 * @access public
 */
	public $controller;

/**
 * Default date format. This can be used to "broaden" the default date query.
 *
 * @var string
 * @access public
 */
	public $defaultDateFormat = 'Y-m-d';

/**
 * Default operator for dates, defaults to >=. Use null for =.
 *
 * @var string
 * @access public
 */
	public $defaultDateOperator = '>=';

/**
 * Default operator for simple queries, defaults to LIKE. Use null for =.
 *
 * @var string
 * @access public
 */
	public $defaultOperator = 'LIKE';

/**
 * Default time format. This can be used to "broaden" the default time query.
 *
 * @var string
 * @access public
 */
	public $defaultTimeFormat = 'H:i';

/**
 * Array of field => regular expression that dictate urlencoding and sanitization.
 *
 * @var array
 * $access public
 */
	public $formattedFields = array();

/**
 * Array of fields that should not be filtered on.
 *
 * @var array
 * @access public
 */
	public $ignoredFields = array();

/**
 * Only checked if redirect is false. Set to true to ignore named params altogether.
 *
 * @var bool
 * @access public
 */
	public $ignoreNamed = true;

/**
 * Array of pagination parameters that should be passed on, but will not be touched/modified.
 *
 * @var array
 * @access public
 */
	public $paginateParams = array(
		'direction',
		'limit',
		'page',
		'sort',
	);

/**
 * Array of values for pagination parameters.
 *
 * @var array
 * @access public
 */
	public $paginateData = array();

/**
 * Array of query data to be passed to Controller::$paginate.
 *
 * @var array
 * @access public
 */
	public $query = array();

/**
 * Array of data collected from named params and/or form data.
 *
 * @var array
 * @access public
 */
	public $queryData = array();

/**
 * If true then redirect and add query data to the new url, makes filters/searches bookmarkable.
 *
 * @var bool
 * @access public
 */
	public $redirect = true;

/**
 * Location to redirect. This will "always" be a CakePHP array based url.
 *
 * @var array
 * @access public
 */
	public $redirectUrl = array();

/**
 * If true then sanitize values for redirect.
 *
 * @var bool
 * @access public
 */
	public $sanitizeForRedirect = true;

/**
 * Settings for Sanitize::clean(), only applies for redirect not for query. Array is passed directly
 * as $options param to Sanitize::clean() see http://api.cakephp.org/class/sanitize#method-Sanitizeclean
 *
 * @var array
 * @access public
 */
	public $sanitizeRedirectSettings = array(
		'remove_html' => true,
	);

/**
 * If true then sanitize values for query.
 *
 * @var bool
 * @access public
 */
	public $sanitizeForQuery = true;

/**
 * Settings for Sanitize::clean(), only applies for query not for redirect. Array is passed directly
 * as $options param to Sanitize::clean() see http://api.cakephp.org/class/sanitize#method-Sanitizeclean
 * Encode is false by default, see (!) http://book.cakephp.org/view/1183/Data-Sanitization
 *
 * @var array
 * $access public
 */
	public $sanitizeQuerySettings = array(
		'encode' => false,
	);

/**
 * Array of settings for this component. This property is for documentation.
 * Possible indexes are as follows:
 * - 'actions' => array('index'),	Array of actions the component is allowed to filter on.
 * - 'autoAssign' => true,			If true then assign the query to Controller::$paginate.
 * - 'defaultOperator' => 'LIKE',	Default operator for simple queries, defaults to LIKE. Use null for =.
 * - 'formattedFields' => array(	Array of field => regular expression that dictate urlencoding and sanitization.
 *    'field' => 'regex',
 *  ),
 * - 'ignoredFields' => array(),	Array of fields that should not be filtered on.
 * - 'ignoreNamed' => true,			Only checked if redirect is false. Set to true to ignore named params altogether.
 * - 'paginateParams' => array(		Array of pagination parameters that should be passed on, but will not be touched/modified.
 *    'direction', 'limit',
 *    'page', 'sort',
 *  ),
 * - 'redirect' => true,				If true then redirect and add query data to the new url, makes filters/searches bookmarkable.
 * - 'sanitizeForRedirect' => true,		If true then sanitize values for redirect.
 * - 'sanitizeRedirectSettings' => array('remove_html' => true),		Settings for Sanitize::clean(), only applies for redirect not for query.
 * - 'sanitizeForQuery' => true,		If true then sanitize values for query.
 * - 'sanitizeQuerySettings' => array(),		Settings for Sanitize::clean(), only applies for query not for redirect.
 * - 'spaceIsWildcard' => true,			If true then treat spaces as SQL wildcards.
 * - 'urlencode' => true,				If true then urlencode before redirect.
 * - 'virtualFields' => array(),		Will be used for range, from, between, possibly date conversions, all (all fields), etc. NOT IMPLEMENTED YET.
 * - 'wrapWildcards' => true,			if true then wrap query value with SQL wildcard.
 *
 * @var array
 * @access public
 */
	public $settings = array(
		'actions' => array('index'),
		'autoAssign' => true,
		'defaultOperator' => 'LIKE',
		'formattedFields' => array(),
		'ignoredFields' => array(),
		'paginateParams' => array(
			'direction',
			'limit',
			'page',
			'sort',
		),
		'redirect' => true,
		'sanitizeForRedirect' => true,
		'sanitizeRedirectSettings' => array('remove_html' => true),
		'sanitizeForQuery' => true,
		'sanitizeQuerySettings' => array(),
		'spaceIsWildcard' => true,
		'urlencode' => true,
		'virtualFields' => array(),
		'wrapWildcards' => true,
	);

/**
 * If true then treat spaces as SQL wildcards.
 *
 * @var bool
 * @access public
 */
	public $spaceIsWildcard = true;

/**
 * Holds the URL for redirection.
 *
 * @var array
 * $access public
 */
	public $url = array();

/**
 * If true then urlencode before redirect.
 *
 * @var bool
 * @access public
 */
	public $urlencode = true;

/**
 * Will be used for range, from, between, possibly date conversions, all (all fields), etc.
 * NOT IMPLEMENTED YET.
 *
 * @var array
 * @access public
 *
 * @todo Iron out the spec/implementation for virtual fields.
 */
	public $virtualFields = array();

/**
 * If true then wrap the query value with SQL wildcard
 *
 * @var bool
 * @access public
 */
	public $wrapWildcards = true;

/**
 * Adds an INNER join to a model's query. Used for hasMany filtering.
 *
 * @param object $model
 * @return array
 * $access protected
 */
	protected function _addInnerJoin(&$model, $hasManyModel) {
		$result = array();
		$hasMany = $model->{$hasManyModel};
		$foreignKey = $model->hasMany[$hasManyModel]['foreignKey'];
		$conditions = array(
			"$model->alias.$model->primaryKey = $hasMany->alias.$foreignKey",
		);
		$result['joins'][] = array(
			'table' => $hasMany->table,
			'alias' => $hasMany->alias,
			'type' => 'INNER',
			'conditions' => $conditions,
		);
		$result['group'] = array("$model->alias.$model->primaryKey");
		return $result;
	}

/**
 * Adds INNER joins to a model's query. Used for HABTM filtering.
 *
 * @param object $model
 * @param string $field Uses dot notation Tag.tag, string without dots is assumed to be of Controller::$modelClass
 * @param array $values Array of values to filter against.
 * @return array
 * @access protected
 */
	protected function _addInnerJoins(&$model, $field, $values) {
		$result = array();
		$fieldParts = $this->_parseDotField($field);
		$habtm = $model->hasAndBelongsToMany[$fieldParts['model']];
		$with = $habtm['with'];
		$joinTable = $habtm['joinTable'];
		$conditionsA = array("{$model->alias}.{$model->primaryKey} = $with.{$habtm['foreignKey']}");
		$result['joins'][] = array(
			'table' => $joinTable,
			'alias' => $with,
			'type' => 'INNER',
			'foreignKey' => false,
			'conditions' => $conditionsA,
		);
		$conditionsB = array(
			"{$model->{$fieldParts['model']}->alias}.{$model->{$fieldParts['model']}->primaryKey} = $with.{$habtm['associationForeignKey']}",
			$field => (array) $values,
		);
		$result['joins'][] = array(
			'table' => $model->{$fieldParts['model']}->table,
			'alias' => $model->{$fieldParts['model']}->alias,
			'type' => 'INNER',
			'foreignKey' => false,
			'conditions' => $conditionsB,
		);
		$result['group'] = array("$model->alias.$model->primaryKey");
		return $result;
	}

/**
 * Wraps the search query in SQL wildcards if FilterComponent::wrapWildcards is true. If FilterComponent::spaceIsWildcard is true spaces will be replaced with SQL wildcard.
 *
 * @param mixed $values String or array of search terms.
 * @return string
 * @access protected
 */
	protected function _addWildcards($values = '') {
		if($this->wrapWildcards || $this->spaceIsWildcard) {
			$wildcard = '%';
			$wildcardPattern = '%%%s%%';
			if(is_array($values)) {
				foreach($values as $key => $value) {
					if($this->wrapWildcards) {
						$values[$key] = sprintf($wildcardPattern, $values[$key]);
					}
					if($this->spaceIsWildcard) {
						$values[$key] = str_replace(' ', $wildcard, $values[$key]);
					}
				}
			}
			if(is_string($values)) {
				if($this->wrapWildcards) {
					$values = sprintf($wildcardPattern, $values);
				}
				if($this->spaceIsWildcard) {
					$values = str_replace(' ', $wildcard, $values);
				}
			}
		}
		return $values;
	}

/**
 * If autoAssign is true, assign the query to Controller::$paginate.
 *
 * @return void
 * @access protected
 */
	protected function _assignQuery() {
		if($this->autoAssign) {
			$this->controller->paginate = $this->query;
		}
	}

/**
 * Called after controller execution and before rendering. Reset post data here to preserver form data.
 *
 * @param object $controller The controller object.
 * @return void
 * @access public
 */
	public function beforeRender(&$controller) {
		$this->_setPostData($controller);
	}

/**
 * Build the query.
 *
 * @return
 * @access public
 *
 * @todo Implement virtual fields.
 */
	public function buildQuery(&$model) {
		foreach($this->queryData as $modelField => $value) {
			if(!$modelFieldParts = $this->_parseDotField($modelField)) {
				continue;
			}
			$modelName = $modelFieldParts['model'];
			$field = $modelFieldParts['field'];
			$queryField = $this->_setOperator($modelField);
			switch(true) {
				case $modelName == $model->alias: // query on a field of the main model
					$this->query[$modelName]['conditions'][$queryField] = $this->_addWildcards($value);
					break;
				case isset($model->belongsTo[$modelName]):
					$this->query[$modelName]['conditions'][$queryField] = $this->_addWildcards($value);
					break;
				case isset($model->hasAndBelongsToMany[$modelName]):
					if(!isset($this->query[$model->alias])) {
						$this->query[$model->alias] = array();
					}
					$this->query[$model->alias] = array_merge_recursive($this->query[$model->alias], $this->_addInnerJoins($model, $modelField, $value));
					break;
				case isset($model->hasMany[$modelName]):
					if(!isset($this->query[$model->alias])) {
						$this->query[$model->alias] = array();
					}
					$this->query[$model->alias] = array_merge_recursive($this->query[$model->alias], $this->_addInnerJoin($model, $modelName));
					$this->query[$model->alias]['conditions'][$queryField] = $this->_addWildcards($value);
					break;
				case isset($model->hasOne[$modelName]):
					$this->query[$model->alias]['conditions'][$queryField] = $this->_addWildcards($value);
					break;
			}
		}
		if(isset($this->query[$model->alias]['group'])) {
			$this->query[$model->alias]['group'] = array_unique($this->query[$model->alias]['group']);
		}
		foreach($this->paginateParams as $param) {
			if(isset($this->paginateData[$param])) {
				$this->query[$param] = $this->paginateData[$param];
			}
		}
		return $this->query;
	}

/**
 * Builds the URL for redirection and sorts the URL fields by alpha.
 *
 * @return
 * @access protected
 */
	protected function _buildRedirectUrl() {
		$sanitized = array(
			'field' => null,
			'value' => null,
		);
		$this->url = array(
			'controller' => Inflector::underscore($this->controller->name),
			'action' => $this->controller->action,
			'plugin' => $this->controller->plugin,
		);
		foreach($this->queryData as $namedParam => $value) {
			$this->url[$namedParam] = $value;
		}
		ksort($this->url);
		return $this->url;
	}

/**
 * Add named params to Filter::$queryData while ignoring ignoredFields.
 *
 * @return void
 * @access protected
 */
	protected function _collectNamedParams() {
		if(!$this->redirect && $this->ignoreNamed) {
			return;
		}
		$parameters = $this->controller->params['named'];
		foreach($this->paginateParams as $param) {
			if(isset($parameters[$param])) {
				$this->paginateData[$param] = $parameters[$param];
			}
		}
		foreach($parameters as $param => $value) {
			extract($this->_parseDotField($param));
			$modelObject = $this->controller->{$this->controller->modelClass};
			if($model === $modelObject->alias) {
				$columnTypes = $modelObject->getColumnTypes();
			} elseif(isset($modelObject->{$model}) && is_object($modelObject->{$model})) {
				$columnTypes = $modelObject->{$model}->getColumnTypes();
			}
			if(!in_array($field, $this->ignoredFields) && isset($columnTypes[$field])) {
				$this->queryData[$param] = $value;
			}
		}
	}

/**
 * Add Controller::$data fields to Filter::$queryData while ignoring ignoredFields.
 *
 * @return void
 * @access protected
 */
	protected function _collectPostData() {
		if(!empty($this->controller->data)) {
			$modelObject = $this->controller->{$this->controller->modelClass};
			foreach($this->controller->data as $model => $fields) {
				$columnTypes = array();
				if($model === $modelObject->alias) {
					$columnTypes = $modelObject->getColumnTypes();
				} elseif(isset($modelObject->{$model}) && is_object($modelObject->{$model})) {
					$columnTypes = $modelObject->{$model}->getColumnTypes();
				}
				foreach($fields as $field => $value) {
					$dotField = $model . '.' . $field;
					if(!in_array($dotField, $this->ignoredFields) && isset($columnTypes[$field])) {
						if(is_array($value) && !is_null($result = $modelObject->deconstruct($field, $value))) {
							switch($columnTypes[$field]) {
								case 'datetime':
								case 'timestamp':
								case 'date':
									$result = date($this->defaultDateFormat, strtotime($result));
									break;
								case 'time':
									$result = date($this->defaultTimeFormat, strtotime($result));
							}
							$value = $result;
						}
						$this->queryData[$dotField] = $value;
					}
				}
			}
		}
	}

/**
 * Initializes the component and assigns settings.
 *
 * @return void
 * @access public
 */
	public function initialize(&$controller, $settings = array()) {
		$this->_set($settings);
		$this->controller = $controller;
		if($this->sanitizeForQuery || $this->sanitizeForRedirect) {
			if(!class_exists('Sanitize')) {
				App::import('Sanitize');
			}
		}
	}

/**
 * Splits a field by dots. Returns an array('model' => '', 'field' => '')
 *
 * @param string $field
 * @return array Array with model and field or array of null values on failure.
 * @access protected
 */
	protected function _parseDotField($field) {
		$parts = explode('.', $field);
		$count = count($parts);
		$modelClass = $this->controller->modelClass;
		if($count < 1 || $count > 2) {
			trigger_error(sprintf(__('Unable to parse field %s', true), $field), E_USER_ERROR);
			return false;
		}
		if($count > 1) {
			$model = $parts[0];
			$field = $parts[1];
		} else {
			$model = $modelClass;
			$field = $parts[0];
		}
		// should this really throw an error?...
		if(
			$model !== $modelClass
			&& (
				!isset ($this->controller->{$modelClass}->{$model})
				|| !is_object($this->controller->{$modelClass}->{$model})
			)
		) {
			trigger_error(sprintf(__('Model %s is not an object of Controller::$modelClass', true), $model), E_USER_ERROR);
			//return false;
			return array('model' => null, 'field' => null);
		}
		return array(
			'model' => $model,
			'field' => $field,
		);
	}

/**
 * Sanitizes all values for query/SQL while checking for virtual & formatted fields.
 *
 * @return void
 * @access protected
 *
 * @todo Implement virtual fields.
 */
	protected function _sanitizeForQuery() {
		foreach($this->queryData as $field => $value) {
			$result = array($field, $value);
			if($this->sanitizeForQuery && isset($this->formattedFields[$field])) {
				if(0 === preg_match($this->formattedFields[$field], $value, $matches)) {
					// no matches, remove the field
					unset($this->queryData[$field]);
					continue;
				}
				$sanitized = Sanitize::clean($matches, $this->sanitizeQuerySettings);
				foreach($matches as $key => $sanitizedValue) {
					$value = str_replace($sanitizedValue, $sanitized[$key], $value);
				}
				$this->queryData[$field] = $value;
			}
			if($this->sanitizeForQuery && isset($this->virtualFields[$field])) {
				trigger_error(__('Virtual Fields not implemented', true), E_USER_ERROR);
				continue;
			}
			if($this->sanitizeForQuery) {
				$result = Sanitize::clean($result, $this->sanitizeQuerySettings);
				unset($this->queryData[$field]);
				$this->queryData[$result[0]] = $result[1];
			}
		}
	}

/**
 * Sanitizes all values for the URL, while checking for urlencode, virtual, & formatted fields. Virtual fields and formatted fields that don't match will be removed from FilterComponent::queryData.
 *
 * @return void
 * @access protected
 *
 * @todo Implement virtual fields.
 */
	protected function _sanitizeForRedirect() {
		foreach($this->queryData as $field => $value) {
			$result = array($field, $value);
			if($this->sanitizeForRedirect && isset($this->formattedFields[$field])) {
				if(0 === preg_match($this->formattedFields[$field], $value, $matches)) {
					// no matches, remove the field
					unset($this->queryData[$field]);
					continue;
				}
				unset($matches[0]);
				$sanitized = Sanitize::clean($matches, $this->sanitizeRedirectSettings);
				$sanitized = $this->_urlEncode($sanitized);
				foreach($matches as $key => $sanitizedValue) {
					$value = str_replace($sanitizedValue, $sanitized[$key], $value);
				}
				$this->queryData[$field] = $value;
				continue;
			}
			if($this->sanitizeForRedirect && isset($this->virtualFields[$field])) {
				trigger_error(__('Virtual Fields not implemented', true), E_USER_ERROR);
				continue;
			}
			if($this->sanitizeForRedirect) {
				$result = Sanitize::clean($result, $this->sanitizeRedirectSettings);
				unset($this->queryData[$field]);
				$this->queryData[$result[0]] = $result[1];
			}
			unset($this->queryData[$result[0]]);
			$result = $this->_urlEncode($result);
			$this->queryData[$result[0]] = $result[1];
		}
	}

/**
 * Sets post data to preserve filter entries for the next request.
 *
 * @return void
 * @access protected
 */
	protected function _setPostData(&$controller) {
		if(!empty($this->queryData)) {
			foreach($this->queryData as $modelField => $value) {
				extract($this->_parseDotField($modelField));
				$controller->data[$model][$field] = $value;
			}
		}
	}

/**
 * Sets the operator for the query based on FilterComponent::defaultOperator.
 *
 * @param string $modelField The field being queried.
 * @return string $queryField The modified query field.
 * @access protected
 */
	protected function _setOperator($modelField) {
		if(!is_null($this->defaultOperator)) {
			$queryField = $modelField . ' ' . $this->defaultOperator;
		} else {
			$queryField = $modelField;
		}
		return $queryField;
	}

/**
 * Checks settings and Controller properties. Initiates query or redirect if needed.
 *
 * @return
 * @access public
 */
	public function startup(&$controller) {
		if(!in_array($controller->action, $this->actions)) {
			return;
		}
		$this->controller = $controller;
		if(isset($controller->data['Filter']['reset'])) {
			$controller->data = array();
			return;
		}
		switch (true) {
			case empty($controller->data) && empty($controller->params['named']):
				break;
			case $this->redirect && !empty($controller->data) && !empty($controller->params['named']):
				$this->_collectNamedParams();
				$this->_collectPostData();
				$this->_sanitizeForRedirect();
				$this->_buildRedirectUrl();
				$controller->redirect($this->url);
				break;
			case $this->redirect && !empty($controller->data) && empty($controller->params['named']):
				$this->_collectPostData();
				$this->_sanitizeForRedirect();
				$this->_buildRedirectUrl();
				$controller->redirect($this->url);
				break;
			case $this->redirect && empty($controller->data) && !empty($controller->params['named']):
				$this->_collectNamedParams();
				$this->_sanitizeForQuery();
				$this->buildQuery($controller->{$controller->modelClass});
				$this->_assignQuery();
				break;
			case !$this->redirect && !empty($controller->data) && !empty($controller->params['named']):
				$this->_collectNamedParams();
				$this->_collectPostData();
				$this->_sanitizeForQuery();
				$this->buildQuery($controller->{$controller->modelClass});
				$this->_assignQuery();
				break;
			case !$this->redirect && !empty($controller->data) && empty($controller->params['named']):
				$this->_collectPostData();
				$this->_sanitizeForQuery();
				$this->buildQuery($controller->{$controller->modelClass});
				$this->_assignQuery();
				break;
			case !$this->redirect && empty($controller->data) && !empty($controller->params['named']):
				$this->_collectNamedParams();
				$this->_sanitizeForQuery();
				$this->buildQuery($controller->{$controller->modelClass});
				$this->_assignQuery();
				break;
		}
	}

/**
 * Url encodes the values of an array.
 *
 * @param array
 * @return array
 * @access protected
 */
	protected function _urlEncode($array) {
		if($this->urlencode) {
			foreach($array as $key => $value) {
				if(is_string($value)) {
					// didn't use urlencode because it converts space to +, but from the url + does NOT convert to space
					$array[$key] = rawurlencode($value);
				} else {
					trigger_error(sprintf(__('This function does not handle multi dimentional arrays $key: %s $value: %s', true), $key, print_r($value, true)), E_USER_ERROR);
				}
			}
		}
		return $array;
	}

}
