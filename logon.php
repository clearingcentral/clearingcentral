<?php

require('_includes/constants.php');

// Validate request to log in

if (isset($_POST["nid"]) && isset($_POST["password"])) {

	$nid		= strtolower(checkinput('nid'));
	$strPasswd	= checkinput('password');

	session_start();

	// Connect to DB

	$link = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD); 

	if (!$link) {
    	die('Could not connect: ' . mysql_error());
	}

	mysql_select_db(DB_NAME, $link);

	// To protect MySQL injection

	$nid		= stripslashes($nid);
	$strPasswd	= stripslashes($strPasswd);
	$nid		= mysql_real_escape_string($nid);
	$strPasswd	= mysql_real_escape_string($strPasswd);
	$strSql		= "SELECT login_count FROM exchanges WHERE nid = '$nid' AND password = '$strPasswd'";
	$result		= mysql_query($strSql, $link);

	if (!$result){
    	print "SQL QUERY [".$strSql."] FAILED ";
    	print "[".mysql_error()."]";
	}

	$count = mysql_num_rows($result);

	if ($count) {
		$row = mysql_fetch_assoc($result);
		$login_count = $row['login_count'];
		$sessid = session_id();
		$strSql = "UPDATE exchanges SET login_count = '($login_count + 1)', sessid = '$sessid' WHERE nid = '$nid'";
		mysql_query($strSql);
	    $_SESSION['sessid']	= $sessid; // Session ID
		$_SESSION['nid']	= $nid; // Exchange ID
		if ($nid == ADMIN_AC) {
			header("Location: _admin/main.php"); // Go to Admin login if Administrator logging in
		} else {
			header("Location: main.php");
		}
	} else {
		header("Location: index.php");
	}
} else {
	header("Location: index.php");
}

function checkinput($inputstring) {

	$inputstring = trim($inputstring);

	if (isset($_GET[$inputstring])){ 
		$filtered_var = htmlspecialchars($_GET[$inputstring], ENT_QUOTES); 
	}
	if (isset($_POST[$inputstring])){ 
		$filtered_var = htmlspecialchars($_POST[$inputstring], ENT_QUOTES); 
	}
	if (isset($_REQUEST[$inputstring])){ 
		$filtered_var = htmlspecialchars($_REQUEST[$inputstring], ENT_QUOTES); 
	}

	return $filtered_var;

}
?>

