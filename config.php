<?php
	require_once("lib/class.db.php");

	$db_host = "localhost";
	$db_port = 3301;
	$db_name = "trashdb";

	$db_user = "root";
	$db_pass = "root";

	$db = new db("mysql:host=$db_host;port=$db_port;dbname=$db_name", "$db_user", "$db_pass");
	$db->setErrorCallbackFunction("showError", "text");
	
	$GLOBALS['db'] = $db; 
