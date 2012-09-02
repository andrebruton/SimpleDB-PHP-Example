<?php

/* Debug only */
// ini_set('display_errors', 'off');
// define('_PS_DEBUG_SQL_', false);

/* SSL configuration */
// define('_PS_SSL_PORT_',443);

/* Improve PHP configuration to prevent issues */
@ini_set('default_charset', 'utf-8');

/* Correct Apache charset */
header('Content-Type: text/html; charset=utf-8');

/* No settings file? goto installer...*/
if (!file_exists(dirname(__FILE__).'/settings.inc.php'))
{
	$dir = ((is_dir($_SERVER['REQUEST_URI']) OR substr($_SERVER['REQUEST_URI'], -1) == '/') ? $_SERVER['REQUEST_URI'] : dirname($_SERVER['REQUEST_URI']).'/');
	if(!file_exists(dirname(__FILE__).'/../install'))
		die('Error: \'install\' directory is missing');
	Tools::redirect('install', $dir);
}
include(dirname(__FILE__).'/settings.inc.php');

