<?php
	if(!defined('SERVER_ROOT'))
		die ('Unauthorized access. File forbidden.');


	/**
	*	Array structure
	*	Array (
	*		Array(
	*			'name' => nameValue,
	*			'label' => labelValue,
	*			'validation' => 'fieldValue|fieldValue2'
	*		)
	*	)
	*/
	class Form extends MagicMethods{

		private $_post;
		private $_file;
		private $_loader;
		private $_errors;

		public function validate($data) {
			$validationErrors = array();

			if(!count($this->_post) || empty($this->_post))
				return false;

			foreach ($data as $value) {
				$validation = explode('|',$value['validation']);

				foreach ($validation as $validationFunction) {
					$functions = explode('=', $validationFunction);


					switch($functions[0]){
						case 'required':
							if(!$this->required($value['name']))
								$validationErrors[] = $value['label'] . ' is empty';
							break;
						case 'filter':
							if(!$this->filter($functions[1],$value['name']))
								$validationErrors[] = $value['label'] . ' is invalid.';
							break;
					}
				}
			}
			
			if(count($validationErrors)){
				$this->_loader->formError = $validationErrors;
				$this->_loader->formData = $this->_post;
				return false;
			}
			else
				return true;
			
		}


		private function required($name){
			if(!array_key_exists($name, $this->_post) || !strlen(trim($this->_post[$name])))
				return false;
			
			return true;
		}

		private function filter($type,$name){
			switch($type){
				case 'email':
					if (!filter_var($this->_post[$name], FILTER_VALIDATE_EMAIL)) {
					    return false;
					}
					break;					
			}

			return true;
		}



		public function validateFile($name,$filename){

			$validationErrors = array();

			//validate extendsion
			$allowedExts = array("gif", "jpeg", "jpg", "png");
			$explodedImg = explode(".", $_FILES[$name]["name"]);
			$extension = end($explodedImg);


			if (
					($this->_file[$name]["type"] != "image/gif") &&
					($this->_file[$name]["type"] != "image/jpeg")&& 
					($this->_file[$name]["type"] != "image/jpg") && 
					($this->_file[$name]["type"] != "image/png") && 
					!in_array($extension, $allowedExts)
			) {
				$validationErrors[] = 'Invalid image';
			}

			if ($this->_file[$name]["error"] > 0) 
				$validationErrors[] = 'Upload error. Return Code: ' . $this->_file[$name]["error"] ;

			if ($this->_file[$name]["size"] > (1024 * 1024 * 2)) 
				$validationErrors[] = 'File size exceeds limit' ;


			$this->_file[$name]["name"] = $filename; 

			if(file_exists($_SERVER['image']. "/" . $this->_file[$name]["name"])) 
				$validationErrors[] = $this->_file[$name]["name"] . 'already exists.';
			

			if(count($validationErrors)){
				$this->_loader->formError = $validationErrors;
				$this->_loader->formData = $this->_post;
				return false;
			}
			else
				return true;
		}


		public function setPost($post){ $this->_post = $post; }
		public function getPost(){ return $this->_post; }
		public function setFile($file){ $this->_file = $file; }
		public function getFile(){ return $this->_file; }
		public function setErrors($errors){ $this->_errors = $errors; $this->_loader->formError =  $this->_errors;}
		public function getErrors(){ return $this->_errors; }
		public function setLoader(Loader $loader){ $this->_loader = $loader; }
		public function getLoader(){ return $this->_loader; }
	}
?>