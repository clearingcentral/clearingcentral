<?php

require_once('_includes/constants.php');

// Check for session cookie, if none go to login page

session_start();

// Check if there is a session cookie

$sessid = $_SESSION['sessid'];
$nid = $_SESSION['nid'];

if(!isset($sessid)) {
	header('Location: index.php');
}

// Connect to DB

$link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (!$link) {
   	die('Could not connect: ' . mysqli_error());
}

// Match the session ID in the database

//mysql_select_db(DB_NAME, $link);

$strSql = "SELECT sessid FROM exchanges WHERE nid = '$nid' AND sessid = '$sessid'";

mysqli_query($link, $strSql);

if(!mysqli_affected_rows($link)) {
	// No match for sessid so clear sessid and go back to index page
	$strSql = "UPDATE exchanges SET sessid = '' WHERE nid = 'cen0000'";
	mysqli_query($link, $strSql);
	header('Location: index.php');
}

?>
