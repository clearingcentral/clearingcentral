<?php

require_once('_includes/constants.php');

// Connect to DB

$link = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD); 

if (!$link) {
   	die('Could not connect: ' . mysql_error());
}

mysql_select_db(DB_NAME, $link);

if ($_POST['action'] == "update") {

	$nid					= $_POST['nid'];

	if (empty($nid)) {$nid = makenid();}

	$xname					= trim($_POST['xname']);
	$password				= trim($_POST['password']);
	$system					= $_POST['system'];
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
	$conv_rate				= $_POST['conv_rate'];
	$time_offset			= $_POST['time_offset'];
	$active					= $_POST['active'];
	$return					= $_POST['return'];

	if ($active) {$active = -1;} else {$active = 0;}

	$admin_tel = ltrim($admin_tel, "0"); 
	$admin_tel = append_dialling_code($country) . " " . $admin_tel;

	//See if this exchange exists

	/*if (!mysql_num_rows(mysql_query("SELECT nid FROM exchanges WHERE nid = '$nid'"))) {

		$strSql = "INSERT INTO exchanges (
		nid,
		xname,
		password,
		system,
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
		'$xname',
		'$password',
		'$system',
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

		die $strSql;

	} else {*/

		$strSql = "UPDATE `exchanges` SET `xname` = '$xname',
		`password` = '$password',
		`system` = '$system',
		`administrator` = '$administrator',
		`admin_tel` = '$admin_tel',
		`admin_email` = '$admin_email',
		`location` = '$location',
		`country` = '$country',
		`currency_name` = '$currency_name',
		`currency_symbol` = '$currency_symbol',
		`currency_type` = '$currency_type',
		`request_format` = '$request_format',
		`response_format` = '$response_format',
		`conv_rate` = '$conv_rate',
		`data_url` = '$data_url',
		`date_edited` = NOW(),
		`time_offset` = '$time_offset',
		`active` = '$active' WHERE `nid` = '$nid' LIMIT 1";

		//die($strSql);

	//}

	$result = mysql_query($strSql);

	if (!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "<br>";
		$message .= 'SQL: ' . $strSql;
		die($message);
	}

	die('1');

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

?>
