<?php
	if(!defined('SERVER_ROOT'))
		die ('Unauthorized access. File forbidden.');

	abstract class Controller{

		private static $_instance = null;
		protected $load;
		protected $model;
		protected $session;
		protected $uri;
		protected $form;
		protected $image_resource;
		protected $assets;
		protected $tools;
		protected $base_url;


		public function __construct(){			
			global $rtr_config;

			$this->session = Session::getInstance();
			$this->load = Loader::getInstance();
			$this->model = array();		
			$this->tools = new Tools;

			$this->uri = new URI;
			$this->uri->URISegments = $this->uri->selfURL();	

			$this->form = new Form;
			$this->form->post = $_POST;
			$this->form->file = $_FILES;
			$this->form->loader = $this->load;


			$this->image_resource = $_SERVER['image'];
			$this->assets = $_SERVER['assets'];

			$this->base_url = $rtr_config['base_url'];
		}

		public static function getInstance($className){

			if(self::$_instance == null) {
				self::$_instance = new $className;
				return self::$_instance;
			} else
				return self::$_instance;
		}

		public function validateGetField($field, $getArray){
			if(is_array($getArray)) {
				if(count($getArray)) {
					if(array_key_exists($field, $getArray) && strlen(trim($getArray[$field])))
						return true;
				}
			}

			return false;
		}

		public function __destruct(){
			self::$_instance = null;
		}
	}
?>