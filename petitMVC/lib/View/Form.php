<?php

namespace lib\View;

use lib\Filter\Html;

/**
 * Make an html form
 * @author Olivier Roquigny
 */
class Form{
	protected $xhtml = false;
	protected $charset = 'UTF-8';
	protected $start = '';
	protected $content = '';
	protected $close = '';
	/**
	 * autorized tags
	 */
	protected $tags = array(
			'p' => array(),
			'h1' => array(),
			'br' => array('empty' => true,),
			'input' => array('empty' => true,),
			'label' => array(),
			'button' => array(),
			'textarea' => array(),
			'select' => array(),
			'option' => array(),
			'datalist' => array(),
			'keygen' => array(), 
			'output' => array(),
		);
	/**
	 *  autorized attributs and if needed, their autorized value
	 */
	protected $attributs = array(
			'id' => '',
			'name' => '',
			'type' => array(
				'radio' => array(),
				'text' => array(),
				'password' => array(),
				'button' => array(),
				'image' => array(),
				'file' => array(),
				'submit' => array(),
				'reset' => array(),
				'hidden' => array(),
			),
			'class' => '',
			'size' => '',
			'accesskey' => '',
			'checked' => 'checked',
			'multiple' => 'multiple',
			'disabled' => 'disabled',
			'for' => '',
			'value' => '',
			'maxlength' => '',
			'type' => '',
			'src' => array(
				'encode' => 'encodeFullURL',	
			),
			'accept' => '',
			'cols' => '',
			'alt' => '',
		);

	public $form;

	public function __construct(){
		//TODO Filter::Html instantiable and not static ?
	}
	
	/**
	 * Set attributes to the html form tag
	 * @param attributs array
	 *   array of key => value attributs
	 * @return current Form
	 */
	public function setStart($attributs = array(), $tab = ''){
		$this->start = $tab . '<form';
		try{
			if(isset($attributs['action'])){
				$this->start .= ' action="' . Html::encodeFullURL($attributs['action']) . '"';
			}
			if(isset($attributs['id'])){
				$this->start .= ' id="' . Html::filterAttName($attributs['id']) . '"';
			}
			if(isset($attributs['name'])){
				$this->start .= ' name="' . Html::filterAttName($attributs['name']) . '"';
			}
			if(isset($attributs['accept'])){
				$this->start .= ' accept="' . Html::filterAttVal($attributs['accept'], '/[^a-zA-Z0-9 \/-_]/') . '"';
			}
			if(isset($attributs['accept-charset'])){
				$this->start .= ' accept-charset="' . Html::filterAttName($attributs['accept-charset']) . '"';
			}
			if(isset($attributs['enctype'])){
				$this->start .= ' enctype="' . Html::filterAttVal($attributs['enctype'], '/[^a-zA-Z0-9 \/-_]/') . '"';
			}
			if(isset($attributs['method'])){
				$this->start .= ' method="' . Html::filterAttName($attributs['method']) . '"';
			}
			if(isset($attributs['class'])){
				$this->start .= ' class="' . Html::filterAttName($attributs['class']) . '"';
			}
		}catch(Exception $e){
			//TODO personnalised exceptions
			throw $e;
		}
		$this->start .= '>';
		
		return $this;
	}
	
	/**
	 * Set the end of the html form
	 * @param name
	 *   the id of the form
	 * @param indent
	 *   indentation string
	 * @return current Form
	 */
	public function setEnd($id = '', $indent = ''){
		$this->close = "\n" . $indent . '</form>';
		try{
			if($id !== ''){
				$this->close .= ' <!-- /' . Html::filterAttName($id) . ' -->';
			}
		}catch(Exception $e){
			throw $e;
		}
		$this->close .= "\n";

		return $this;
	}
	/**
	 * Add an element to the form
	 * @param data
	 *   an array of data representing the element and his childs
	 * @param indent
	 *   indentation string
	 * @return current Form
	 */
	public function addElement($data, $indent = ''){
		$this->content .= $this->makeElement($data, $indent);

		return $this;
	}

	/**
	 * Make an html form element, with it's childs, and return it
	 * @param data
	 *   an array of data for make this element
	 * @param indent
	 *   indentation string
	 * @return string
	 *   the html form element
	 */
	public function makeElement($data = array(), $indent = ''){
		$label;
		$element = '';

		if(isset($data['label'])){
			$label = $this->makeElement($data['label'], $indent);
		}

		if( ! array_key_exists($data['tag'], $this->tags)){
			throw new Exception('View\Form::makeElement: Unrecognized tag!...');
		}
		
		$element = "\n" . $indent . '<' . $data['tag'];

		if(isset($data['attributs']) && is_array($data['attributs'])){
			foreach($data['attributs'] as $key => $value){
				if( ! array_key_exists($key, $this->attributs)){
					throw new Exception('View\Form::makeElement: Unrecognized attribut!...');

				}
				try{
					$element .= ' ' . $key . '="' . Html::filterAttVal($value) . '"';
				}catch(Exception $e){
					throw $e;
				}
			}
		}

		if(isset($this->tags[$data['tag']]['empty']) && $this->tags[$data['tag']]['empty']){
			if($this->xhtml){
				$element .= ' /';
			}
			$element .= '>';
		}else{
			$element .= '>';
			if(isset($data['content'])){
				if(isset($data['charset']) && $data['charset'] !== ''){
					try{
						$charset = Html::filterAttName($data['charset']);
					}catch(Exception $e){
						throw $e;
					}
				}else{
					$charset = $this->charset;
				}
				$element .= htmlentities($data['content'], ENT_QUOTES, $charset);
			}
			if(isset($data['childs'])){
				foreach($data['childs'] as $k => $v){
					$element .= $this->makeElement($v, $indent . "\t");
				}
				$element .= "\n" . $indent;
			}
			$element .= '</' . $data['tag'] . '>';
		}

		if(isset($data['label'])){
			if(isset($data['label']['append']) && $data['label']['append']){
				$element = $element . $label;
			}else{
				$element = $label . $element;
			}

		}

		return $element;
	}

	/**
	 * Concat the form and return it
	 * @return string
	 */
	public function getForm(){
		return $this->start . $this->content . $this->close;
	}

	/**
	 * Set the form with all his childs and return it
	 * @param data
	 *   array of attributes as key => value
	 * @return string form
	 */
	public function setForm($data, $indent =''){
		if(isset($data['attributs'])){
			$this->setStart($data['attributs'], $indent);
		}else{
			$this->setStart(array(), $indent);
		}

		if(isset($data['fields'])){
			foreach($data['fields'] as $key => $value){
				$this->addElement($value, "\t" . $indent);
			}
		}

		if(isset($data['attributs'])){
			if(isset($data['attributs']['name'])){
				$this->setEnd($data['attributs']['name'], $indent);
			}else if(isset($data['attributs']['id'])){
				$this->setEnd($data['attributs']['id'], $indent);
			}else{
				$this->setEnd(array(), $indent);
			}
		}else{
			$this->setEnd(array(), $indent);
		}

		return $this->start . $this->content .  $this->close;
	}

	/**
	 * Set if the form is xml style or not
	 * @param xhtml
	 * @return current Form
	 */
	public function setXhtml($xhtml = true){
		$this->xhtml = $xhtml;

		return $this;
	}
}
