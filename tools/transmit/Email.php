<?php
	if(!defined('SERVER_ROOT'))
		die ('Unauthorized access. File forbidden.');

	class Email  extends MagicMethods {
		private $_from;
		private $_to;
		private $_subject;
		private $_headers;
		private $_message;

		public function __construct(){
			$_from = '';
			$_to = '';
			$_subject = '';
			$_headers = '';
			$_message = '';
		}

		public function setFrom($from){ $this->_from = $from; }
		public function setTo($to){ $this->_to = $to; }
		public function setSubject($subject){ $this->_subject = $subject; }
		public function setHeaders($headers){ $this->_headers = $headers; }
		public function setMessage($message){ $this->_message = $message; }

		public function getFrom(){ return $this->_from; }
		public function getTo(){ return $this->_to; }
		public function getSubject(){ return $this->_subject; }
		public function getHeaders(){ return $this->_headers; }
		public function getMessage(){ return $this->_message; }

		public function send(){
			if(empty($this->_headers)) {
				// To send HTML mail, the Content-type header must be set
				$this->_headers  = 'MIME-Version: 1.0' . "\r\n";
				$this->_headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				// Additional headers
				$this->_headers .= 'From: ' . $this->_from . "\r\n";
			}

			try{
				mail($this->_to, $this->_subject, $this->_message, $this->_headers);
			} catch (Exception $e){
				throw new Exception($e->getMessage());
			}
		}
	}
?>