<?php
	if(!defined('SERVER_ROOT'))
		die ('Unauthorized access. File forbidden.');

	abstract class Model{
		private static $_instance = null;
		protected $db;
		protected $db_config;


		public function __construct(){
			global $db_config;
			

			$this->db_config = $db_config;
			$this->db = Database::getInstance($this->db_config);
			$this->db->connect();
		}

		public static function getInstance($className){
			

			if(self::$_instance == null) {
				self::$_instance = new $className;
			}
			
			return self::$_instance;
		}

		public function __destruct(){

		}
	}
?>