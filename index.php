<?php
	
	require_once("config.php");
	require_once("lib/limonade.php");
	require_once("functions.php");

	dispatch_post("/user/add", 'addUser');
	dispatch_post("/trash/add", 'addTrash');
	dispatch_post("/trash/:trash_id/start_clean", "start_cleaning");
	dispatch_post("/trash/:clean_id/stop_clean", "complete_cleaning");

	dispatch("/trash/:user_id", 'listTrashForUser');
	dispatch("/trash/:trash_id", "getTrashDetails");

	run();
