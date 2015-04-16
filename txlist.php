<?php

require("_includes/session.php");
include_once('_includes/datetimefunctions.inc');

$sort	= $_GET['sort'];
$nid	= $_SESSION['nid'];
$strSql	= "SELECT * FROM transactions WHERE buyer_nid = '$nid' OR seller_nid = '$nid' ORDER BY date_entered ASC";

/*switch ($sort) {
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
}*/

//echo $strSql;

$result = mysqli_query($link,$strSql);

if (!$result) {
	$message  = 'Invalid query: ' . mysqli_error($link) . "<br>";
	$message .= 'SQL: ' . $strSql;
	die($message);
}
?>
<html>
<head>
<title>List Transactions</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
		<td width="80%" style="height:100px; background-image:url(images/header.gif); vertical-align:middle"><span style="color:#FFF; font-size:18pt; font-weight:bold">List Transactions</span></td>
		<td width="10%" style="height:100px; background-image:url(images/header.gif); vertical-align:middle">&nbsp;</td>
	</tr>
</table>
<table width="80%" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td height="36" bgcolor="#000000"><?php require("_includes/dropmenu.inc")?></td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td><table border="0" align="center" cellpadding="2" cellspacing="1">
				<tr bgcolor="#666666" class="textboldWhite">
					<td align="center">#</td>
					<td><a href="txlist.php?sort=date"><font color="#FFFFFF">Date</font></a></td>
					<td><a href="txlist.php?sort=buyer"><font color="#FFFFFF">Seller</font></a></td>
					<td><a href="txlist.php?sort=buyer"><font color="#FFFFFF">Buyer</font></a></td>
					<td><a href="txlist.php?sort=descr"><font color="#FFFFFF">Description</font></a></td>
					<td><a href="txlist.php?sort=crd"><font color="#FFFFFF">Credit</font></a></td>
					<td><a href="txlist.php?sort=deb"><font color="#FFFFFF">Debit</font></a></td>
					<td><a href="txlist.php?sort=bal"><font color="#FFFFFF">Status</font></a></td>
				</tr>
<?php
$intCount = 1;

while ($row = mysqli_fetch_assoc($result)) {

	$txid			= $row['txid'];
	$buyer_id		= $row['buyer_id'];
	$buyer_name		= $row['buyer_name'];
	$buyer_nid		= $row['buyer_nid'];
	$seller_id		= $row['seller_id'];
	$seller_name	= $row['seller_name'];
	$seller_nid		= $row['seller_nid'];
	$description	= $row['description'];
	$amount			= $row['amount'];
	$date_entered	= $row['date_entered'];
	$status			= $row['result'];

	if ($seller_nid == $nid) {
		$credit = $amount;
	} else {
		$credit = "&nbsp;";
	}

	if ($buyer_nid == $nid) {
		$debit = $amount;
	} else {
		$debit = "&nbsp;";
	}

	if ($intCount % 2) { $strBgColor = "#DDDDDD"; } else { $strBgColor = "#EEEEEE"; }
	?>
				<tr valign="top" bgcolor="<?php echo $strBgColor;?>" class="textSmall">
					<td align="center"><?php echo $intCount;?></td>
					<td nowrap align="right"><?php echo formatDate($date_entered,'Y-m-d');?></td>
					<td><?php echo $seller_id;?> - <?php echo $seller_name;?></td>
					<td><?php echo $buyer_id?> - <?php echo $buyer_name;?></td>
					<td><?php echo $description;?></td>
					<td><?php echo $credit;?></td>
					<td><?php echo $debit;?></td>
					<td align="center"><?php echo $status;?></td>
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
