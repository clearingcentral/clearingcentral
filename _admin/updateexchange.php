<?php

require_once('_includes/constants.php');

// Connect to DB

$link = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD);

if (!$link) {
   	die('Could not connect: ' . mysql_error());
}

mysql_select_db(DB_NAME, $link);

if ($_POST['action'] == "update") {

	$nid				= $_POST['nid'];
	$xid				= $_POST['xid'];
	$xname				= url_decode($_POST['xname']);
	$xname_short		= url_decode($_POST['xname_short']);
	$password			= url_decode($_POST['password']);
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
	$currency_code		= $_POST['currency_code'];
	$data_url			= url_decode($_POST['data_url']);
	$request_format		= $_POST['request_format'];
	$response_format	= $_POST['response_format'];
	$administrator		= url_decode($_POST['administrator']);
	$admin_email		= url_decode($_POST['admin_email']);
	$admin_tel			= url_decode($_POST['admin_tel']);
	$conv_rate			= $_POST['conv_rate'];
	$time_offset		= $_POST['time_offset'];
	$active				= $_POST['active'];
	$return				= $_POST['return'];

	if ($currency_code == "EUR") {$concurrency_symbol = "&euro;";}
	if ($active == "1") {$active = -1;} else {$active = 0;}


	$admin_tel = ltrim($admin_tel, "0");
	$admin_tel = append_dialling_code($country) . " " . $admin_tel;
	$admin_email = strtolower($admin_email);

	if ($nid != "") {

		$newexchange = FALSE;

		$strSql = "UPDATE `exchanges` SET `xid` = '$xid',
		`xname` = '$xname',
		`xname_short` = '$xname_short',
		`password` = '$password',
		`system` = '$system',
		`server_id` = '$serverid',
		`server_ip` = '$serverip',
		`administrator` = '$administrator',
		`admin_tel` = '$admin_tel',
		`admin_email` = '$admin_email',
		`location` = '$location',
		`country` = '$country',
		`currency_name` = '$currency_name',
		`currency_name_p` = '$currency_name_p',
		`currency_symbol` = '$currency_symbol',
		`currency_type` = '$currency_type',
		`concurrency_name` = '$concurrency_name',
		`concurrency_name_p` = '$concurrency_name_p',
		`concurrency_symbol` = '$concurrency_symbol',
		`request_format` = '$request_format',
		`response_format` = '$response_format',
		`conv_rate` = '$conv_rate',
		`data_url` = '$data_url',
		`date_edited` = NOW(),
		`time_offset` = '$time_offset',
		`active` = '$active' WHERE `nid` = '$nid' LIMIT 1";

		//die($strSql);

	} else {

		$newexchange = TRUE;
		$nid = makenid();

		$strSql = "INSERT INTO exchanges (
		nid,
		xid,
		xname,
		xname_short,
		password,
		system,
		server_id,
		server_ip,
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
		'$serverip',
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
		'$time_offset',
		'-1',
		'0')";

	}

	$result = mysql_query($strSql);

	if (!$result) {
		die('0');
	}

	if ($newexchange) {
		die($nid);
	} else {
		die('1');
	}

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

function url_decode($codedstring) {

	$codedstring = trim($codedstring);

	$decoded = urldecode($codedstring);

	return $decoded;

}
?>
