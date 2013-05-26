<?php

namespace src\DefaultModule\Controller;

use lib\Controller\Controller;
use src\DefaultModule\Model\Index as ModelIndex;
use src\DefaultModule\View\Index as ViewIndex;

class Index extends Controller{

	public function __construct($router){
		parent::__construct($router);
	}
	
	public function showIndex(){
		$this->model = new ModelIndex();
		$this->view = new ViewIndex(
			$this, 
			array(
				'layout' => array(
					'file' => 'layout.php',
				),
			)
		);
		$this->view->render();
	}
}
