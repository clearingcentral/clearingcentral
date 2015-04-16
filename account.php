<?php
require("_includes/session.php");

// This is the user's account page for editing

if ($_POST['action'] == "Update"){

	// Get form variables

	$xname			= $_POST['xname'];			//Name of exchange
	$xname_short	= $_POST['xname_short'];	//Short name of exchange
	$password		= $_POST['password'];		//Record password
	$administrator	= $_POST['administrator'];	//System administrator
	$admin_tel		= $_POST['admin_tel'];
	$admin_email	= $_POST['admin_email'];
	$location		= $_POST['location'];
	$country		= $_POST['country'];
	$system			= $_POST['system'];
	$currency_name	= $_POST['currency_name'];
	$currency_name_p	= $_POST['currency_name_p'];
	$currency_symb	= $_POST['currency_symbol'];
	$currency_type	= $_POST['currency_type'];
	$server_ip		= $_POST['server_ip'];
	$request_format	= $_POST['request_format'];	//Format used in transaction request
	$response_format= $_POST['response_format']; //Format used in response
	$data_url		= $_POST['data_url'];
	$active			= $_POST['active'];

	if ($active == "") { $active = 0; }
	if (stristr($data_url, 'http://') === FALSE && stristr($data_url, 'https://') === FALSE) { $data_url = "http://" . $data_url; }

	$strSql = "UPDATE exchanges SET xname = '".$xname."',
	xname_short = '".$xname_short."',
	password = '".$password."',
	system = '".$system."',
	administrator = '".$administrator."',
	admin_tel = '".$admin_tel."',
	admin_email = '".$admin_email."',
	location = '".$location."',
	country = '".$country."',
	currency_name = '".$currency_name."',
	currency_name_p = '".$currency_name_p."',
	currency_symbol = '".$currency_symb."',
	currency_type = '".$currency_type."',
	server_ip = '".$server_ip."',
	request_format = '".$request_format."',
	response_format = '".$response_format."',
	data_url = '".$data_url."',
	date_edited = NOW(),
	active = ".$active." WHERE nid = '".$nid."'";

	//die($strSql);

    $result = mysqli_query($link,$strSql);

	if (!$result) {
		$message  = 'Invalid query: ' . mysqli_error($link) . "<br>";
		$message .= 'Whole query: ' . $strSql;
		die($message);
	}
}

if ($_POST['action'] == "Delete"){

	$strSql = "DELETE FROM exchanges WHERE nid = '$nid'";

	$result = mysqli_query($link,$strSql);

	if (!$result) {
		$message  = 'Invalid query: ' . mysqli_error($link) . "<br>";
		$message .= 'SQL: ' . $strSql;
		die($message);
	}

	header("Location: index.php");

}

// Get account details to display

$strSql = "SELECT * FROM exchanges WHERE nid = '" . $nid . "'";
$result = mysqli_query($link,$strSql);

if (!$result) {
	$message  = 'Invalid query: ' . mysqli_error($link) . "<br>";
	$message .= 'Whole query: ' . $strSql;
} else {
	$row			= mysqli_fetch_assoc($result);
	$xname			= $row['xname'];			//Name of exchange
	$xname_short	= $row['xname_short'];		//Short name of exchange
	$password		= $row['password'];			//Record password
	$system			= $row['system'];			//System exchange uses (e.g. CES)
	$administrator	= $row['administrator'];	//System administrator
	$admin_tel		= $row['admin_tel'];
	$admin_email	= $row['admin_email'];
	$location		= $row['location'];			//Location of exchange
	$country		= $row['country'];			//Country of exchange
	$currency_name	= $row['currency_name'];
	$currency_name_p	= $row['currency_name_p'];
	$currency_symb	= $row['currency_symbol'];
	$currency_type	= $row['currency_type'];
	$server_ip		= $row['server_ip'];
	$request_format	= $row['request_format'];
	$response_format= $row['response_format'];
	$data_url		= $row['data_url'];
	$date_added		= $row['date_added'];
	$date_edited	= $row['date_edited'];
	$active			= $row['active'];

	$date_added		= strftime("%Y-%m-%d",strtotime($date_added));
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Community Exchange Network</title>
<link href="styles/cxn.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
</head>
<body style="background-color:#2F2F2F">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
	<tr>
		<td width="10%" style="height:100px; background-image:url(images/header.gif); vertical-align:middle"></td>
		<td width="80%" style="height:100px; background-image:url(images/header.gif); vertical-align:middle"><span style="color:#FFF; font-size:18pt; font-weight:bold">Edit Exchange Record</span></td>
		<td width="10%" style="height:100px; background-image:url(images/header.gif); vertical-align:middle">&nbsp;</td>
	</tr>
</table>
<form method="post" action="account.php">
	<table width="80%" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td height="36" bgcolor="#000000"><?php require("_includes/dropmenu.inc")?></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td><table border="0" align="center" cellpadding="4" cellspacing="0">
					<tr bgcolor="#3f3f3f">
						<td colspan="2" bgcolor="#3f3f3f" class="textboldWhite">Exchange Details</td>
					</tr>
					<tr bgcolor="#DDDDDD">
						<td align="right" class="text">Network ID:</td>
						<td class="textbold"><?php echo $nid?></td>
					</tr>
					<tr bgcolor="#EEEEEE">
						<td align="right" class="text">Password:</td>
						<td class="textbold"><input name="password" type="password" class="text" id="password" value="<?php echo $password?>"/></td>
					</tr>
					<tr bgcolor="#DDDDDD">
						<td align="right" class="text">Exchange name (full):</td>
						<td><input name="xname" type="text" class="text" id="xname" size="32" value="<?php echo $xname;?>"/></td>
					</tr>
					<tr bgcolor="#DDDDDD">
						<td align="right" class="text">(short):</td>
						<td><input name="xname_short" type="text" class="text" id="xname_short" size="32" value="<?php echo $xname_short;?>"/></td>
					</tr>
					<tr bgcolor="#EEEEEE">
						<td align="right" class="text">System:</td>
						<td><input name="system" type="text" class="text" id="system" size="32" value="<?php echo $system;?>" /></td>
					</tr>
					<tr bgcolor="#DDDDDD">
						<td align="right" class="text">Location:</td>
						<td><input name="location" type="text" class="text" id="location" size="32" value="<?php echo $location;?>" /></td>
					</tr>
					<tr bgcolor="#EEEEEE">
						<td align="right" class="text">Country:</td>
						<td><input name="country" type="text" class="text" id="country" maxlength="2" size="3" value="<?php echo $country;?>" /></td>
					</tr>
					<tr bgcolor="#DDDDDD">
						<td align="right" class="text">Currency name S/P:</td>
						<td><input name="currency_name" size="10" type="text" class="text" id="currency_name" value="<?php echo $currency_name?>"/> <input name="currency_name_p" size="10" type="text" class="text" id="currency_name_p" value="<?php echo $currency_name_p?>"/></td>
					</tr>
					<tr bgcolor="#EEEEEE">
						<td align="right" class="text">Currency symbol:</td>
						<td><input name="currency_symbol" type="text" class="text" id="currency_symbol" value="<?php echo $currency_symb?>" size="6" /></td>
					</tr>
					<tr bgcolor="#DDDDDD">
						<td align="right" class="text">Currency type:</td>
						<td><select name="currency_type" class="text">
								<option value="mc"<?php if($currency_type=="mc"){echo ' selected="selected"';}?>>Mutual credit</option>
								<option value="tb"<?php if($currency_type=="tb"){echo ' selected="selected"';}?>>Timebank</option>
							</select></td>
					</tr>
					<tr bgcolor="#EEEEEE">
						<td align="right" class="text">Record created:</td>
						<td class="textbold"><?php echo $date_added?></span></td>
					</tr>
					<tr bgcolor="#DDDDDD">
						<td align="right" class="text">Record edited:</td>
						<td class="textbold"><?php echo $date_edited?></td>
					</tr>
					<tr bgcolor="#EEEEEE">
						<td align="right" class="text">Active:</td>
						<td><input name="active" type="checkbox" class="text" id="active" value="-1"<?php if($active){echo " checked";}?> /></td>
					</tr>
					<tr bgcolor="#0000FF">
						<td colspan="2" bgcolor="#3f3f3f" class="textboldWhite">Admin Contact</td>
					</tr>
					<tr bgcolor="#DDDDDD">
						<td align="right" class="text">Administrator:</td>
						<td><input type="text" class="text" id="administrator" size="32" name="administrator" value="<?php echo $administrator?>" /></td>
					</tr>
					<tr bgcolor="#EEEEEE">
						<td align="right" class="text">Telephone:</td>
						<td><input name="admin_tel" type="text" class="text" size="32" id="admin_tel" value="<?php echo $admin_tel?>" /></td>
					</tr>
					<tr bgcolor="#DDDDDD">
						<td align="right" class="text">Email:</td>
						<td><input name="admin_email" type="text" class="text" size="32" id="admin_email" value="<?php echo $admin_email?>" /></td>
					</tr>
					<tr bgcolor="#0000FF">
						<td colspan="2" bgcolor="#3f3f3f" class="text"><span class="textboldWhite">Parameters</span></td>
					</tr>
					<tr bgcolor="#EEEEEE">
						<td align="right" class="text">Server IP address:</td>
						<td class="textbold"><input name="server_ip" type="text" class="text" id="server_ip" maxlength="15" size="17" value="<?php echo $server_ip?>" /></td>
					</tr>
					<tr bgcolor="#DDDDDD">
						<td align="right" class="text">Incoming data URL:</td>
						<td class="textbold"><input name="data_url" type="text" class="text" id="data_url" size="48" value="<?php echo $data_url?>" /></td>
					</tr>
					<tr bgcolor="#EEEEEE">
						<td align="right" class="text">Request data format:</td>
						<td class="textbold">
							<select name="request_format" id="request_format">
								<option value="get"<?php if($request_format == "get"){echo ' selected="selected"';}?>>HTTP Get</option>
								<option value="post"<?php if($request_format == "post"){echo ' selected="selected"';}?>>HTTP Post</option>
								<option value="csv"<?php if($request_format == "csv"){echo ' selected="selected"';}?>>CSV</option>
								<option value="json"<?php if($request_format == "json"){echo ' selected="selected"';}?>>JSON</option>
								<option value="xml"<?php if($request_format == "xml"){echo ' selected="selected"';}?>>XML</option>
							</select>
						</td>
					</tr>
					<tr bgcolor="#DDDDDD">
						<td align="right" nowrap class="text">Response data format:</td>
						<td class="textbold">
							<select name="response_format" id="response_format">
								<option value="get"<?php if($response_format == "get"){echo ' selected="selected"';}?>>HTTP Get</option>
								<option value="post"<?php if($response_format == "post"){echo ' selected="selected"';}?>>HTTP Post</option>
								<option value="csv"<?php if($response_format == "csv"){echo ' selected="selected"';}?>>CSV</option>
								<option value="json"<?php if($response_format == "json"){echo ' selected="selected"';}?>>JSON</option>
								<option value="xml"<?php if($response_format == "xml"){echo ' selected="selected"';}?>>XML</option>
							</select>
						</td>
					</tr>
					<tr bgcolor="#313031">
						<td><input type="button" class="text" value="&laquo; Back" title="Back to index page" onClick="parent.location='main.php'" /></td>
						<td><div style="float:left"><input class="text" type="submit" name="action" id="submit" value="Update" title="Update this record" /></div><div style="float:right"><input class="text" style="color:red" type="submit" name="action" id="submit" value="Delete" title="Delete this record" /></div></td>
					</tr>
				</table></td>
		</tr>
		<tr>
			<td height="36" bgcolor="#000000" class="textWhiteSmall" style="padding-left:20px">This web service is provided by the Community Exchange System (<a href="http://www.community-exchange.org" target="_blank">CES</a>)</td>
		</tr>
	</table>
</form>
<?php require("_includes/menufooter.inc")?>
</body>
</html>
