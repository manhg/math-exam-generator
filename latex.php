<?php 
function latex($text, $addtion = "", $style = "") {	
	$addtion = "\gammacorrection{2}$addtion";
	preg_match_all("|<m>(.*?)</m>|", $text, $regs, PREG_SET_ORDER);
	foreach ($regs as $math) {
		$t = str_replace('<m>','',$math[0]);
		$t = str_replace('</m>','',$t);		
		$code = sprintf("<img class='latex' src='%s?$addtion%s' %s align='middle' alt='' />", LATEX_URL, trim($t), empty($style) ? '' : $style);
		$text = str_replace($math[0], $code, $text);
	}
	$text = nl2br($text);
	return $text;
}