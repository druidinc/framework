<?php
    if(!defined('SERVER_ROOT'))
        die ('Unauthorized access. File forbidden.');


/**
* This class will be a controller for the UI(html) and the process(php).
* The index file will give a specified html document to be loaded using this class
* and the file will be viewed in the browser.
*/

/**
* @file
* The theme class that is used to implement the theme
*/

/**
*
* @author Egee Boy Gutierrez
*/


	class Template extends MagicMethods {

    	
    	private $_template;
    	private $_pathToFile;
    	private $_head;
    	private $_header;
    	private $_body;
    	private $_foot;
        private $_logo;
        private $_login_show = true;
        private $_login_widget;


        function __construct($template = null){
            if (isset($template))
            {
                $this->load($template);
            }
        }


        /**
        * This function loads the template file
        * @param 	string 		$pathToFile 	-path to template file
        * @throws 	FileNotFoundException 	-if file is not found
        */
        public function load() {
        	if (!is_file($this->_pathToFile)) {
                throw new Exception("File not found: $template");
            } else if (!is_readable($this->_pathToFile)) {
                throw new IOException("Could not access file: $template");
            } else {
                $this->_template = $this->_pathToFile;
            }

        }      

        /**
        * Prints out the theme to the page
        * However, before we do that, we need to remove every var witin {} that are not set
        * @param 	mixed 	$output 	optional 	- whether to output the template to the screen or to just return the template
        */
        public function publish($output = true){
            
            ob_start();
            require $this->_template;
            $content = ob_get_clean();

            print $content;
        }


        /**
        * Function that just returns the template file so it can be reused
        */
        public function parse() {
            
            ob_start();
            require $this->_template;
            $content = ob_get_clean();
            return $content;
        }


        /*===========================================================================
        	Template setters
        ============================================================================*/

        public function setPathToFile($pathToFile) {
        	$this->_pathToFile = $pathToFile . '.php';
        }       

        public function setHead($head) {
        	$this->_head = $head;
        }

        public function setHeader($header) {
        	$this->_header = $header;
        }

        public function setBody($body) {
        	$this->_body = $body;
        }       

        public function setLogo($logo) {
            if(file_exists($logo . '.png'))
                $this->_logo = $logo . '.png';
            else if (file_exists($logo . '.PNG'))
                $this->_logo = $logo . '.PNG';
            else if (file_exists($logo . '.jpg'))
                $this->_logo = $logo . '.jpg';
            else if (file_exists($logo . '.jpeg'))
                $this->_logo = $logo . '.jpeg';
            else if (file_exists($logo . '.JPG'))
                $this->_logo = $logo . '.JPG';
            else if (file_exists($logo . '.JPEG'))
                $this->_logo = $logo . '.JPEG';
            else if (file_exists($logo . '.gif'))
                $this->_logo = $logo . '.gif';
            else if (file_exists($logo . '.GIF'))
                $this->_logo = $logo . '.GIF';
            else
                throw new Exception('Logo not found: $logo');
        }

        public function setLogin_show ($value) {
            $this->_login_show = $value;
        }

        public function setLogin_widget($html) {
            $this->_login_widget = $html;
        }

        /*===========================================================================
        	Template getters
        ============================================================================*/

        public function getPathToFile() {
        	return $this->_pathToFile;
        }

        public function getHead() {
        	return $this->_head;
        }

        public function getHeader() {
        	return $this->_header;
        }

        public function getBody() {
        	return $this->_body;
        }

        public function getLogo() {
            return $this->_logo;
        }

        public function getLogin_show() {
            return $this->_login_show;
        }

        public function getLogin_widget() {
            return $this->_login_widget;
        }
    }
?>