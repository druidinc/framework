<?php
	if(!defined('SERVER_ROOT'))
		die ('Unauthorized access. File forbidden.');

	//require $_SERVER['framework'] . '/core/Core.php';


	/**
	* This class will get the current page
	* selected by the user.
	* By default, the current page will be the Home page.
	*/
	class CurrentPage  {
		private $_currentPage;
		private $_previousPage;


		public function setCurrentPage ($currentPage = 'nav_1'){
			$this->_currentPage = $currentPage;
		}

		public function setPreviousPage($previousPage = 'nav_0') {
			$this->_previousPage = $previousPage;
		}

		public function getCurrentPage () {
			return $this->_currentPage;
		}

		public function getPreviousPage() {
			return $this->previousPage;
		}
	}
?>