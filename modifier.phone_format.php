<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty phone_format modifier plugin
 *
 * Type:     modifier<br>
 * Name:     phone_format<br>
 * Purpose:  format phone numbers (###) ###-#### and allow for Ext
 * @author   Joel Pelton
 * 
 * @param string
 * @return string
 */
function smarty_modifier_phone_format($number)
{
	// split #
	preg_match('/^(\d{3})(\d{3})(\d{4})(\d*)?$/', preg_replace('/[^\d]/', '', $number), $split);
	if (!$split) { return; }
	$string = "(".$split[1].") ".$split[2]."-".$split[3];
	if ($split[4]) {
		$string .= ", Ext. ".$split[4];
	}
	return $string;
}

/* vim: set expandtab: */

?>
