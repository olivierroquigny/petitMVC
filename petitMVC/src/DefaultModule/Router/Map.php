<?php

namespace src\DefaultModule\Router;

use lib\Router\Map as DefaultMap;

class Map extends DefaultMap{
	protected $map = array(
		0 => array(
			'menu' => 'Home',
			'url' => 'home-0.php',
			'controller' => array(
				'class' => 'src\DefaultModule\Controller\Index', 
				'method' => 'showIndex', 
			),
		),

	);
}
