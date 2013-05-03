<?php
	if(!defined('SERVER_ROOT'))
		die ('Unauthorized access. File forbidden.');

	abstract class MagicMethods {
		
		public function __set($name,$value) {
			if(method_exists($this, 'set' . ucfirst($name))) {
				$this->{'set' . ucfirst($name)}($value);
			} else {
				throw new Exception('Undefined setter property: {$name}');
			}
		}

		public function __get($name) {
			if(method_exists($this, 'get' . ucfirst($name))) {
				return $this->{'get' . ucfirst($name)}();
			} else {
				throw new Exception('Undefined getter property: {$name}');
			}
		}
	}
?>