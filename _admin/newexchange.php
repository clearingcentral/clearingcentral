<?php

require_once('_includes/constants.php');

// Connect to DB

$link = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD); 

if (!$link) {
   	die('Could not connect: ' . mysql_error());
}

mysql_select_db(DB_NAME, $link);

$nid 					= makenid();
$xid					= $_POST['xid'];
$xname					= trim($_POST['xname']);
$xname_short			= trim($_POST['xname_short']);
$password				= trim($_POST['password']);
$system					= $_POST['system'];
$serverid				= $_POST['server_id'];
$location				= trim($_POST['location']);
$country				= $_POST['country'];
$currency_name			= trim($_POST['currency_name']);
$currency_symbol		= trim($_POST['currency_symbol']);
$currency_type			= $_POST['currency_type'];
$data_url				= trim($_POST['data_url']);
$request_format			= $_POST['request_format'];
$response_format		= $_POST['response_format'];
$administrator			= trim($_POST['administrator']);
$admin_email			= trim($_POST['admin_email']);
$admin_tel				= trim($_POST['admin_tel']);
$conv_rate				= $_POST['conv_rate']; //temporary
$time_offset			= $_POST['time_offset'];
$active					= $_POST['active'];

if (! stripos($data_url,'http://')) {$data_url	= "http://" . $data_url;}

$admin_tel = append_dialling_code($country) . " " . $admin_tel;

$strSql = "INSERT INTO exchanges (
	nid,
	xid,
	xname,
	xname_short,
	password,
	system,
	server_id,
	administrator,
	admin_tel,
	admin_email,
	location,
	country,
	currency_name,
	currency_symbol,
	currency_type,
	request_format,
	response_format,
	conv_rate,
	data_url,
	trade_surplus_limit,
	trade_deficit_limit,
	time_offset,
	active,
	approve
	) VALUES (
	'$nid',
	'$xid',
	'$xname',
	'$xname_short',
	'$password',
	'$system',
	'$serverid',
	'$administrator',
	'$admin_tel',
	'$admin_email',
	'$location',
	'$country',
	'$currency_name',
	'$currency_symbol',
	'$currency_type',
	'$request_format',
	'$response_format',
	'$conv_rate',
	'$data_url',
	'$trade_surplus_limit',
	'$trade_deficit_limit',
	'$time_offset',
	'-1',
	'0'		
)";

//echo $strSql;

$result = mysql_query($strSql);

if (!$result) {
	$message  = 'Invalid query: ' . mysql_error() . "<br>";
	$message .= 'SQL: ' . $strSql;
	die($message);
}

echo $nid;

// The End

function makenid() {

	//Make a new network ID

	//First find last NID in DB

	$strSql = "SELECT nid FROM exchanges ORDER BY nid DESC";
	$result = mysql_query($strSql);

	if (!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "<br>";
		$message .= 'SQL: ' . $strSql;
		die($message);
	} else {
		$row		= mysql_fetch_assoc($result);
		$lastnid	= $row['nid']; 	//Highest NID
	}

	$lastnid = str_replace('cen','',$lastnid);

	if ($lastnid == "") {
		die("Failed to create new Exchange ID");
	}

	$nid = intval($lastnid);
	$nid = $nid + 1;
	$nid = strval($nid);

	if (strlen($nid) == 1) {$nid = "cen000" . $nid;}
	if (strlen($nid) == 2) {$nid = "cen00" . $nid;}
	if (strlen($nid) == 3) {$nid = "cen0" . $nid;}
	if (strlen($nid) == 4) {$nid = "cen" . $nid;}

	return $nid;

}

function append_dialling_code($country) {

	//Append telephone code from dialling codes table

	$strSql = "SELECT dialling_code FROM countries WHERE iso = '$country'";
	$result = mysql_query($strSql);

	if (!$result) {
		$message  	= 'Invalid query: ' . mysql_error() . "<br>";
		$message   .= 'SQL: ' . $strSql;
		die($message);
	} else {
		$row		= mysql_fetch_assoc($result);
		$dcode		= $row['dialling_code'];
	}

	return $dcode;

}
?>
