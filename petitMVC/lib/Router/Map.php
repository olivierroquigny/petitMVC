<?php

namespace Router;

/**
 * Map is where the routing infos are.
 * @author Olivier Roquigny
 */
class Map{
	/**
	 * this array list the actions as controller & method to execute for a route
	 * @var array
	 */
	public $map = array(
		0 => array(
			'menu' => 'Home',
			'url' => 'home-0.php',
			'action' => array(
				'class' => 'DefaultModule\Controller\Index', 
				'method' => 'showIndex', 
			),
		),

	);

	/**
	 * return the routing map.
	 * @return array
	 */
	public function getMap(){
		return $this->map;
	}

}
