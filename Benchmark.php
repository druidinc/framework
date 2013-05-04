<?php

	include_once $_SERVER['lib'] . '/URI/URI.php';
	include_once $_SERVER['lib'] . '/router/Router.php';
	include_once $_SERVER['lib'] . '/loader/Loader.php';

	include_once $_SERVER['lib'] . '/model/Model.php';
	include_once $_SERVER['lib'] . '/controller/Controller.php';
	include_once $_SERVER['lib'] . '/session/Session.php';
	require_once $_SERVER['lib'] . '/database/Database.php';

	include $_SERVER['helper'] . '/Form.php';
	include $_SERVER['tools'] . '/Tools.php';

	include_once $_SERVER['vendor'] . '/template_engine/Smarty.class.php';
	
	include $_SERVER['config'] . '/Router.php';	
	include $_SERVER['config'] . '/Database.php';
	include $_SERVER['config'] . '/Themes.php';

	include $_SERVER['security'] . '/NoCSRF.php';
	
?>