<?php

require('_includes/session.php');
include_once('_includes/datetimefunctions.inc');

if ($_POST['action'] == "Delete") {

	//Delete transactions in table

	$ids = $_POST['del'];

	if ($ids != "") {
		foreach ($ids as $id) {
    		$sql = "DELETE FROM transactions WHERE id = " . $id;
			$result = mysqli_query($link, $sql);
		}
	}

}

$sort		= $_GET['sort'];
$nid		= $_REQUEST['nid'];
$strSql		= "SELECT * FROM transactions";
$datesort	= "dateasc";

if ($nid != "") { $strSql .= " WHERE buyer_nid = '$nid' OR seller_nid = '$nid'"; }

switch ($sort) {
    case "buyer":
        $strSql .= " ORDER BY buyer_id ASC, date_entered ASC";
        break;
    case "seller":
        $strSql .= " ORDER BY seller_id ASC, date_entered ASC";
        break;
    case "bnid":
        $strSql .= " ORDER BY buyer_nid ASC, date_entered ASC";
        break;
    case "snid":
        $strSql .= " ORDER BY seller_nid ASC, date_entered ASC";
        break;
    case "amount":
        $strSql .= " ORDER BY amount ASC, date_entered ASC";
        break;
    case "descr":
        $strSql .= " ORDER BY description ASC, date_entered ASC";
        break;
    case "dateasc":
        $strSql .= " ORDER BY date_entered ASC";
        $datesort = "datedesc";
        break;
    case "datedesc":
        $strSql .= " ORDER BY date_entered DESC";
        $datesort = "dateasc";
        break;
     case "status":
        $strSql .= " ORDER BY response ASC, date_entered ASC";
        break;
   default:
        $strSql .= " ORDER BY date_entered DESC";
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
<html>
<head>
<title>List Transactions</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="styles/cxn.css" rel="stylesheet" type="text/css">
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="topstrap"><div class="header">List Transactions</div></div>
<table width="80%" align="center" cellpadding="0" cellspacing="0">
	<form method="post" action="txlist.php">
	<tr>
		<td height="36" bgcolor="#000000"><?php require("_includes/dropmenu.inc")?></td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td><table border="0" align="center" cellpadding="2" cellspacing="1">
				<tr id="colheader">
					<td align="center">#</td>
					<td><a href="txlist.php?sort=<?php echo $datesort; ?>">Date</a></td>
					<td><a href="txlist.php?sort=seller">Seller</a></td>
					<td><a href="txlist.php?sort=snid">S&nbsp;NID</a></td>
					<td><a href="txlist.php?sort=buyer">Buyer</a></td>
					<td><a href="txlist.php?sort=bnid">B&nbsp;NID</a></td>
					<td><a href="txlist.php?sort=descr">Description</a></td>
					<td><a href="txlist.php?sort=crd">S&nbsp;Amount</a></td>
					<td><a href="txlist.php?sort=crd">B&nbsp;Amount</a></td>
					<td><a href="txlist.php?sort=status">Status</a></td>
					<td><input type="submit" name="action" value="Delete" style="border-radius: 5px;" title="Delete selected items" /></td>
				</tr>
<?php
$intCount = 1;

while ($row = mysqli_fetch_assoc($result)) {

	$id				= $row['id'];
	$buyer_id		= $row['buyer_id'];
	$buyer_name		= $row['buyer_name'];
	$buyer_nid		= $row['buyer_nid'];
	$seller_id		= $row['seller_id'];
	$seller_name	= $row['seller_name'];
	$seller_nid		= $row['seller_nid'];
	$description	= $row['description'];
	$seller_amount	= $row['seller_amount'];
	$buyer_amount	= $row['buyer_amount'];
	$date_entered	= $row['date_entered'];
	$status			= $row['response'];

	if ($intCount % 2) { $strBgColor = "#DDDDDD"; } else { $strBgColor = "#EEEEEE"; }
	?>
				<tr valign="top" bgcolor="<?php echo $strBgColor;?>" class="textSmall">
					<td align="center"><?php echo $intCount;?></td>
					<td nowrap align="right"><?php echo formatDate($date_entered,'Y-m-d');?></td>
					<td><?php echo $seller_name;?> (<?php echo $seller_id;?>)</td>
					<td align="center"><?php echo $seller_nid;?></td>
					<td><?php echo $buyer_name;?> (<?php echo $buyer_id?>)</td>
					<td align="center"><?php echo $buyer_nid;?></td>
					<td><?php echo $description;?></td>
					<td align="right"><?php echo $seller_amount;?></td>
					<td align="right"><?php echo $buyer_amount;?></td>
					<td align="center"><?php echo $status;?></td>
					<td align="center"><input type="checkbox" name='del[]' id='del[]' value="<?php echo $id; ?>"></td>
				</tr>
	<?php
	$intCount++;
}
?>
			</table></td>
	</tr>
	<tr>
		<td align="center" height="36" bgcolor="#000000" class="textWhiteSmall"><span style="color:#FFF; padding-left:10px">This web service is provided by the Community Exchange System (CES)</span></td>
	</tr>
	</form>
</table>
<?php require("_includes/menufooter.inc")?>
</body>
</html>
