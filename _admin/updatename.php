<?php

$link = mysql_connect('localhost', 'yisorgza_cc', 'WvicADt8mRc'); 

if (!$link) {
   	die('Could not connect: ' . mysql_error());
}

mysql_select_db('yisorgza_clearingcentral', $link);

$xname_short	= trim($_POST['xname_short']);
$nid			= $_POST['nid'];

$strSql = "UPDATE `exchanges` SET `xname_short` = '$xname_short' WHERE `nid` = '$nid' LIMIT 1";
	
$result = mysql_query($strSql);

if (!$result) {
	die('0');
}

echo "1";
?>
