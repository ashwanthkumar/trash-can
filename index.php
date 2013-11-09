<?php
	
	require_once("config.php");
	require_once("lib/limonade.php");
	require_once("functions.php");

	function hello() {
		$db	= $GLOBALS['db'];
		$results = $db->select("users");
		echo count($results);
		return json(array("resp" => "data"));
	}

	dispatch("/", 'hello');

	run();
