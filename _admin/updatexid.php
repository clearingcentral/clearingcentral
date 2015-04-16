<?php

$link = mysql_connect('localhost', 'yisorgza_cc', 'WvicADt8mRc'); 

if (!$link) {
   	die('Could not connect: ' . mysql_error());
}

mysql_select_db('yisorgza_clearingcentral', $link);

$nid				= $_POST['nid'];
$currency_symbol	= $_POST['currency_symbol'];
$currency_name		= $_POST['currency_name'];
$currency_name_p	= $_POST['currency_name_p'];
$concurrency_symbol	= $_POST['concurrency_symbol'];
$concurrency_name	= $_POST['concurrency_name'];
$concurrency_name_p	= $_POST['concurrency_name_p'];
$currency_code		= $_POST['currency_code'];

if($currency_code == "EUR") {$concurrency_symbol = "&euro;";}

$strSql = "UPDATE `exchanges` SET `currency_symbol` = '$currency_symbol', `currency_name` = '$currency_name', `currency_name_p` = '$currency_name_p', `concurrency_symbol` = '$concurrency_symbol', `concurrency_name` = '$concurrency_name', `concurrency_name_p` = '$concurrency_name_p', `currency_code` = '$currency_code' WHERE `nid` = '$nid' LIMIT 1";
	
$result = mysql_query($strSql);

if (!$result) {
	die('0');
}

echo "1";
?>
