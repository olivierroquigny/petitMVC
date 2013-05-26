<?php

namespace lib\Controller;

use lib\Router\Router;

/**
 * FrontController is loaded first, 
 * it load the router, select which controller to load, and load it.
 * @author Olivier Roquigny
 */
class FrontController{
	private $router;
	private $action;

	public function __construct($router = null){

		if($router === null){
			$this->router = new Router();
		}else{
			$this->router = $router;
		}
		
		// if availlable, load the class and his action method
		$class = $this->router->getActionClass();
		if(false !== $class){
			$this->action = new $class($this->router);
			$method = $this->router->getActionMethod();
			if(false !== $method){
				$this->action->{$method}();
			}
		}
	}
}
