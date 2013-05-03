<?php
	if(!defined('SERVER_ROOT'))
		die ('Unauthorized access. File forbidden.');

	include 'SessionAccessors.php';

	class Session extends SessionAccessors{

		private static $_instance = null;

		public function __construct(){
			$this->_sessionData = array();	
			$this->sessionSavePath($_SERVER['application'] . '/sessions');
			$this->sessionStart();		
		}

		public static function getInstance(){
			if(self::$_instance == null) {
				self::$_instance = new Session;
			}

			return self::$_instance;
		}

		private function sessionSavePath($path){
			session_save_path($path);
		}

		private function sessionStart(){
			if(strlen(session_id()) == 0){
				session_start();
			} 
		}

		public function sessionEnd(){
			session_destroy();
		}

		public function sessionUnset($key){
			session_unset($key);
			unset($_SESSION[$key]);
		}

		public function displaySession(){
			print_r($this->_sessionData);
		}
	}
?>