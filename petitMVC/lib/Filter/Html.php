<?php

namespace lib\Filter;

/**
 * Filter input for html uses.
 * @author Olivier Roquigny
 */
class Html{

	/**
	 * Test a string against a regex, 
	 * throw an exception if it matches a char who is something else than alnum, space, underscore, hyphen.
	 * @param str
	 *   the string to test
	 * @return string if test is ok
	 * @throw Exception if test is false
	 */
	public static function filterAttName($str){
		$pattern = '/[^a-zA-Z0-9 _-]/';

		if(preg_match($pattern, $str)){
			throw new Exception('Filter\Html::filterAttributVal: forbidden character in value! you can just use alnum dash(-), underscore(_) and space...');
		}

		return $str;
	}
	
	/**
	 * Test a string against a regex which can be a param or a default one,
	 * throw an exception if it matches the regex.
	 * @param str
	 *   the string to test
	 * @param pattern
	 *   the pattern for the regex
	 * @return string 
	 *   if test is ok
	 * @throw Exception 
	 *   if test is false
	 */
	public static function filterAttVal($str, $pattern = '/[^a-zA-Z0-9 _-]/'){
		if(preg_match($pattern, $str)){
			throw new Exception('Filter\Html::filterVal: forbidden character in value!...');
		}

		return $str;
	}

	/**
	 * Encode a full url, differently than urlencode,
	 * all below 33 Ascii, up to 126 Ascii, or in $unwanted are encoded
	 * @param url
	 *   the string to encode
	 * @return string
	 */
	public static function encodeFullURL($url){
		// " = 34, < = 60, > = 62, \ = 92, ^ = 94, ` = 96, { = 123, | = 124, } = 125

		$unwanted = array(34,60,62,92,94,96,123,124,125);
		$encodedURL = '';
		$length = strlen($url);
		for($i=0;$i<$length;$i++){
			$code = ord($url[$i]);
			if($code < 33 || $code > 126 || in_array($code,$unwanted)){
				if($code<10){
					$encodedURL .= '%0' . bin2hex($url[$i]); // TODO : sprintf ???
				}else{
					$encodedURL .= '%' . bin2hex($url[$i]);
				}
			}else{
				$encodedURL .= $url[$i];
			}
		}

		return $encodedURL;
	}
	
	/**
	 * @TODO
	 * validate a string as a valid tag
	 * @param tag
	 * @return boolean
	 */
	public static function validTag($tag){
		return false;
	}
	
	/**
	 * @TODO
	 * validate a string as a valid attribut name
	 * @param attrib
	 * @return boolean
	 */
	public static function validAttribName($attrib){
		return false;
	}
	
	/**
	 * @TODO
	 * validate a string as a valid attribut content
	 * @param content
	 * @return boolean
	 */
	public static function validAttribContent($content){
		return false;
	}
	
	/**
	 * @TODO
	 * filter a string as attribut content
	 * @param content
	 * @return string
	 */
	public static function filterAttribContent($content){
		return '';
	}
	
	/**
	 * @TODO
	 * filter a string as a valid tag content
	 * @param content
	 * @return string
	 */
	public static function filterContent($content){
		return '';
	}
}
