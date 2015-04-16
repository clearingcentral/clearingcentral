<?php

$link = mysql_connect('localhost', 'yisorgza_cc', 'WvicADt8mRc'); 

if (!$link) {
   	die('Could not connect: ' . mysql_error());
}

mysql_select_db('yisorgza_clearingcentral', $link);

$nid		= $_POST['nid'];
$conv_rate	= $_POST['conv_rate'];

$strSql = "UPDATE `exchanges` SET `conv_rate` = '$conv_rate' WHERE `nid` = '$nid' LIMIT 1";

$result = mysql_query($strSql);

if (!$result) {
	die('0');
}

echo $conv_rate;
?>
