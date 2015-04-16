<?php

require_once('constants.inc');

// Validate request to log in

if (isset($_POST["nid"]) && isset($_POST["password"])) {

	session_start();

	// Connect to DB

	$link = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD); 

	if (!$link) {
    	die('Could not connect: ' . mysql_error());
	}

	mysql_select_db('remotrades');

	$strNID		= strtolower($_POST["nid"]);
	$strPasswd	= $_POST["password"];

	// To protect MySQL injection

	$strNID		= stripslashes($strNID);
	$strPasswd	= stripslashes($strPasswd);
	$strNID		= mysql_real_escape_string($strNID);
	$strPasswd	= mysql_real_escape_string($strPasswd);

	$strSql = "SELECT nid FROM exchanges WHERE nid = '" . $strNID . "' AND password = '" . $strPasswd . "'";
	$result	= mysql_query($strSql);

	if (!$result){
    	print "SQL QUERY [".$strSql."] FAILED ";
    	print "[".mysql_error()."]";
	}

	$count	= mysql_num_rows($result);

	if($count == 1){
		$sessid = session_id();
	    $_SESSION['sessid']	= $sessid; // Session ID
		$_SESSION['nid']	= $strNID; // Exchange ID
		header("Location: "."admain.php");
	} else {
		header("Location: "."adminindex.php");
	}

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

<form method="post" action="adminindex.php">
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
</td></tr></table>
<input type="hidden" name="action" value="login">
</form>
</body>
</html>

