<?php
	if(!defined('SERVER_ROOT'))
		die ('Unauthorized access. File forbidden.');

	class Tools extends MagicMethods{
		private $_email;
		private $_sms;

		public function __construct(){
			include $_SERVER['tools'] . '/transmit/Email.php';
			include $_SERVER['tools'] . '/transmit/SMS.php';
		}

		public function setEmail($email){ $this->_email = $email; }
		public function getEmail(){ return $this->_email; }

		public function setSms($sms){ $this->_sms = $sms; }
		public function getSms(){ return $this->_sms; }
	}
?>