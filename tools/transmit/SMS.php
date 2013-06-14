<?php
	if(!defined('SERVER_ROOT'))
		die ('Unauthorized access. File forbidden.');

	include_once $_SERVER['vendor'] . '/twilio/Twilio.php';

	class SMS extends Services_Twilio {
		public function __construct(){			

			$AccountSid = "AC8211e2007d91f450cfb2882ceffece73";
			$AuthToken = "3b9d47b9744de6e0eedcd8d422898ed3";

			parent::__construct($AccountSid, $AuthToken);
		}
	}
?>