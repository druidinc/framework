<?php
	if(!defined('SERVER_ROOT'))
		die ('Unauthorized access. File forbidden.');

	//======================================================================
	//			WORKING ENVIRONMENT ROUTE
	//======================================================================
	$_SERVER['application'] = 'application';
	$_SERVER['framework'] = 'framework';

	$_SERVER['lib'] = 'framework/lib';
	$_SERVER['helper'] = 'framework/helper';
	$_SERVER['security'] = 'framework/security';
	
	$_SERVER['config'] = 'application/config';
	$_SERVER['css'] = 'application/resources/css';
	$_SERVER['image'] = 'application/resources/image';
	$_SERVER['javascript'] = 'application/resources/javascript';
	$_SERVER['assets'] = 'application/assets';
	
	$_SERVER['tools'] = 'framework/tools';

	$_SERVER['vendor'] = 'framework/vendor';
	$_SERVER['icon'] = 'favicon.ico';
?>