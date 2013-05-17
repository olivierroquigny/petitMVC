<?php

namespace DefaultModule\Controller;

use Controller\Controller;
use DefaultModule\Model\Competences;
use DefaultModule\Model\Index as ModelIndex;
use DefaultModule\View\Index as ViewIndex;

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
