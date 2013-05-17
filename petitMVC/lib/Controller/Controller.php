<?php

namespace Controller;

use Router\Router;

/**
 * Controller is a generic class extended by personnalised controllers.
 * @author Olivier Roquigny
 */
abstract class Controller{
	public $router;
	public $view;
	public $model;


	public function __construct($router){
		$this->router = $router;
	}
}
