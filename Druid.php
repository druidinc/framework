<?php
	//load system configurations
	include_once SYSTEM_PATH . '/config/config.php';

	//include files
	include_once $_SERVER['framework'] . '/core/Core.php';
	include_once $_SERVER['framework'] . '/Benchmark.php';	

	$URI = new URI;
	$URI->URISegments = $URI->selfURL();

	
	$RTR = new Router;
	$RTR->segments = $URI->parseURISegment();
	
	$RTR->mapController();
	
?>