<?php

require("_includes/session.php");
include_once('_includes/datetimefunctions.inc');

$status	= $_GET['status'];
$sort	= $_GET['sort'];
$strSql	= "SELECT * FROM exchanges";

switch ($status) {
    case "new":
        $strSql .= " WHERE NOT active AND approve";
        break;
    case "active":
        $strSql .= " WHERE active";
        break;
    case "inactive":
        $strSql .= " WHERE NOT active";
        break;
	default:
        $strSql .= " WHERE active";
        $status  = "active";
        break;
}

switch ($sort) {
    case "co":
        $strSql .= " ORDER BY country ASC";
        break;
    case "date":
        $strSql .= " ORDER BY date_added ASC";
        break;
    case "exch":
        $strSql .= " ORDER BY xname ASC";
        break;
    case "nid":
        $strSql .= " ORDER BY nid ASC";
        break;
    default:
        $strSql .= " ORDER BY nid DESC";
        break;
}

//echo $strSql;

$result = mysqli_query($link,$strSql);

if (!$result) {
	$message  = 'Invalid query: ' . mysqli_error($link) . "<br>";
	$message .= 'SQL: ' . $strSql;
	die($message);
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>List Exchanges</title>
<link href="styles/cxn.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
/* Horizontal Menu */
#menu {
	font-size: 10pt;
	color:#FFF
}
#menu ul {
	display: block;
	margin: 0px;
	list-style: none;
	padding-left: 0px;
}
#menu li {
	display: inline;
	border-right: 1px solid #CCC;
	padding: 10px
}
#menu li a {
	color: #F2FBEE;
	font-weight: bold;
	text-decoration: none;
	padding: 2px 0.75em 3px 0.75em;
}
#menu li a:hover {
	background: #C6ECB2 top left repeat-x;
	color: #006600;
}
#menu td {
	padding: 0px;
}
-->
</style>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
</head>
<body style="background-color:#2F2F2F">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
	<tr>
		<td width="10%" style="height:100px; background-image:url(images/header.gif); vertical-align:middle"></td>
		<td width="80%" style="height:100px; background-image:url(images/header.gif); vertical-align:middle"><span style="color:#FFF; font-size:18pt; font-weight:bold">List Exchanges</span></td>
		<td width="10%" style="height:100px; background-image:url(images/header.gif); vertical-align:middle">&nbsp;</td>
	</tr>
</table>
<table width="80%" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td height="36" bgcolor="#000000"><?php require("_includes/dropmenu.inc")?></td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td><table border="0" align="center" cellpadding="2" cellspacing="1">
				<tr id="colheader">
					<td align="center">#</td>
					<td align="center"><a href="listexchanges.php?sort=nid" title="Sort by network ID">NID</a></td>
					<td><a href="listexchanges.php?sort=exch" title="Sort by exchange name">Exchange</a></td>
					<td align="center"><a href="listexchanges.php?sort=co" title="Sort by country">Co</a></td>
					<td>Administrator</td>
					<td>Tel</td>
					<td>Email</td>
					<td><a href="listexchanges.php?sort=date" title="Sort by date added">Created</a></td>
				</tr>
<?php
$intCount = 1;

while ($row = mysqli_fetch_assoc($result)) {

	//nid, xname, password, system, administrator, admin_tel, admin_email, location, country, currency_name, currency_symbol, currency_type, protocol_back, protocol_out, conv_rate, trade_surplus_limit, trade_deficit_limit, url_back, url_out, date_added, date_edited, time_offset, active, approve

	$nid			= $row['nid'];
	$xname			= $row['xname'];
	$system			= $row['system'];
	$location		= $row['location'];
	$country		= $row['country'];
	$admin			= $row['administrator'];
	$admin_tel		= $row['admin_tel'];
	$admin_email	= $row['admin_email'];
	$date_added		= $row['date_added'];

	if ($intCount % 2) { $strBgColor = "#DDDDDD"; } else { $strBgColor = "#EEEEEE"; }
?>
				<tr valign="top" bgcolor="<?php echo $strBgColor;?>" class="textsmall">
					<td align="center"><?php echo $intCount;?></td>
					<td><?php echo $nid;?></td>
					<td><?php echo $xname;?></td>
					<td align="center"><?php echo $country;?></td>
					<td><?php echo $admin;?></td>
					<td><?php echo $admin_tel;?></td>
					<td><a href="mailto:<?php echo $admin_email;?>"><?php echo $admin_email;?></a></td>
					<td nowrap align="right"><?php echo formatDate($date_added,'Y-m-d');?></td>
				</tr>
				<?php
	$intCount = $intCount + 1;
}
?>
			</table></td>
	</tr>
	<tr>
		<td height="36" bgcolor="#000000" class="textWhiteSmall"><span style="color:#FFF; padding-left:10px">This web service is provided by the Community Exchange System (CES)</span></td>
	</tr>
</table>
<?php require("_includes/menufooter.inc")?>
</body>
</html>
