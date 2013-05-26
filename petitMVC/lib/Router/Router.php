<?php

namespace lib\Router;

use lib\Router\Map;

/**
 * Router analyse the http request,
 * deduce the right controller to instantiate and which method to instanciate.
 * @author Olivier Roquigny
 */
class Router{

	/**
	 * the value of the route
	 * @var int
	 */
	public $route = 0;

	/**
	 * an array of routes
	 * @var array
	 */
	public $map;

	/**
	 * Init the current route from the url request
	 */
	public function __construct(){
		if(true === isset($_GET['route']) && $_GET['route'] !== ''){
			$this->route  = (int)$_GET['route'];
		}
		$this->setMap();
		try{
			$message = 'No router found: ';
			if( ! isset($this->map)){
				$message .= 'Map not defined!...';
				throw new Exception($message);
			}else if( ! isset($this->map[$this->route])){
				// TODO : default to 404
				$message .= 'no router ' . $this->route . ' into the map!...';
				throw new Exception($message);
			}
		}catch(Exception $e){
			echo htmlentities($e->getMessage(), ENT_QUOTES, 'utf-8') . "\n";
		}
	}

	/**
	 * get from route the controller class name 
	 * @return string or false
	 */
	public function getActionClass(){
		if(isset($this->map[$this->route]['controller']) && isset($this->map[$this->route]['controller']['class'])){
			return $this->map[$this->route]['controller']['class'];
		}else{
			return false;
		}
	}

	/**
	 * Get from route the controller method name to execute
	 * @return string or false
	 */
	public function getActionMethod(){
		if(isset($this->map[$this->route]['controller']) 
		 && is_array($this->map[$this->route]['controller']) 
		 && isset($this->map[$this->route]['controller']['method'])){ 
			return $this->map[$this->route]['controller']['method'];
		}else{
			return false;
		}
	}

	/**
	 * Get the url associated with a route,
	 * @return string or false
	 */
	public function getURL($route){
		if(isset($this->map[(int)$route]) && isset($this->map[(int)$route]['url'])){
			return $this->map[(int)$route]['url'];
		}else{
			return false;
		}
	}

	/**
	 * Set the map from Map class
	 */	
	public function setMap(){
		$map = new Map();
		$this->map = $map->getMap();
	}

	/**
	 * get the map
	 * @return array
	 */		
	public function getMap(){
		return $this->map;
	}
}
