<?php

require('_includes/session.php');
include_once('_includes/datetimefunctions.inc');

$status	= $_GET['status'];
$sort	= $_GET['sort'];
$strSql	= "SELECT * FROM exchanges";

switch ($status) {
    case "new":
        $strSql .= " WHERE NOT active AND approve";
        $heading = "List of Exchanges Awaiting Approval";
        break;
    case "active":
        $strSql .= " WHERE active";
        $heading = "List of Active Exchanges";
        break;
    case "inactive":
        $strSql .= " WHERE NOT active";
        $heading = "List of Inactive Exchanges";
        break;
	default:
        $strSql .= " WHERE active";
        $heading = "List of Active Exchanges";
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
    case "sid":
        $strSql .= " ORDER BY server_id ASC, nid ASC";
        break;
    default:
        $strSql .= " ORDER BY nid DESC";
        break;
}

//echo $strSql;

$result = mysqli_query($link, $strSql);

if (!$result) {
	$message  = 'Invalid query: ' . mysqli_error() . "<br>";
	$message .= 'SQL: ' . $strSql;
	die($message);
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8" >
<title><?php echo $heading ?></title>
<link href="styles/cxn.css" rel="stylesheet" type="text/css">
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
</head>
<body style="background-color:#2F2F2F">
<div id="topstrap"><div class="header"><?php echo $heading ?></div></div>
<table width="80%" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td height="36" bgcolor="#000000"><?php require("_includes/dropmenu.inc")?></td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td><table border="0" align="center" cellpadding="2" cellspacing="1">
				<tr id="colheader">
					<td align="center">#</td>
					<td align="center"><a href="listexchanges.php?sort=sid">SID</a></td>
					<td align="center"><a href="listexchanges.php?sort=nid">NID</a></td>
					<td><a href="listexchanges.php?sort=exch">Exchange</a></td>
					<td><a href="listexchanges.php?sort=co">Co</a></td>
					<td>Administrator</td>
					<td>Tel</td>
					<td>Email</td>
					<td><a href="listexchanges.php?sort=date">Created</a></td>
				</tr>
<?php
$intCount = 1;

while ($row = mysqli_fetch_assoc($result)) {

	//nid, xname, password, system, administrator, admin_tel, admin_email, location, country, currency_name, currency_symbol, currency_type, protocol_back, protocol_out, conv_rate, trade_surplus_limit, trade_deficit_limit, url_back, url_out, date_added, date_edited, time_offset, active, approve

	$sid			= $row['server_id'];
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
					<td><?php echo $sid;?></td>
					<td><a href="editexchange.php?nid=<?php echo $nid;?>&status=<?php echo $status;?>"><?php echo $nid;?></a></td>
					<td><?php echo $xname;?></td>
					<td align="center"><?php echo $country;?></td>
					<td><?php echo $admin;?></td>
					<td nowrap="nowrap"><?php echo $admin_tel;?></td>
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
