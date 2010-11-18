<?php
/**
 * Filter Helper. Keep in mind you are not required to use this helper. Feel free to build your own forms.
 *
 * @author		Heath Nail
 * @license		http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package		filter
 * @subpackage	filter.views.helpers
 *
 * @todo Write tests for FilterHelper...
 */

class FilterHelper extends AppHelper {

/**
 * Array of helpers used by this helper.
 *
 * @var array
 * @access public
 */
	var $helpers = array('Form', 'Paginator');

/**
 * Array of html tag formats
 *
 * @var array
 * @access public
 */
	var $tags = array(
		'tr' => "\n\t<tr%s>%s</tr>\n",
		'th' => "\n\t<th%s>%s</th>\n",
		'td' => "\t\t<td%s>%s</td>\n",
	);

/**
 * Maps field types to db types. Set this in your view and it allows you to determine how dates etc.
 * are rendered by the helper.
 *
 * @var array
 * @access public
 */
	var $typeMappings = array(
		'text' => 'text',	// this looks wierd but db text type normally yields a textarea form input
		'datetime' => 'date',
		'time' => 'time',
	);

/**
 * Returns an Html form element. Assumes defaults that work well for filtering.
 * See http://api.cakephp.org/class/form-helper#method-FormHelpercreate for options.
 *
 * @param string $model The model object which the form is being defined for.
 * @param array $options An array of html attributes and options.
 * @return string A formatted opening form tag
 * @access public
 */
	public function create($model = null, $options = array()) {
		$defaults = array();
		$options = array_merge($defaults, $options);
		return $this->Form->create($model, $options);
	}

/**
 * Closes an html form. For options see http://api.cakephp.org/class/form-helper#method-FormHelperend
 *
 * @param array $options Array of options.
 * @return string A closing form tag along with 2 submit buttons.
 * @access public
 */
	public function end($options = null) {
		$out = '';
		$out.= $this->Form->button(
			__('Filter', true),
			array(
				'type' => 'submit',
				'name' => 'data[Filter][filter]',
			)
		);
		$out.= $this->Form->button(
			__('Reset', true),
			array(
				'type' => 'submit',
				'name' => 'data[Filter][reset]',
			)
		);
		$out.= $this->Form->end($options);
		return $out;
	}

/**
 * Generates a table row of form inputs.
 *
 * @param string $model The model to use when creating the form.
 * @param array $fields Array of fields "Modelname.fieldname".
 * @param array $options Options for the inputs. One array for all fields.
 * @param string $tag Which tag type to use for the columns, th or td.
 * @return string Html row of filter form inputs.
 * @access public
 */
	public function formInputTableRow($model, $fields, $options = array(), $tag = 'td') {
		$out = '';
		$out.= $this->create($model);
		foreach($fields as $field) {
			if(empty($field)) {
				$out.= sprintf($this->tags[$tag], null, '');
				continue;
			}
			$out.= sprintf($this->tags[$tag], null, $this->input($field, $options));
		}
		$out.= sprintf($this->tags[$tag], ' class="actions"', $this->end());
		$out = sprintf($this->tags['tr'], ' class="filters"', $out);
		return $out;
	}

/**
 * Generates a form input element without label and div (just the input element).
 *
 * @param string $fieldName This should be "Modelname.fieldname".
 * @param array $options Options for the input.
 * @return string The completed input.
 * @access public
 */
	public function input($fieldName, $options = array()) {
		$defaults = array(
			'div' => false,
			'label' => false,
			'timeFormat' => '24',
		);
		$options = array_merge($defaults, $options);
		$this->Form->setEntity($fieldName);
		$modelKey = $this->model();
		$fieldKey = $this->field();
		if(!isset($this->Form->fieldset[$modelKey])) {
			// this is likely to break in 2.0 :/
			$this->Form->_introspectModel($modelKey);
		}
		if(isset($this->Form->fieldset[$modelKey]['fields'][$fieldKey]['type'])) {
			$type = $this->Form->fieldset[$modelKey]['fields'][$fieldKey]['type'];
		}
		if(isset($this->typeMappings[$type])) {
			$options['type'] = $this->typeMappings[$type];
		} else {
			$options['type'] = 'text';
		}
		if('id' === $fieldKey) {
			$options['type'] = 'text';
		}
		return $this->Form->input($fieldName, $options);
	}

/**
 * Returns a label element for html forms.
 *
 * @param string $fieldName This should be "Modelname.fieldname".
 * @param string $text Text that will appear in the label field.
 * @param mixed $options An array of html attributes, or a string to be used as a class name.
 * @return string The label element.
 * @access public
 */
	public function label($fieldName = null, $text = null, $options = array()) {
		if(is_null($text)) {
			$this->Form->setEntity($fieldName);
			$modelKey = $this->Form->model();
			$fieldKey = $this->Form->field();
			if($modelKey !== $this->Form->params['models'][0]) {
				$text = $modelKey;
			}
		}
		return $this->Form->label($fieldName, $text, $options);
	}

/**
 * Attempts to extract a model name from a foreign_key.
 *
 * @param string $key The key.
 * @return string The model.
 * @access protected
 */
	protected function _extractModel($key) {
		$return = '';
		if(stristr($key, '_id')) {
			$key = str_ireplace('_id', '', $key);
			if(ClassRegistry::isKeySet($key)) {
				$return = Inflector::humanize($key);
			}
		}
		return $return;
	}

/**
 * Generates a sorting link. See http://api13.cakephp.org/class/paginator-helper#method-PaginatorHelpersort for options
 *
 * @param string $title Title for the link.
 * @param string $key The name of the key.
 * @param array $options Options for the sorting link.
 * @return string A link sorting by default 'asc'.
 * @access public
 */
	public function sort($title, $key = null, $options = array()) {
		$defaults = array(
			'escape' => false,
		);
		$options = array_merge($defaults, $options);
		if(is_null($key)) {
			$model = $this->_extractModel($title);
			if(!empty($model)) {
				$key = $title;
				$title = $model;
			}
		}
		return $this->Paginator->sort($title, $key, $options);
	}

/**
 * Generates a table row of sorting links.
 *
 * @param array $fields Array of fields used to generate the sorting links. The last element of the
 * array should hold the text to be displayed above the submit buttons.
 * @param array $options Array of options passed on to PaginatorHelper::sort(). One array for all fields.
 * @param string $tag Which tag type to use for the columns, th or td.
 * @return string Html table row of pagination links
 * @access public
 */
	public function sortingTableRow($fields, $options = array(), $tag = 'th') {
		$out = '';
		$count = count($fields);
		$counter = 0;
		foreach($fields as $key => $field) {
			if(empty($field)) {
				$out.= sprintf($this->tags[$tag], null, '');
				continue;
			}
			if($counter === $count - 1) {
				$out.= sprintf($this->tags[$tag], ' class="actions"', $field);
			} else {
				$sortkey = $field;
				if(!is_numeric($key)) {
					$field = $key;
				}
				$out.= sprintf($this->tags[$tag], null, $this->sort($field, $sortkey, $options));
			}
			$counter++;
		}
		$out = sprintf($this->tags['tr'], ' class="filters"', $out);
		return $out;
	}
}
?>
