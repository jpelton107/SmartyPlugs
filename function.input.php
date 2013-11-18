<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty input function plugin
 *
 * Type:     function<br>
 * Name:     phone_format<br>
 * Purpose:  generate HTML for forms
 * @author   Joel Pelton
 * params:
 * 	type - text, password, checkbox, radio, select, textarea, submit, number, phone, email, hidden
 * 	name - name of the field
 * 	id - id associated with field (defaults to name)
 * 	class - class associated with field
 * 	value - pre-defined value
 * 	preFilled - preFilled value of the field
 * 	max - maxlength
 * 	options - array - for select type
 * 	width
 * 	selected (for select only)
 * 
 *  - This fills in the field with the value from post global var. If you want to sanitize this first, change $_POST ti _tpl_vars[<CLEANED ARRAY>]
 *  - If no posted information available, it uses the 'user' array to fill in values specific to the user logged in.
 */
function smarty_function_input($params, &$smarty)
{
	// establish vars
	$type = $params['type'];
	$id = !$params['id'] ? $params['name'] : $params['id'];
	$name = $params['name'];
	$max = !$params['max'] ? '64' : $params['max'];
	$preFilled = $_POST;
	$user = $smarty->_tpl_vars['user'];
	$label = $params['label'];
	$placeholder =$params['placeholder'];

	if (preg_match('/(text|password|number|phone|checkbox|radio|email|hidden)/', $type)) {
		$pre = "<input type='".$type."' ";
		if (preg_match('/(text|password|number|phone|email)/', $type)) {
			$size = !$params['size'] ? '20' : $params['size'];
			$val = !$preFilled[$name] ? $params['value'] : $preFilled[$name];
			$pre .= ' size="'.$size.'" maxlength="'.$max.'" value="'.$val.'" ';
			if ($placeholder) {
				$pre .= ' placeholder="'.$placeholder.'" ';
			}
		} elseif (preg_match('/(radio|checkbox)/', $type)) {
			$pre .= " value='".$params['value'] ."' ";
			if ($preFilled[$name] == $params['value']) {
				$pre .= " checked ";
			}
			if ($label) {
				$post = " <label for='".$id."'>".$label."</label>";
			}
		} elseif ($type=='hidden') {
			$pre .= " value='".$params['value']."'";
		}
	} elseif ($type == "select") {
		$pre = "<select ";
		$post = "<option value=''></option>";
		if ($params['options']) {
			foreach($params['options'] as $k => $v) {
				$post .= "<option value='".$k."'";
				if ($k == $preFilled[$name]) {
					$post .= " selected";
				} elseif ($k == $params['selected']) {
					$post .= " selected";
				}
				$post .= ">$v</option>";
			}
		}
		$post .= "</select>";
	} elseif ($type == "textarea") {
		$rows = !$params['rows'] ? '5' : $params['rows'];
		$cols = !$params['cols'] ? '30' : $params['cols'];
		$pre = "<textarea rows='".$rows."' cols='".$cols."' ";
		$val = !$preFilled[$name] ? $params['value'] : $preFilled[$name];
		$post = "$val</textarea>";
	} elseif ($type == "submit") {
		$val = !$params['value'] ? 'Submit' : $params['value'];
		return "<input type='submit' name='submit' value='".$val."'>";
	}

	$pre .= "id='".$id."' name='".$params['name']."' ";
	$class = $params['class'];
	if ($class) {
		$pre .= "class='".$class."' ";
	}
	if ($params['width']) {
		$pre .= " style='width:".$params['width']."px' ";
	}
	if ($smarty->_tpl_vars['View'] || $params['readonly']) {
		$pre .= " readonly ";
	}
	
	$return = $pre . ">" . $post;

	return $return;
}
