<?php

spl_autoload_register(function($class) {
	if (class_exists($class, FALSE)){
		return;
	}
	
	/*
	$paths = array('lib', 'src');
	for($i=0; $i<count($paths);$i++){
		if($file = realpath(INCLUDE_PATH . $paths[$i] . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php')){
			break;
		}
	}
	*/
	
	$file = realpath(INCLUDE_PATH . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php');
		
	if( ! file_exists($file) || ! is_file($file)){
		$m = 'autoload::File doesn\'t exist!...';
		if(DEBUG_MODE){
			$m .= "<br>\nfile: $file<br>\nclass: $class<br>\ninclude_path: " . INCLUDE_PATH . "<br>\n";
		}
		throw new Exception($m);
	}

	if(0 !== strncmp(INCLUDE_PATH, $file, count(INCLUDE_PATH))){
		// is somebody trying to inject a non desired file ?... 
		throw new Exception('autoload::Forbiden file!...');
	}

	include($file);
});
