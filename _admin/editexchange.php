<?php

require('_includes/session.php');

$nid	= $_REQUEST['nid'];
$status	= $_REQUEST['status'];

if ($_POST['action'] == "Update") {

	$xname					= checkinput('xname');
	$xname_short			= checkinput('xname_short');
	$password				= checkinput('password');
	$system					= checkinput('system');
	$serverid				= checkinput('server_id');
	$serverip				= checkinput('server_ip');
	$location				= checkinput('location');
	$country				= checkinput('country');
	$currency_name			= checkinput('currency_name');
	$currency_name_p		= checkinput('currency_name_p');
	$currency_symbol		= checkinput('currency_symbol');
	$currency_type			= checkinput('currency_type');
	$concurrency_name		= checkinput('concurrency_name');
	$concurrency_name_p		= checkinput('concurrency_name_p');
	$concurrency_symbol		= checkinput('concurrency_symbol');
	$data_url				= checkinput('data_url');
	$request_format			= checkinput('request_format');
	$response_format		= checkinput('response_format');
	$administrator			= checkinput('administrator');
	$admin_email			= checkinput('admin_email');
	$admin_tel				= checkinput('admin_tel');
	$conv_rate				= checkinput('conv_rate');
	$trade_surplus_limit	= checkinput('trade_surplus_limit');
	$trade_deficit_limit	= checkinput('trade_deficit_limit');
	$time_offset			= checkinput('time_offset');
	$active					= checkinput('active');

	if ($active == "1") {$active = -1;} else { $active = 0; }
	if (stristr($data_url, 'http://') === FALSE && stristr($data_url, 'https://') === FALSE) { $data_url = "http://" . $data_url; }

	$strSql = "UPDATE `exchanges` SET `xname` = '$xname',
	`xname_short` = '$xname_short',
	`password` = '$password',
	`system` = '$system',
	`server_id` = '$serverid',
	`server_ip` = '$serverip',
	`administrator` = '$administrator',
	`admin_tel` = '$admin_tel',
	`admin_email` = '$admin_email',
	`location` = '$location',
	`country` = '$country',
	`currency_name` = '$currency_name',
	`currency_name_p` = '$currency_name_p',
	`currency_symbol` = '$currency_symbol',
	`currency_type` = '$currency_type',
	`concurrency_name` = '$concurrency_name',
	`concurrency_name_p` = '$concurrency_name_p',
	`concurrency_symbol` = '$concurrency_symbol',
	`request_format` = '$request_format',
	`response_format` = '$response_format',
	`conv_rate` = '$conv_rate',
	`trade_surplus_limit` = '$trade_surplus_limit',
	`trade_deficit_limit` = '$trade_deficit_limit',
	`data_url` = '$data_url',
	`date_edited` = NOW(),
	`time_offset` = '$time_offset',
	`active` = '$active',
	`approve` = '0' WHERE `nid` = '$nid' LIMIT 1";

	$result = mysqli_query($link, $strSql);

	if (!$result) {
		$message  = 'Invalid query: ' . mysqli_error() . "<br>";
		$message .= 'SQL: ' . $strSql;
		die($message);
	}

	//die($strSql);

}

if ($_POST['action'] == "Delete") {

	$strSql = "DELETE FROM exchanges WHERE nid = '$nid'";

	$result = mysqli_query($link, $strSql);

	if (!$result) {
		$message  = 'Invalid query: ' . mysqli_error() . "<br>";
		$message .= 'SQL: ' . $strSql;
		die($message);
	}

	header("Location: listexchanges.php?status=" . $status);

}

$strSql = "SELECT * FROM exchanges WHERE nid = '$nid'";
$result = mysqli_query($link, $strSql);

if (!$result) {
	$message  = 'Invalid query: ' . mysqli_error() . "<br>";
	$message .= 'SQL: ' . $strSql;
	die($message);
}

$row = mysqli_fetch_assoc($result);

$xname					= $row['xname'];
$xname_short			= $row['xname_short'];
$xid					= $row['xid'];
$password				= $row['password'];
$system					= $row['system'];
$serverid				= $row['server_id'];
$serverip				= $row['server_ip'];
$administrator			= $row['administrator'];
$admin_tel				= $row['admin_tel'];
$admin_email			= $row['admin_email'];
$location				= $row['location'];
$country				= $row['country'];
$currency_name			= $row['currency_name'];
$currency_name_p		= $row['currency_name_p'];
$currency_symbol		= $row['currency_symbol'];
$currency_type			= $row['currency_type'];
$concurrency_name		= $row['concurrency_name'];
$concurrency_name_p		= $row['concurrency_name_p'];
$concurrency_symbol		= $row['concurrency_symbol'];
$request_format			= $row['request_format'];
$response_format		= $row['response_format'];
$conv_rate				= $row['conv_rate'];
$trade_surplus_limit	= $row['trade_surplus_limit'];
$trade_deficit_limit	= $row['trade_deficit_limit'];
$data_url				= $row['data_url'];
$date_added				= $row['date_added'];
$date_edited			= $row['date_edited'];
$time_offset			= $row['time_offset'];
$active					= $row['active'];
$approve				= $row['approve'];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Edit Record</title>
<link href="styles/cxn.css" rel="stylesheet" type="text/css">
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
</head>
<body style="background-color:#2F2F2F">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
	<tr>
		<td width="10%" style="height:100px; background-image:url(images/header.gif); vertical-align:middle"></td>
		<td width="80%" style="height:100px; background-image:url(images/header.gif); vertical-align:middle"><span style="color:#FFF; font-size:18pt; font-weight:bold">Edit Exchange Record</span></td>
		<td width="10%" style="height:100px; background-image:url(images/header.gif); vertical-align:middle">&nbsp;</td>
	</tr>
</table>
<form method="post" action="editexchange.php">
<table width="80%" align="center" cellpadding="0" cellspacing="0" style="margin-bottom:0px">
	<tr>
		<td height="36" bgcolor="#000000"><?php require("_includes/dropmenu.inc")?></td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td>
				<table width="640" border="0" cellspacing="0" align="center" cellpadding="2">
					<tr bgcolor="#3F3F3F">
						<td colspan="2" align="center" bgcolor="#3F3F3F" class="textboldWhite">Exchange details</td>
					</tr>
					<tr bgcolor="#EEEEEE" class="text">
						<td align="right">NID:</td>
						<td><b><?php echo $nid;?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;XID: <b><?php echo $xid;?></b></td>
					</tr>
					<tr bgcolor="#DDDDDD" class="text">
						<td align="right">Server ID/IP:</td>
						<td><input type="text" size="10" name="server_id" id="server_id" value="<?php echo $serverid;?>" /> <input type="text" maxlength="15" size="16" name="server_ip" id="server_ip" value="<?php echo $serverip;?>" /></td>
					</tr>
					<tr bgcolor="#EEEEEE" class="text">
						<td align="right">Exchange name (full):</td>
						<td><input type="text" size="36" name="xname" id="xname" value="<?php echo $xname;?>" /></td>
					</tr>
					<tr bgcolor="#EEEEEE" class="text">
						<td align="right">(short):</td>
						<td><input type="text" name="xname_short" id="xname_short" value="<?php echo $xname_short;?>" /></td>
					</tr>
					<tr bgcolor="#DDDDDD" class="text">
						<td align="right">Password:</td>
						<td><input type="text" name="password" id="password" value="<?php echo $password;?>" /></td>
					</tr>
					<tr bgcolor="#EEEEEE" class="text">
						<td align="right">System (e.g. CES, Cyclos etc.):</td>
						<td><input type="text" name="system" id="system" value="<?php echo $system;?>" /></td>
					</tr>
					<tr bgcolor="#DDDDDD" class="text">
						<td align="right">Location:</td>
						<td><input type="text" name="location" id="location" value="<?php echo $location;?>" /></td>
					</tr>
					<tr bgcolor="#EEEEEE" class="text">
						<td align="right">Country:</td>
						<td><input name="country" type="text" id="country" maxlength="2" size="3" value="<?php echo $country;?>" /></td>
					</tr>
					<tr bgcolor="#DDDDDD" class="text">
						<td align="right">Local currency names S/P:</td>
						<td><input type="text" name="currency_name" size="15" id="currency_name" value="<?php echo $currency_name;?>" /><input type="text" name="currency_name_p" size="15" id="currency_name_p" value="<?php echo $currency_name_p;?>" /></td>
					</tr>
					<tr bgcolor="#EEEEEE" class="text">
						<td align="right">National currency names S/P:</td>
						<td><input type="text" name="concurrency_name" size="15" id="concurrency_name" value="<?php echo $concurrency_name;?>" /><input type="text" name="concurrency_name_p" size="15" id="concurrency_name_p" value="<?php echo $concurrency_name_p;?>" /></td>
					</tr>
					<tr bgcolor="#DDDDDD" class="text">
						<td align="right">Currency symbols Loc/Nat:</td>
						<td><input name="currency_symbol" type="text" id="currency_symbol" size="6" value="<?php echo $currency_symbol;?>" /><input name="concurrency_symbol" type="text" id="concurrency_symbol" size="6" value="<?php echo $concurrency_symbol;?>" /></td>
					</tr>
					<tr bgcolor="#EEEEEE" class="text">
						<td align="right">Currency type:</td>
						<td><select name="currency_type" id="currency_type">
								<option value="">Select...</option>
								<option value="mc"<?php if($currency_type == "mc"){echo " selected";}?>>Mutual Credit</option>
								<option value="tb"<?php if($currency_type == "tb"){echo " selected";}?>>Timebank</option>
							</select></td>
					</tr>
					<tr bgcolor="#DDDDDD" class="text">
						<td align="right">URL for incoming transactions:</td>
						<td><input type="text" name="data_url" id="data_url" size="48" value="<?php echo $data_url;?>" /></td>
					</tr>
					<tr bgcolor="#EEEEEE" class="text">
						<td align="right">Request format:</td>
						<td>
							<select name="request_format" id="request_format">
								<option value="get"<?php if($request_format == "get"){echo " selected";}?>>HTTP Get</option>
								<option value="post"<?php if($request_format == "post"){echo " selected";}?>>HTTP Post</option>
								<option value="csv"<?php if($request_format == "csv"){echo " selected";}?>>CSV</option>
								<option value="json"<?php if($request_format == "json"){echo " selected";}?>>JSON</option>
								<option value="xml"<?php if($request_format == "xml"){echo " selected";}?>>XML</option>
							</select>
						</td>
					</tr>
					<tr bgcolor="#DDDDDD" class="text">
						<td align="right">Response format:</td>
						<td>
							<select name="response_format" id="response_format">
								<option value="get"<?php if($response_format == "get"){echo " selected";}?>>HTTP Get</option>
								<option value="post"<?php if($response_format == "post"){echo " selected";}?>>HTTP Post</option>
								<option value="csv"<?php if($response_format == "csv"){echo " selected";}?>>CSV</option>
								<option value="json"<?php if($response_format == "json"){echo " selected";}?>>JSON</option>
								<option value="xml"<?php if($response_format == "xml"){echo " selected";}?>>XML</option>
							</select>
						</td>
					</tr>
					<tr bgcolor="#EEEEEE" class="text">
						<td align="right">Conversion rate:</td>
						<td><input name="conv_rate" type="text" id="conv_rate" size="4" value="<?php echo $conv_rate;?>" /></td>
					</tr>
					<tr bgcolor="#DDDDDD" class="text">
						<td align="right">Trade surplus limit:</td>
						<td><input type="text" name="trade_surplus_limit" id="trade_surplus_limit" value="<?php echo $trade_surplus_limit;?>" /></td>
					</tr>
					<tr bgcolor="#EEEEEE" class="text">
						<td align="right">Trade deficit limit:</td>
						<td><input type="text" name="trade_deficit_limit" id="trade_deficit_limit" value="<?php echo $trade_deficit_limit;?>" /></td>
					</tr>
					<tr bgcolor="#DDDDDD" class="text">
						<td align="right">Date created:</td>
						<td class="text"><?php echo $date_added;?></td>
					</tr>
					<tr bgcolor="#EEEEEE" class="text">
						<td align="right">Date edited:</td>
						<td class="text"><?php echo $date_edited;?></td>
					</tr>
					<tr bgcolor="#DDDDDD" class="text">
						<td align="right">Time offset:</td>
						<td><select name="time_offset" class="text" id="time_offset">
								<option value="-12"<?php if($time_offset == -12) {echo " selected";}?>>GMT-12</option>
								<option value="-11"<?php if($time_offset == -11) {echo " selected";}?>>GMT-11</option>
								<option value="-10"<?php if($time_offset == -10) {echo " selected";}?>>GMT-10</option>
								<option value="-9"<?php if($time_offset == -9) {echo " selected";}?>>GMT-9</option>
								<option value="-8"<?php if($time_offset == -8) {echo " selected";}?>>GMT-8</option>
								<option value="-7"<?php if($time_offset == -7) {echo " selected";}?>>GMT-7</option>
								<option value="-6"<?php if($time_offset == -6) {echo " selected";}?>>GMT-6</option>
								<option value="-5"<?php if($time_offset == -5) {echo " selected";}?>>GMT-5</option>
								<option value="-4"<?php if($time_offset == -4) {echo " selected";}?>>GMT-4</option>
								<option value="-3"<?php if($time_offset == -3) {echo " selected";}?>>GMT-3</option>
								<option value="-2"<?php if($time_offset == -2) {echo " selected";}?>>GMT-2</option>
								<option value="-1"<?php if($time_offset == -1) {echo " selected";}?>>GMT-1</option>
								<option value="0"<?php if($time_offset == 0) {echo " selected";}?>>GMT</option>
								<option value="1"<?php if($time_offset == 1) {echo " selected";}?>>GMT+1</option>
								<option value="2"<?php if($time_offset == 2) {echo " selected";}?>>GMT+2</option>
								<option value="3"<?php if($time_offset == 3) {echo " selected";}?>>GMT+3</option>
								<option value="4"<?php if($time_offset == 4) {echo " selected";}?>>GMT+4</option>
								<option value="5"<?php if($time_offset == 5) {echo " selected";}?>>GMT+5</option>
								<option value="6"<?php if($time_offset == 6) {echo " selected";}?>>GMT+6</option>
								<option value="7"<?php if($time_offset == 7) {echo " selected";}?>>GMT+7</option>
								<option value="8"<?php if($time_offset == 8) {echo " selected";}?>>GMT+8</option>
								<option value="9"<?php if($time_offset == 9) {echo " selected";}?>>GMT+9</option>
								<option value="10"<?php if($time_offset == 10) {echo " selected";}?>>GMT+10</option>
								<option value="11"<?php if($time_offset == 11) {echo " selected";}?>>GMT+11</option>
								<option value="12"<?php if($time_offset == 12) {echo " selected";}?>>GMT+12</option>
							</select></td>
					</tr>
					<tr bgcolor="#EEEEEE" class="text">
						<td align="right">Active:</td>
						<td><input type="checkbox" name="active" id="active" value="1"<?php if($active){echo " checked";}?> /></td>
					</tr>
					<tr bgcolor="#3F3F3F" class="text">
						<td colspan="2" align="center" class="textboldWhite">Administrator details</td>
					</tr>
					<tr bgcolor="#DDDDDD" class="text">
						<td align="right">Name:</td>
						<td><input type="text" name="administrator" size="32" id="administrator" value="<?php echo $administrator;?>" /></td>
					</tr>
					<tr bgcolor="#EEEEEE" class="text">
						<td align="right">Email:</td>
						<td><input type="text" name="admin_email" size="32" id="admin_email" value="<?php echo $admin_email;?>" /></td>
					</tr>
					<tr bgcolor="#DDDDDD" class="text">
						<td align="right">Telephone:</td>
						<td><input type="text" name="admin_tel" id="admin_tel" value="<?php echo $admin_tel;?>" /></td>
					</tr>
					<tr bgcolor="#3F3F3F" class="text">
						<td align="right">&nbsp;</td>
						<td><input type="submit" name="action" id="action" value="Update" /><div style="float:right;"><input style="color:red" type="submit" name="action" id="action" value="Delete" /></div></td>
					</tr>
				</table>
				<input type="hidden" name="nid" value="<?php echo $nid?>" />
				<input type="hidden" name="status" value="<?php echo $status?>" />
			</td>
	</tr>
	<tr>
		<td height="36" bgcolor="#000000">&nbsp;</td>
	</tr>
</table>
</form>
<?php require("_includes/menufooter.inc")?>
</body>
</html>
