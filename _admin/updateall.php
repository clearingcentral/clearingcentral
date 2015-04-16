<?php

require_once('_includes/constants.php');

// Connect to DB

$link = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD); 

if (!$link) {
   	die('Could not connect: ' . mysql_error());
}

mysql_select_db(DB_NAME, $link);

$nid				= $_POST['nid'];
$xid				= $_POST['xid'];
$xname				= url_decode($_POST['xname']);
$xname_short		= url_decode($_POST['xname_short']);
$password			= $_POST['password'];
$system				= $_POST['system'];
$serverid			= $_POST['server_id'];
$serverip			= $_POST['server_ip'];
$location			= url_decode($_POST['location']);
$country			= $_POST['country'];
$currency_name		= url_decode($_POST['currency_name']);
$currency_name_p	= url_decode($_POST['currency_name_p']);
$currency_symbol	= url_decode($_POST['currency_symbol']);
$currency_type		= $_POST['currency_type'];
$concurrency_name	= url_decode($_POST['concurrency_name']);
$concurrency_name_p	= url_decode($_POST['concurrency_name_p']);
$concurrency_symbol	= url_decode($_POST['concurrency_symbol']);
$currency_code		= url_decode($_POST['currency_code']);
$data_url			= url_decode($_POST['data_url']);
$request_format		= $_POST['request_format'];
$response_format	= $_POST['response_format'];
$administrator		= url_decode($_POST['administrator']);
$admin_email		= $_POST['admin_email'];
$admin_tel			= $_POST['admin_tel'];
$conv_rate			= $_POST['conv_rate'];
$time_offset		= $_POST['time_offset'];
$active				= $_POST['active'];

if ($currency_code == "EUR") {$concurrency_symbol = "&euro;";}
if ($active == "1") {$active = -1;} else {$active = 0;}

$admin_tel = ltrim($admin_tel, "0"); 
$admin_tel = append_dialling_code($country) . " " . $admin_tel;
$admin_email = strtolower($admin_email);

if ($nid != "") {

	$strSql = "UPDATE `exchanges` SET `xid` = '$xid',
	`xname`					= '$xname',
	`xname_short`			= '$xname_short',
	`password`				= '$password',
	`system`				= '$system',
	`server_id`				= '$serverid',
	`server_ip`				= '$serverip',
	`administrator`			= '$administrator',
	`admin_tel`				= '$admin_tel',
	`admin_email`			= '$admin_email',
	`location`				= '$location',
	`country`				= '$country',
	`currency_name`			= '$currency_name',
	`currency_name_p`		= '$currency_name_p',
	`currency_symbol`		= '$currency_symbol',
	`currency_type`			= '$currency_type',
	`concurrency_name`		= '$concurrency_name',
	`concurrency_name_p`	= '$concurrency_name_p',
	`concurrency_symbol`	= '$concurrency_symbol',
	`currency_code`			= '$currency_code',
	`request_format`		= '$request_format',
	`response_format`		= '$response_format',
	`conv_rate`				= '$conv_rate',
	`data_url`				= '$data_url',
	`date_edited`			= NOW(),
	`time_offset`			= '$time_offset',
	`active`				= '$active' WHERE `nid` = '$nid' LIMIT 1";
	
	//die($strSql);

	$result = mysql_query($strSql);

	if (!$result) {
		die("Stopped: " . $nid);
	}

	echo "Updated";

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

function url_decode($codedstring) {

	$codedstring = trim($codedstring);

	$decoded = urldecode($codedstring);

	return $decoded;
	
}
?>
