<?php
	
	require_once("lib/limonade.php");

	function hello() {
		return json(array("resp" => "Hell World"));
	}
	
	dispatch("/", 'hello');

	run();
