<?php
	if(!defined('SERVER_ROOT'))
		die ('Unauthorized access. File forbidden.');

	//======================================================================
	//			WORKING ENVIRONMENT ROUTE
	//======================================================================
	$_SERVER['framework'] = 'framework';
	$_SERVER['widget'] = 'framework/widget';	
	$_SERVER['lib'] = 'framework/lib';
	$_SERVER['helper'] = 'framework/helper';
	$_SERVER['security'] = 'framework/security';
	$_SERVER['application'] = 'application';
	$_SERVER['config'] = 'application/config';	
	$_SERVER['css'] = 'application/resources/css';
	$_SERVER['image'] = 'application/resources/image';
	$_SERVER['javascript'] = 'application/resources/javascript';
	$_SERVER['db'] = 'application/resources/db';
	$_SERVER['assets'] = 'application/assets';
	$_SERVER['tools'] = 'framework/tools';
	$_SERVER['vendor'] = 'framework/vendor';
?>