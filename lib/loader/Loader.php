<?php
	if(!defined('SERVER_ROOT'))
		die ('Unauthorized access. File forbidden.');

	include 'LoaderAccessors.php';
	include $_SERVER['lib'] . '/template/Smarty.class.php';
	include $_SERVER['security'] . '/NoCSRF.php';

	class Loader extends MagicMethods {
		private $_className = '';
		private static $_instance = null;
		private $_pathToFile;
		private $_viewName;
		private $_modelName;
		private $_template;
		private $_token;
		private $_formError = array();
		private $_fileError = array();
		private $_formData = array();


		public  function __construct(){
			$this->_template = Smarty::getInstance();
			$this->_template->compile_dir = str_replace('/', '\\', $_SERVER['application'].'/debug');

		}

		public static function getInstance(){
			if(self::$_instance == null) {
				$className = __CLASS__;	
				self::$_instance = new $className;				
			}
			
			return self::$_instance;
		}


		public function controller($controllerName){
			include $_SERVER['application'] . '/config/Router.php';
			
			$path = $rtr_config['base_url'] . $controllerName;
			
			header('Location: ' . $path);
		}

		public function view($viewName,$data = array(),$fetch=false){


			$this->_viewName = $viewName;


			$URI = new URI;
			$URI->URISegments = $viewName;

			

			
			$RTR = new Router;
			$RTR->segments = $URI->parseURISegment();
			$this->_pathToFile = $RTR->mapView();

			//$this->_template->template_dir = str_replace('/', '\\', $this->_pathToFile);
			$this->_template->template_dir = $this->_pathToFile;

					
			/*
			Usage
			*/
			$html = file_get_contents($this->_pathToFile . '/' . $RTR->segments[(count($RTR->segments) - 1)] . '.php');



			include $_SERVER['config'] . '/Router.php';
			include $_SERVER['config'] . '/Themes.php';


			foreach ($theme_config as $key => $value) {
				if(!empty($value))
					$data[$key] = str_replace('index.php/', '', $rtr_config['base_url']) . $_SERVER[$key] . '/' . $value;
				else
					$data[$key] = str_replace('index.php/', '', $rtr_config['base_url']) . $_SERVER[$key];
			}	



			
			if(!array_key_exists('form_errors', $data))
				$data['form_errors'] = array();

			if(!$fetch) {
				$this->_token = NoCSRF::generate('token');
				$data['token'] = $this->_token;
			} else {
				$data['token'] = $_SESSION['csrf_token'];
			}
			
			
			$data['base_url'] = $rtr_config['base_url'];




			foreach ($this->get_input_tags($html) as $key => $value) {
				if(!array_key_exists($key, $data))
					$data[$key] = '';
			}

			foreach ($data as $key => $value) {
				$this->_template->assign($key,$value);				
			}
			

			$errors = '';
			if(count($this->_formError)) {
				$errors .= '<div class="form_error">';

				foreach ($this->_formError as $error) {
					$errors .='<div>' . $error . '</div>';					
				}

				foreach ($this->_fileError as $error) {
					$errors .='<div>' . $error . '</div>';					
				}

				$errors .= '</div>';
			}

			$this->_template->assign('load_errors',$errors);

			foreach ($this->_formData as $key => $value) {
				$this->_template->assign($key,$value);	
			}
		
			if(!$fetch)
				$this->_template->display( $RTR->segments[(count($RTR->segments) - 1)] . '.php');
			else
				return $this->_template->fetch( $RTR->segments[(count($RTR->segments) - 1)] . '.php');


		}


		/*
			Generic function to fetch all input tags (name and value) on a page
		Useful when writing automatic login bots/scrapers
		*/

		function setFormError($errors){
			$this->_formError = $errors;
		}


		function getFormError(){
			return $this->_formError;
		}

		function setFileError($errors){
			$this->_fileError = $errors;
		}


		function getFileError(){
			return $this->_fileError;
		}


		function setFormData($form_data) {
			$this->_formData = $form_data;
		}

		function getFormData(){
			return $this->_formData;
		}

		function get_input_tags($html)
		{
			
			$post_data = array();
			
			// a new dom object
		    $dom = new DomDocument; 
			
			//load the html into the object

			$html = str_replace('$', '', $html);
			$html = str_replace('&', '', $html);
			$html = str_replace('{', '', $html);
			$html = str_replace('}', '', $html);
			$html = str_replace('(', '', $html);
			$html = str_replace(')', '', $html);
		    $dom->loadHTML($html); 
		    //discard white space
		    $dom->preserveWhiteSpace = false; 
		    
		    $formTags = array('input','textarea','select');

		    foreach ($formTags as $tag) {
		    	//all input tags as a list
			    $input_tags = $dom->getElementsByTagName($tag); 

			    //get all rows from the table
				for ($i = 0; $i < $input_tags->length; $i++) 
			    {
			  		if( is_object($input_tags->item($i)) )
					{
						$name = $value = '';
						$name_o = $input_tags->item($i)->attributes->getNamedItem('name');
						if(is_object($name_o))
						{
							$name = $name_o->value;
							
							$value_o = $input_tags->item($i)->attributes->getNamedItem('value');
							if(is_object($value_o))
							{
								$value = $input_tags->item($i)->attributes->getNamedItem('value')->value;
							}
							
							$post_data[$name] = $value;
						}
					}
				}
		    }
			
			return $post_data;
		}

		


		public function model($modelName){
			$URI = new URI;
			$URI->URISegments = $modelName;

			$RTR = new Router;
			$RTR->segments = $URI->parseURISegment();
			return $RTR->mapModel();

		}

		public function __destruct(){
		}

		public function setTemplate($template){
			$this->_template = $template;
		}

		public function getTemplate(){
			return $this->_template;
		}
	}
?>