<?php
	if(!defined('SERVER_ROOT'))
		die ('Unauthorized access. File forbidden.');

	abstract class URIAccessors extends MagicMethods{
		/**
		* @var string URI segments index.php/segment1/segment2
		*/
		protected $_URISegments;

		/**
		* @var array get ?name=value
		*/
		protected $_get;

		/*
			+---------------------------------------------------------------+
			|							SETTERS 							|
			+---------------------------------------------------------------+
			|	1. set the URISegments 										|	
			|	2. set the get 											|
			+---------------------------------------------------------------+
		*/

		public function setURISegments($segments){
			$this->_URISegments = $segments;
		}

		public function setGet($gets){
			$this->_get = $gets;
		}		

		public function getURISegments(){
			return $this->_URISegments;
		}

		public function getGet(){
			return $this->_get;
		}
	}
?>