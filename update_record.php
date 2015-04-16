<?php
require_once('constants.inc');

// Connect to DB

$strNID	= $_SESSION['nid']; // Exchange ID
$link	= mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD); 

if (!$link) {
    die('Could not connect: ' . mysql_error());
}

mysql_select_db('remotrades');

// Update record

if ($_POST['action'] == "update"){

	// Get form variables

	$xname			= $_POST['xname'];			//Name of exchange
	$password		= $_POST['password'];		//Record password
	$location		= $_POST['location'];		//Record password
	$country		= $_POST['country'];		//Record password
	$administrator	= $_POST['administrator'];	//System administrator
	$admin_tel		= $_POST['admin_tel'];
	$admin_email	= $_POST['admin_email'];
	$protocol_back	= $_POST['protocol_back'];	//Protocol used
	$protocol_out	= $_POST['protocol_out'];
	$url_back		= $_POST['url_back'];
	$url_out		= $_POST['url_out'];

	$strSql = "UPDATE exchanges SET xname = '".$xname."', location = '".$location."', country = '".$country."', password = '".$password."', administrator = '".$administrator."', admin_tel = '".$admin_tel."', admin_email = '".$admin_email."', protocol_back = '".$protocol_back."', protocol_out = '".$protocol_out."', url_back = '".$url_back."', url_out = '".$url_out."', date_edited = '".strftime("%Y-%m-%d %H:%M:%S")."' WHERE nid = '".$strNID."'";

	//die($strSql);

    $result = mysql_query($strSql);

	if (!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "<br>";
		$message .= 'Whole query: ' . $strSql;
		die($message);
	}

	header("Location: "."../account.php");

}
?>