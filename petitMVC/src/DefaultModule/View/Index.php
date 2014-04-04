<?php

namespace src\DefaultModule\View;

use lib\View\View;

class Index extends View{
	
	protected $layoutPath = 'src/DefaultModule/View/Layout/';
	protected $paragraphes;

	public function render(){
		$this->setStyles(array('css/default.css'));
		$this->setContent($this->getContent());

		echo parent::render();
	}

	protected function getContent($indent = ''){

		$this->paragraphes = $this->controller->model->getData();

		$content = $this->getTemplate($this->layoutPath . 'index-layout.php');
		
		return $content;
	}
}
