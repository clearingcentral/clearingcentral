<?php
require('_includes/session.php');

session_destroy();

$strSql = "UPDATE exchanges SET sessid = '' WHERE nid = '$nid'";

mysqli_query($link,$strSql);

header("Location: index.php");
?>

