<?php

namespace src\DefaultModule\Model;

use lib\Model\Model;

class Index extends Model{
	public $title = 'PetitMVC is a small PHP framework.';
	public $keywords = '';
	public $description = '';
	public $content = '';
	public $paragraphes = array(
		0 => array(
			'title' => 'Welcome in petitMVC!',
			'text' => "PetitMVC is at the beggining, it's work in progress!"
			,
		),
	);
	
	public function getData(){
		return $this->paragraphes;
	}
}
