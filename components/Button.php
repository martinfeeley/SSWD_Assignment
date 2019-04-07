<?php

class Button{
	private $name;
	private $value;
	private $text;
	private $classList = 'btn btn-primary';
	public function __construct($name, $value = null, $text = null){
		$this->name = $name;
		$this->value = isset($value) ? $value :  $name;
		$this->text = isset($text) ? $text : $this->value;
	}
	public function getName(){
		return $this->name;
	}
	public function setName($name){
		$this->name = $name;
	}
	public function getValue(){
		return $this->value;
	}
	public function setValue($value){
		$this->value = $value;
	}
	public function getText(){
		return $this->text;
	}
	public function setText($text){
		$this->text = $text;
	}
	public function getClassList(){
		return $this->classList;
	}
	public function setClassList($classList){
		$this->classList = $classList;
	}
	public function render(){
		echo $this->getHTMLString();
	}
	public function getHTMLString(){
		$output = 
		"<button 
			type='submit' 
			class='$this->classList'
			name='$this->name'
			value='$this->value'
		>$this->text</button>";

		return $output;
	}
}
