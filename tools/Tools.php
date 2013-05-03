<?php
	if(!defined('SERVER_ROOT'))
		die ('Unauthorized access. File forbidden.');

	class Tools extends MagicMethods{
		private $_email;

		public function __construct(){
			include $_SERVER['tools'] . '/transmit/Email.php';
		}

		public function setEmail($email){ $this->_email = $email; }
		public function getEmail(){ return $this->_email; }
	}
?>