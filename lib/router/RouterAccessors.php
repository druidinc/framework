<?php
	if(!defined('SERVER_ROOT'))
		die ('Unauthorized access. File forbidden.');

	abstract class RouterAccessors extends MagicMethods{
		/**
		* @var string URI segments index.php/segment1/segment2
		*/
		protected $_segments;

		/*
			+---------------------------------------------------------------+
			|							SETTERS 							|
			+---------------------------------------------------------------+
			|	1. set the segments to rout									|
			+---------------------------------------------------------------+
		*/

		public function setSegments($segments){
			$this->_segments = $segments;
		}

		public function getSegments(){
			return $this->_segments;
		}
	}
?>