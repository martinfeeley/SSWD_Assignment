<?php
class TextArea{
	private $name; // the name attribute
	private $label; // The text for the label field
	private $attributes; // array to set things like maxlength, required, etc
	private $data; // data retrieved from GET/POST request
	private $errors; // array of errors to print out
	public function __construct(string $name, string $label, array $attributes = array()){
		$this->name = $name;
		$this->label = $label;			
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
		$this->data = trim(htmlspecialchars($data));
	}
	public function getErrors(){
		return $this->errors;
	}
	public function setError($error){
		$this->errors[] = $error;
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
				<label class='text-danger' for='$this->name'>$this->label</label>";
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
		$output .= "<textarea name='$this->name' id='$this->name' class='form-control'";
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
		//thought this might give an error, but no
		$output .= ">$this->data</textarea>
				</div>";
		return $output;
	}
}
