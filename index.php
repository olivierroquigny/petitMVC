<?php
define('DEBUG_MODE', true);
// TODO include_path => './petitMVC', and prefix classes with lib or src
ini_set('include_path', './petitMVC/lib:./petitMVC/src');
define('INCLUDE_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'petitMVC' . DIRECTORY_SEPARATOR);
require('autoload.php');

use Controller\FrontController;

try{
	$controller = new FrontController();
}catch(Exception $e){
	if(DEBUG_MODE){
		echo 'message: ' . $e->getMessage() . "<br>\n";
	}
}
