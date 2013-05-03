<?php
	if(!defined('SERVER_ROOT'))
		die ('Unauthorized access. File forbidden.');

	abstract class LoaderAccessors extends MagicMethods {
		protected $_uri = '';

		/*
			+---------------------------------------------------------------+
			|							SETTERS 							|
			+---------------------------------------------------------------+
			|	1. set the segments to rout									|
			+---------------------------------------------------------------+
		*/

		public function setUri($_uri){
			$this->_uri = $_uri;
		}

		public function getUri(){
			return $this->_uri;
		}
	}
?>