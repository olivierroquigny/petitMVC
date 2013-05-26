<?php
define('DEBUG_MODE', true);
ini_set('include_path', '.' . DIRECTORY_SEPARATOR . 'petitMVC');
define('INCLUDE_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'petitMVC' . DIRECTORY_SEPARATOR);

require( 'lib' . DIRECTORY_SEPARATOR . 'autoload.php');

use lib\Controller\FrontController;

try{
	$controller = new FrontController();
}catch(Exception $e){
	if(DEBUG_MODE){
		echo 'message: ' . $e->getMessage() . "<br>\n";
	}
}
