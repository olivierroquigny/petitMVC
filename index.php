<?php
define('DEBUG_MODE', true);
ini_set('include_path', '.' . DIRECTORY_SEPARATOR . 'petitMVC');
define('INCLUDE_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'petitMVC' . DIRECTORY_SEPARATOR);

require( 'lib' . DIRECTORY_SEPARATOR . 'autoload.php');

use lib\Controller\FrontController;
use lib\Router\Router;
use src\DefaultModule\Router\Map;

try{
	$map = new Map();
	$router = new Router($map);
	$controller = new FrontController($router);
}catch(Exception $e){
	if(DEBUG_MODE){
		echo 'message: ' . $e->getMessage() . "<br>\n";
	}
}
