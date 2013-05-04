<?php
	if(!defined('SERVER_ROOT'))
		die ('Unauthorized access. File forbidden.');

	require_once 'URIAccessors.php';

	/**
	* @author Egee Boy C. Gutierrez
	*/
	class URI extends URIAccessors{
		

		//for now, we will set the uri segments to empty
		//as the process of development goes on, we will have the developer set a default uri
		//for the controller
		public function __construct(){

			$this->_URISegments = '';
			$this->_get = array();			
		}

		/**
		* Get only the URI after index.php
		* @return array
		*/

		public function selfURL(){
		    if(!isset($_SERVER['REQUEST_URI'])){
		        $serverrequri = $_SERVER['PHP_SELF'];
		    }else{
		        $serverrequri =    $_SERVER['REQUEST_URI'];
		    }
		    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
		    $protocol = $this->strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;

		    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
		    

		    $fullUrl = $protocol."://".$_SERVER['SERVER_NAME'].$port.$serverrequri;

		    $explodedURL = explode('?', $fullUrl);

		    if(count($explodedURL) > 1) {
		    	$getURL = $explodedURL[1];
			    $explodedGet = explode('&', $getURL);

			    foreach ($explodedGet as $value) {
			    	$getVal = explode('=', $value);
			    	$this->_get[$getVal[0]] = !empty($getVal[1])? $getVal[1] : '';
			    }
		    }
		    

		    return $fullUrl;   
		}

		private function strleft($s1, $s2) {
			return substr($s1, 0, strpos($s1, $s2));
		}

		public function parseURISegment(){

			global $rtr_config;

			$this->_URISegments = str_replace($rtr_config['base_url'], '', $this->_URISegments);
			$this->_URISegments =  str_replace('index.php/', '', $this->_URISegments);
			$parsedSegment =  str_replace('index.php', '', $this->_URISegments);
			//$parsedSegment = preg_replace('/(\/[a-zA-Z0-9]*)+\.(php)\//','',$this->_URISegments);


			//separate the get uri
			$generalUri = explode('?', $parsedSegment);
			
			$parsedSegment = $generalUri[0];

			$arrSegments = $this->segmentToArray($parsedSegment);
			
			return $arrSegments;
		}

		/**
		* Converts the parsed segment to arrays
		* @param string parsedSegment URI that is parsed
		* @return array
		*/
		private function segmentToArray($parsedSegment){
			$segments = explode('/', $parsedSegment);
			return $segments;
		}

		public function display(){
			echo 'display';
		}

		public function redirect($url) {
			$script = '<script language="javascript">';
			$script .= 'window.location="' . $url . '";';
			$script .= '<script>';

			echo $script;
		}

	}
?>