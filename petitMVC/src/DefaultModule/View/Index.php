<?php

namespace DefaultModule\View;

use View\View;

class Index extends View{
	
	protected $layoutPath = 'src/DefaultModule/View/Layout/';
	protected $paragraphes;

	public function render(){
		$this->setStyles(array('css/default.css'));
		$this->setContent($this->getContent());

		parent::render();
	}

	protected function getContent($indent = ''){

		$this->paragraphes = $this->controller->model->getData();

		$content = $this->getTemplate($this->layoutPath . 'index-layout.php');
		
		return $content;
	}
}
