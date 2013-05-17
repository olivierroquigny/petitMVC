<?php

namespace View;

use Filter\FileInclude;

/**
 * Parent class for the personnalised views.
 * @autor Olivier Roquigny
 */
abstract class View{
	protected $layout;
	protected $path;
	protected $model;
	protected $controller;
		
	protected $scripts;
	protected $styles;

	protected $xhtml = false;
	protected $title;
	protected $description;
	protected $keywords;
	protected $content;

	/**
	 * Set controller, model and layout.
	 * @param controller
	 * @param config
	 *   an array to config the view
	 */
	public function __construct($controller, $config = array()){
		$this->controller = $controller;
		$this->model = $controller->model;
		if(isset($config['layout']) && isset($config['layout']['file']) && $config['layout']['file'] != ''){
			$this->layout = $config['layout']['file'];
		}
	}

	/**
	 * render a template
	 */
	public function render(){
		echo $this->getTemplate($this->layoutPath . DIRECTORY_SEPARATOR . $this->layout);
	}

	/**
	 * get a template, interpret it with current view vars and return it
	 * @param filename
	 *   file name with his path to the template
	 * @return string
	 *   the template interpreted
	 */
	protected function getTemplate($filename){
		if( false === ($file = FileInclude::testPath($filename))){
			// is somebody trying to inject a non desired file ?... 
			throw new Exception('View::getTemplate: Forbiden file!...');
		}

		ob_start();
		include $file;
		
		return ob_get_clean();
	}

	/**
	 * set xml like tags
	 * @param value
	 *   boolean
	 * @return current view
	 */
	public function setXhtml($value = true){
		$this->xhtml = $value;

		return $this;
	}

	/**
	 * Set an array of javascript files to load
	 * @param scripts array
	 * @return current view
	 */
	public function setScripts($scripts){
		$this->scripts = $scripts;

		return $this;
	}

	/**
	 * Get the scripts as an (x)html string
	 * @param indent 
	 *   prefix for indentation
	 * @return string
	 */
	protected function getScripts($indent = ''){
		$scripts = '';
		if(isset($this->scripts)){
			foreach($this->scripts as $value){
				$scripts .= $indent . '<script type="text/javascript" src="' . $value . '"></script>' . "\n";
			}
		}

		return $scripts;
	}

	/**
	 * Set an array of css styles files to load
	 * @param styles array
	 * @return current view
	 */
	public function setStyles($styles){
		$this->styles = $styles;

		return $this;
	}

	/**
	 * Get the styles as an (x)html string
	 * @param indent 
	 *   prefix for indentation
	 * @return string
	 */
	protected function getStyles($indent = ''){
		$styles = '';
		if(isset($this->styles)){
			foreach($this->styles as $value){
				$styles .= $indent . '<link rel="stylesheet" type="text/css" href="' . $value . '"';
				if($this->xhtml){
						$styles .= ' /';
				}
				$styles .= ">\n";
			}
		}
		return $styles;
	}

	/**
	 * Get an array to manage a menu
	 * @return array
	 */
	protected function getMenu(){
		return $this->controller->router->map;
	}

	/**
	 * Set the content
	 * @param content string
	 */
	public function setContent($content){
		$this->content = $content;
	}

	/**
	 * Get the content
	 * @param indent
	 *   indentation
	 * @return string
	 */
	protected function getContent($indent = ''){
		if(isset($this->content)){
			return $this->content;
		}else{
			//TODO remove this
			return $this->model->content;
		}
	}

	/**
	 * get an URL from a route
	 * @param route
	 * @return string
	 */
	protected function getURL($route){
		return $this->controller->router->getURL($route);
	}

	/**
	 * Set the html content of the tag title
	 * @param title
	 * @return current View
	 */
	protected function setTitle($title){
		$this->title = $title;
		
		return $this;
	}

	/**
	 * Get the html content of the tag title
	 * @return string
	 */
	protected function getTitle(){
		if(isset($this->title)){
			return $this->title;
		}else{
			return $this->model->title;
		}
	}
	
	/**
	 * Set the html content of the meta tag description
	 * @param description
	 * @return current View
	 */
	protected function setDescription($description){
		$this->description = $description;

		return $this;
	}
	
	/**
	 * Get the html content of the meta tag description
	 */
	protected function getDescription(){
		if(isset($this->description)){
			return $this->description;
		}else{
			return $this->model->description;
		}
	}

	/**
	 * Set the html content of the meta tag keywords
	 * @param keywords
	 * @return current View
	 */
	protected function setKeywords($keywords){
		$this->keywords = $keywords;
		
		return $this;
	}
	
	/**
	 * Get the html content of the meta tag keywords
	 */
	protected function getKeywords(){
		if(isset($this->keywords)){
			return $this->keywords;
		}else{
			return $this->model->keywords;
		}
	}
}
