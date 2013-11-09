<?php

function addUser() {
	$db = $GLOBALS['db'];

	$name = $_POST['name'];
	$email = $_POST['email'];

	$db->insert("users", array(
		"name" => $name,
		"email" => $email
	));

	return json(array("response" => true));
}

function listTrashForUser() {
	$db = $GLOBALS['db'];	
	$user_id = params("user_id");
	$trash_tags = $db->select("trash_tags", "users_id = :userId", array(":userId" => $user_id));

	return json($trash_tags);
}

function addTrash() {
	$db = $GLOBALS['db'];

	$latitude = $_POST['latitude'];
	$longitude = $_POST['longitude'];

	$base_bounty = $_POST['base_bounty'];
	$message = $_POST['message'];

	// TODO: Handle Images that are being uploaded
	$picture = $_POST['picture'];
	

	$uploaddir = '/var/www/trash_can/trash_images/';
	$uploadFileName = "/info_" . basename($_FILES['userfile']['name']);
	$uploadfilePath = $uploaddir . $uploadFileName;

	if (uploadFile($uploadfilePath)) {
		$insert_payload = array(
			"latitude" => $latitude,
			"longitude" => $longitude,
			"base_bounty" => $base_bounty,
			"message" => $message,
			"picture" => image_url($uploadFileName),
			"state" => 0
		);
		return json(array("status" => "true"));
	} else {
		return json(array("status" => "false"));
	}
}

function start_cleaning() {
	$db = $GLOBALS['db'];

	$trash_id = params("trash_id");

	$uploaddir = '/var/www/trash_can/trash_images/';
	$uploadFileName = "/start_" . basename($_FILES['userfile']['name']);
	$uploadfilePath = $uploaddir . $uploadFileName;

	if (uploadFile($uploadfilePath)) {
		$start_payload = array(
		    "before_img" => image_url($uploadFileName),
		    "before_timestamp" => time(),
		    "trash_tags_id" => $trash_id
		);

		$cleaning_start_id = $db->insert("cleaning", $start_payload);

		return json(array("status" => "true", "cleaning_id" => $cleaning_start_id));
	} else {
		return json(array("status" => "false"));
	}
}

function complete_cleaning() {
	$db = $GLOBALS['db'];

	$clean_id = params("clean_id");

	$uploaddir = '/var/www/trash_can/trash_images/';
	$uploadfilePath = $uploaddir . "end_" . basename($_FILES['userfile']['name']);

	if (uploadFile($uploadfilePath)) {
		$after_payload = array(
		    "after_img" => image_url($uploadFileName),
		    "after_timestamp" => time(),
		);

		$db->update("cleaning", $after_payload, "idcleaning = " . $clean_id);

		return json(array("status" => "true"));
	} else {
		return json(array("status" => "false"));
	}	
}

function getTrashDetails() {
	$db = $GLOBALS['db'];
	$trash_id = params("trash_id");
	return $db->select("trash_tags", "users_id = :userId", array(":userId" => $user_id));	
}

function uploadFile($uploadfilePath) {
	return move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfilePath) ? true : false;
}

function image_url($image_name) {
	return "http://localhost/trash_can/trash_images/" . $uploadFileName;
}