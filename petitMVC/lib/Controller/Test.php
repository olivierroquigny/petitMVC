<?php

namespace Controller;

class Test{

	public function __construct(){
		try{
			throw new \Exception('exception de test ...');
		}catch(\Exception $e){
			echo $e->getMessage();
		}
	}
}
