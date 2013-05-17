<?php

namespace Filter;

/**
 * FileInclude test file inclusion
 * @author Olivier Roquigny
 */
class FileInclude{

	/**
	 * test if a file with is path is really in the INCLUDE_PATH of the app
	 * @param path
	 *   the path of the file
	 * @param filename
	 *   the name of the file
	 * @return the realpath of the file if the test is ok, false otherwise. 
	 */
	static public function testPath($file){
		$realPathFile = realpath(INCLUDE_PATH . $file);
		// TODO remove comment
		//echo "<br>\n" . 'FileInclude::testPath: file: ' . $file . "<br>\n" . 'realPathFile: ' . $realPathFile . "<br>\n" ;
		if(0 !== strncmp(INCLUDE_PATH, $realPathFile, count(INCLUDE_PATH))){
			// is somebody trying to inject a non desired file ?... 
			return false;
		}else{
			return $realPathFile;
		}
	}

}
