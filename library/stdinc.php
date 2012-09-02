<?php 
$adHeading = '#A5C6E4';
$adRow1    = '#E6F3F7';
$adRow2    = '#F5F5F5';

$adLiteGreen = '#C0FFC0';
$adLiteRed   = '#FFC0C0';


function mysql_entities_fix_string($string)
{
  return htmlentities(mysql_fix_string($string));
}


function mysql_fix_string($string)
{
  if (get_magic_quotes_gpc()) $string = stripslashes($string);
	return mysql_real_escape_string($string);
}


function sanitiseString($var) 
{
  $var = stripslashes($var);
	$var = htmlentities($var);
	$var = strip_tags($var);
	
	return $var;
}


function sanitiseMySQL($var)
{
  $var = mysql_real_escape_string($var);
	$var = sanitiseString($var);
	
	return $var;
}


?>
