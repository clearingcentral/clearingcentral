<?php

require_once('_includes/nodeconstants.inc');
require_once('_includes/dbfunctions.inc');
require_once('_includes/uidfunctions.inc');

session_start();

// Validate request to log in to this site

if (isset($_POST["uid"]) && isset($_POST["password"])) {

	$strUID		= strtolower($_POST["uid"]);
	$strPasswd	= $_POST["password"];
	$strFrom	= $_POST["from"];
	$strXID		= substr($strUID,0,4);
	$strDB		= $strXID;
	//echo $strUID . "<br>";
	//echo $strPasswd;
	//die();
	if ($strFrom == "hp") {
		$strRedirectError="index.php?login=err";
	} else {
		$strRedirectError="badlogon.html";
	} 

	// If strXID = "ABCD" Then Response.Redirect "halt.htm"

	// Check if uid and password are valid

	if (strlen($strUID)!=8) {
		header("Location: ".$strRedirectError);
	} 

	if (strlen($strPasswd)<5) {
		header("Location: ".$strRedirectError);
	} 

	if ($strXID=="demo") {
		if ($strUID!="demo0000") {
			header("Location: ".$strRedirectError);
    	} 
	} 

	// See if exchange exists

	if (!exchangeExists($strXID)) {
    	header("Location: ".$strRedirectError);
	} 

	// See if user exists

	if (! userExists($strUID, $strPasswd, $strDB)) {
    	header("Location: ".$strRedirectError);
	} Else {

		// Username and Password match - this is a valid user

		$sessid = session_id();

		// Start some sessions so we can get going

		$_SESSION['dbUsername']		= DB_USERNAME;
		$_SESSION['dbPassword']		= DB_PASSWORD;    
		$_SESSION['nid']			= NID; // Node ID
    	$_SESSION['xid']			= $strXID; // Exchange ID
	    $_SESSION['uid']			= $strUID; // User ID
	    $_SESSION['sessid']			= $sessid; // Session ID

		dbconnect($strDB);

		$intRemem	= $_POST['remem'];
		$strSql		= sprintf("SELECT usertype, firstname, surname, orgname_short, subarea, defaultsub, language, login_count FROM users WHERE uid = '%s' AND password = '%s'",
			mysql_real_escape_string($strUID),
			mysql_real_escape_string($strPasswd));
		$result		= mysql_query($strSql) or die(mysql_error());
		$row		= mysql_fetch_assoc($result);

		// Get user variables

		$strUsertype		= $row['usertype'];
		$strFirstname		= $row['firstname'];
		$strSurname			= $row['surname'];
		$strOrgname			= $row['orgname_short'];
		$blnDefaultsub		= $row['defaultsub'];
		$strLanguage		= $row['language'];
		$intLogincount		= $row['login_count'];

		if ($strUsertype == "com" || $strUsertype = "org" || $strUsertype = "pub") {
			$strFullname = $strOrgname;
		}

		if ($strUsertype == "ind" || $strUsertype = "shr" || $strUsertype = "adm") {
			$strFullname = $strFirstname . " " . $strSurname;
		}

	    if ($strLanguage == "" || ! isset($strLanguage)) {
      		$strLanguage = getValue('settings','default_language','xid',$strXID);
    	} 

		// Start user sessions

	    $_SESSION['name']			= $strFullname;
    	$_SESSION['lang']			= $strLanguage;
    	$_SESSION['usertype']		= $strUsertype;

		// Get exchange variables

		$blnDoMoney			= getValue('settings','domoney','xid',$strXID); //Does exchange use con money?
    	$strExchangetitle	= getValue('settings','title','xid',$strXID);

		// Start exchange sessions

    	$_SESSION['domoney']		= $blnDoMoney;
    	$_SESSION['exchangetitle']	= $strExchangetitle;

	   	if ($blnDefaultsub) {
      		$_SESSION['subarea'] = $strSubarea;
    	} else {
			$_SESSION['subarea'] = "All";
    	} 

		// Do cookies

	    setcookie("UXID",$strXID,0,"","",0);

 	    $strRemembered = $_COOKIE['account'];

    	if ($strRemembered == "" && $intRemem == 1) {
			setcookie("account",strtoupper($strUID),0,"","",0);
    	} 

	    if ($strRemembered!="" && $intRemem!=1) {
      		setcookie("account","",0,"","",0);
    	}

		// Increase login count by 1 and register date of login to record last access

	    if ($intLogincount == "" || !isset($intLogincount)) {
      		$intLogincount = 0;
    	}

    	$intLogincount++;
    	$strSql = "UPDATE users SET last_access = '".strftime("%Y-%m-%d %H:%M:%S")."', login_count = ".$intLogincount." WHERE uid = '".$strUID."'";

    	$result = mysql_query($strSql);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "<br>";
			$message .= 'Whole query: ' . $strSql;
			die($message);
		}

		// See if user has current offerings

		if (!getValue('settings','no_offering_reminders','xid',$strXID)) {
    		if (hasoffers($strUID)) {
      			if (hasexpired($strUID)) {
					header("Location: "."offlistp.php?off=1");
      			} else {
					header("Location: "."main.php");
				} 
    		} else {
				header("Location: "."offlistp.php?off=0");
    		} 
		} else {
			header("Location: "."main.php");
		}

	}
	
} else {

	header("Location: "."badlogon.html");

} 

function exchangeExists($xid) {

	$conn = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die('Error connecting to mysql');

	mysql_select_db(DB_MAIN,$conn);

	if (mysql_query("SELECT xid FROM exchanges WHERE xid = '$xid'")){
		return TRUE;
	} else {
		return FALSE;
	}

}

function userExists($uid, $userpass, $dbname) {

	$uid	= strtoupper($uid);
	$conn	= mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die('Error connecting to mysql');
	$strSql	= "SELECT uid FROM users WHERE uid = '$uid' AND password = '$userpass'";

	mysql_select_db($dbname,$conn);

	if (mysql_query($strSql)){
		return TRUE;
	} else {
		return FALSE;
	}

}
?>

