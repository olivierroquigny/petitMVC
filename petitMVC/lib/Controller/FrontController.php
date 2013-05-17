<?php

namespace Controller;

use Router\Router;

/**
 * FrontController is loaded first, 
 * it load the router, select which controller to load, and load it.
 * @author Olivier Roquigny
 */
class FrontController{
	private $router;
	private $action;

	public function __construct(){

		$this->router = new Router();
		
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
