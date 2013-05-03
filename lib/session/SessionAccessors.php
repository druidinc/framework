<?php
	if(!defined('SERVER_ROOT'))
		die ('Unauthorized access. File forbidden.');

	abstract class SessionAccessors extends MagicMethods{
		protected $_sessionData;

		public function setSessionData($sessionData){

			foreach($sessionData as $key => $value){
				$_SESSION[$key] = $value;
			}

			$this->_sessionData = $_SESSION;
		}

		public function getSessionData(){
			if(!empty($_SESSION))
				return $_SESSION;
			else
				return $this->_sessionData;
		}
	}
?>