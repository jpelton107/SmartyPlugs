<?php
/*
 * adds commas, and decimal to number
 */
function smarty_modifier_commify($string, $decimals=-1, $dec_point='.', $thousands_sep=',')
{
	if ($decimals == -1) {
		if (preg_match('/(.*)\.(\d+.*)/', $string, $matches)) 
			return number_format($matches[1], 0, $dec_point, $thousands_sep) . $dec_point . $matches[2];
		else 
			return number_format($string);
	}
	else 
		return number_format($string, $decimals, $dec_point, $thousands_sep);
}
?>
