<?php

require_once('_includes/constants.php');

// Connect to DB

$link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (!$link) {
   	die('Could not connect: ' . mysqli_error($link));
}

$strXID	= $_POST['xid'];
$strNID	= $_POST['nid'];
$strSql	= "SELECT nid, xid, xname_short, country FROM exchanges WHERE xid = '$strXID' OR nid = '$strNID'";

$result = mysqli_query($link,$strSql);
$row = mysqli_fetch_assoc($result);

$nid			= $row['nid'];
$xid			= $row['xid'];
$xname_short	= $row['xname_short'];
$country		= $row['country'];

exit($nid."|".$xid."|".$xname_short."|".$country);
?>
