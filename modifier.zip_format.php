<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty zip_format modifier plugin
 *
 * Type:     modifier<br>
 * Name:     zip_format<br>
 * Purpose:  format US zip codes longer than 5 digits
 * @author   Joel Pelton
 * 
 * @param string
 * @return string
 */
function smarty_modifier_zip_format($number)
{
	// split #
	preg_match('/^(\d{5})\-?(\d{4})?$/', $number, $split);
	if (!$split) { return; }
	$string = $split[1];
	if ($split[2]) {
		$string .= "-".$split[2];
	}
	return $string;
}

/* vim: set expandtab: */

?>
