<?php

require('_includes/constants.php');

// Validate request to log in

if (isset($_POST["nid"]) && isset($_POST["password"])) {

	session_start();

	// Connect to DB

	$link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

	if (!$link) {
    	die('Could not connect: ' . mysqli_error());
	}

	//mysqli_select_db(DB_NAME);

	$strNID		= strtolower(checkinput("nid"));
	$strPasswd	= checkinput("password");

	// To protect MySQL injection

	$strNID		= stripslashes($strNID);
	$strPasswd	= stripslashes($strPasswd);
	$strNID		= mysqli_real_escape_string($link, $strNID);
	$strPasswd	= mysqli_real_escape_string($link, $strPasswd);

	$strSql = "SELECT nid FROM exchanges WHERE nid = 'cen0000' AND password = '$strPasswd'";
	//die($strSql);

	$result	= mysqli_query($link, $strSql);

	if (!$result){
    	print "SQL QUERY [".$strSql."] FAILED ";
    	print "[".mysqli_error()."]";
	}

	if(mysqli_affected_rows($link)) {
		$sessid = session_id();
	    $_SESSION['sessid']	= $sessid; // Session ID
		$_SESSION['nid']	= $strNID; // Exchange ID
		$strSql = "UPDATE exchanges SET sessid = '$sessid' WHERE nid = 'cen0000'";
		mysqli_query($link, $strSql);
		header("Location: main.php");
		die();
	}

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
<html>
<head>
<title>Administration Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles/cxn.css" rel="stylesheet" type="text/css">
</head>


<body>
<p class="header1">Community Exchange Network</p>
<p class="header2">Administration Login</p>

<form method="post" action="index.php">
    <table border="0" align="center" cellpadding="0" cellspacing="0">
        <tr><td style="border:1px solid #006600">
<table border="0" cellpadding="4" cellspacing="0">
    <tr bgcolor="#DDDDDD">
        <td align="right" nowrap class="text">Username:</td>
        <td><input name="nid" type="text"></td>
    </tr>
    <tr bgcolor="#EEEEEE">
        <td align="right" class="text">Password:</td>
        <td><input name="password" type="password"></td>
    </tr>
    <tr bgcolor="#006600">
        <td>&nbsp;</td>
        <td><input name="Submit" type="submit" class="textbold" value="Enter"></td>
    </tr>
</table>
</td>
</tr>
</table>
<input type="hidden" name="action" value="login">
</form>
<p align="center" class="text"><a href="../index.php">CXN Home Page</a></p>
</body>
</html>

