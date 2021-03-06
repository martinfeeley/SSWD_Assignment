<?php
class Select{
	private $name; // the name attribute
	private $label; // The text for the label field
	private $options; //array of options
	private $attributes; // array to set things like maxlength, required, etc
	private $data; // data retrieved from GET/POST request
	private $errors; // array of errors to print out
	public function __construct(string $name, string $label, array $options = array(), array $attributes = array()){
		//$this->name  === this.name in java
		$this->name = $name;
		$this->label = $label;			
		$this->options = $options; // labeltext => value
		$this->attributes = $attributes; //attributes are optional
	}
	public function getName(){
		return $this->name;
	}
	public function setName(string $name){
		$this->name = $name;
	}
	public function getData($conn = null){
		if($conn)
			return mysqli_real_escape_string($conn, $this->data);
		return $this->data;
	}
	public function setData($data){
		$this->data = htmlspecialchars($data);
	}
	public function getErrors(){
		return $this->errors;
	}
	public function setError($error){
		$this->errors[] = $error;
	}
	public function getOptions(){
		return $this->options;	
	}
	public function setOptions(array $options){
		//option: LabelText => Value
		$this->options += $options;
	}
	public function removeOption($option){
		unset($this->options[$option]);
	}
	public function getAttributes(){
		return $this->attributes;
	}
	public function setAttributes(array $attributes){ //pass in an array of attributes
		$this->attributes += $attributes;
	}
	public function isRequired(bool $which){
		if($which){
			$this->attributes[] = 'required';
		}
		else {
			$this->attributes = array_filter($this->attributes, function($val){
				return $val !== 'required';
			});
		}
	}
	public function render(){
		echo $this->getString();
	}
	public function getString(){
		if(!empty($this->errors)){
			$output =  "<div class='form-group'>
				<label class='text-danger' for='$this->name'>$this->label </label>";
			foreach($this->errors as $error){
				$output .= "<small class='text-danger'>$error</small>";
			}
		}
		elseif (!empty($this->data)){
			$output = "<div class='form-group'>
						<label class='text-success' for='$this->name'>$this->label</label>";
		}
		else {
			$output = "<div class='form-group'>
						<label for='$this->name'>$this->label</label>";
		}
		$output .= "<select name='$this->name' id='$this->name' class='form-control' ";
		if(!empty($this->attributes)){
			foreach($this->attributes as $key=>$value){
				if ($value === 'required'){
					$output .='required ';
				}
				else{
					$output .= "$key='$value' ";
				}
			}
		}	 
		$output .=">";
		foreach($this->options as $label=>$value){

			if(is_numeric($label)){			
				if(isset($this->data) && $this->data === $value){
					$output .= "<option selected='selected'>$value</option>";
				}
				else {
					echo $value;
					$output .= "<option>$value</option>";
				}
			}
			else {
				if(isset($this->data) && $this->data === $value){
					$output .= "<option selected='selected' value='$value'>$label</option>";
				}
				else {
					$output .= "<option value='$value'>$label</option>";
				}
			}
		}
		$output .= "</select>
				</div>";
		return $output;
	}
}
