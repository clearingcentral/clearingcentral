<?php
require('_includes/session.php');

$back = checkinput('back');

if ($_REQUEST['action'] == "insert") {

	$nid 					= checkinput('nid');

	if ($nid == "0") {$nid = makenid($link);}

	$xname					= checkinput('xname');
	$xname_short			= checkinput('xname_short');
	$password				= checkinput('password');
	$system					= checkinput('system');
	$serverid				= checkinput('server_id');
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
	$back					= checkinput('back');

	if ($active) {$active = -1;} else {$active = 0;}
	if (stripos($data_url,'http://') == 0 ) {$data_url	= str_replace('http://','',$data_url);}

	$admin_tel = append_dialling_code($link,$country) . " " . $admin_tel;

	$strSql = "INSERT INTO exchanges (
		nid,
		xname,
		xname_short,
		password,
		system,
		server_id,
		administrator,
		admin_tel,
		admin_email,
		location,
		country,
		currency_name,
		currency_name_p,
		currency_symbol,
		currency_type,
		concurrency_name,
		concurrency_name_p,
		concurrency_symbol,
		request_format,
		response_format,
		conv_rate,
		data_url,
		trade_surplus_limit,
		trade_deficit_limit,
		time_offset,
		active,
		approve
		) VALUES (
		'$nid',
		'$xname',
		'$xname_short',
		'$password',
		'$system',
		'$serverid',
		'$administrator',
		'$admin_tel',
		'$admin_email',
		'$location',
		'$country',
		'$currency_name',
		'$currency_name_p',
		'$currency_symbol',
		'$currency_type',
		'$concurrency_name',
		'$concurrency_name_p',
		'$concurrency_symbol',
		'$request_format',
		'$response_format',
		'$conv_rate',
		'$data_url',
		'$trade_surplus_limit',
		'$trade_deficit_limit',
		'$time_offset',
		'-1',
		'0'
	)";

	//die($strSql);

	$result = mysqli_query($link, $strSql);

	if (!$result) {
		$message  = 'Invalid query: ' . mysqli_error() . "<br>";
		$message .= 'SQL: ' . $strSql;
		die($message);
	}

	if($back == "ces0000") {header("Location: http://www.ces.org.za/_super/adminlist.asp");}
	//die($strSql);

}

$strSql = "SELECT iso, country FROM countries ORDER BY country ASC";
$result = mysqli_query($link, $strSql);

if (!$result) {
	$message  = 'Invalid query: ' . mysqli_error() . "<br>";
	$message .= 'SQL: ' . $strSql;
	die($message);
}

$nid = makenid($link);
?>
<html>
<head>
<title>Create New Record</title>
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
		<td width="80%" style="height:100px; background-image:url(images/header.gif); vertical-align:middle"><span style="color:#FFF; font-size:18pt; font-weight:bold">Create New Record</span></td>
		<td width="10%" style="height:100px; background-image:url(images/header.gif); vertical-align:middle">&nbsp;</td>
	</tr>
</table>
<table width="80%" align="center" cellpadding="0" cellspacing="0" style="margin-bottom:0px">
	<tr>
		<td height="36" bgcolor="#000000"><?php require("_includes/dropmenu.inc")?></td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td><form method="post" action="addexchange.php">
				<table border="0" cellspacing="0" align="center" cellpadding="2">
					<tr bgcolor="#3F3F3F">
						<td colspan="2" align="center" bgcolor="#3F3F3F" class="textboldWhite">Exchange details</td>
					</tr>
					<tr bgcolor="#DDDDDD">
						<td align="right">Network ID:</td>
						<td><b><?php echo $nid;?></b></td>
					</tr>
					<tr bgcolor="#EEEEEE">
						<td align="right">Exchange name:</td>
						<td><input type="text" name="xname" id="xname" /></td>
					</tr>
					<tr bgcolor="#DDDDDD">
						<td align="right">Password:</td>
						<td><input type="text" name="password" id="password" /></td>
					</tr>
					<tr bgcolor="#EEEEEE">
						<td align="right">System (e.g. CES, Cyclos etc.):</td>
						<td><select name="system" id="system">
								<option value="">Select...</option>
								<option selected="selected">CES</option>
								<option>Community Forge</option>
								<option>Cyclos</option>
								<option>IntegralCES</option>
								<option>Timebank</option>
								<option>Other</option>
							</select></td>
					</tr>
					<tr bgcolor="#DDDDDD">
						<td align="right">Location:</td>
						<td><input type="text" name="location" id="location" /></td>
					</tr>
					<tr bgcolor="#EEEEEE">
						<td align="right">Country:</td>
						<td><select name="country">
								<option value="">Select Country...</option>
<?php
while ($row = mysqli_fetch_assoc($result)) {

	$iso		= $row['iso'];
	$country	= $row['country'];

	echo '<option value="' . $iso . '">' . $country . '</option>\n';

}
?>
						</select></td>
					</tr>
					<tr bgcolor="#DDDDDD">
						<td align="right">Currency name (sing):</td>
						<td><input type="text" name="currency_name" id="currency_name" /></td>
					</tr>
					<tr bgcolor="#DDDDDD">
						<td align="right">(plural):</td>
						<td><input type="text" name="currency_name_p" id="currency_name_p" /></td>
					</tr>
					<tr bgcolor="#EEEEEE">
						<td align="right">Con Currency name (sing):</td>
						<td><input type="text" name="concurrency_name" id="concurrency_name" /></td>
					</tr>
					<tr bgcolor="#EEEEEE">
						<td align="right">(plural):</td>
						<td><input type="text" name="concurrency_name_p" id="concurrency_name_p" /></td>
					</tr>
					<tr bgcolor="#DDDDDD">
						<td align="right">Currency symbol:</td>
						<td><input name="currency_symbol" type="text" id="currency_symbol" size="6" /></td>
					</tr>
					<tr bgcolor="#EEEEEE">
						<td align="right">Currency type:</td>
						<td><select name="currency_type" id="currency_type">
								<option value="">Select...</option>
								<option value="mc">Mutual Credit</option>
								<option value="tb">Timebank</option>
							</select></td>
					</tr>
					<tr bgcolor="#DDDDDD">
						<td align="right">Conversion rate:</td>
						<td><input name="conv_rate" type="text" id="conv_rate" size="4"></td>
					</tr>
					<tr bgcolor="#EEEEEE">
						<td align="right">URL for incoming transactions:</td>
						<td><input type="text" name="data_url" id="data_url" size="36" /></td>
					</tr>
					<tr bgcolor="#DDDDDD">
						<td align="right">Request format:</td>
						<td>
							<select name="request_format" id="request_format">
								<option value="get">HTTP Get</option>
								<option value="post">HTTP Post</option>
								<option value="csv">CSV</option>
								<option value="json">JSON</option>
								<option value="xml">XML</option>
							</select>
						</td>
					</tr>
					<tr bgcolor="#EEEEEE">
						<td align="right">Response format:</td>
						<td>
							<select name="response_format" id="response_format">
								<option value="get">HTTP Get</option>
								<option value="post">HTTP Post</option>
								<option value="csv">CSV</option>
								<option value="json">JSON</option>
								<option value="xml">XML</option>
							</select>
						</td>
					</tr>
					<!--<tr bgcolor="#EEEEEE">
						<td align="right">Trade surplus limit:</td>
						<td><input type="text" name="trade_surplus_limit" id="trade_surplus_limit" /></td>
					</tr>
					<tr bgcolor="#DDDDDD">
						<td align="right">Trade deficit limit:</td> Post
						<td><input type="text" name="trade_deficit_limit" id="trade_deficit_limit" /></td>
					</tr>-->
					<tr bgcolor="#EEEEEE">
						<td align="right">Time offset:</td>
						<td class="text"><select name="time_offset" class="text" id="time_offset">
								<option value="-12">GMT-12</option>
								<option value="-11">GMT-11</option>
								<option value="-10">GMT-10</option>
								<option value="-9">GMT-9</option>
								<option value="-8">GMT-8</option>
								<option value="-7">GMT-7</option>
								<option value="-6">GMT-6</option>
								<option value="-5">GMT-5</option>
								<option value="-4">GMT-4</option>
								<option value="-3">GMT-3</option>
								<option value="-2">GMT-2</option>
								<option value="-1">GMT-1</option>
								<option value="0" selected="selected">GMT</option>
								<option value="1">GMT+1</option>
								<option value="2">GMT+2</option>
								<option value="3">GMT+3</option>
								<option value="4">GMT+4</option>
								<option value="5">GMT+5</option>
								<option value="6">GMT+6</option>
								<option value="7">GMT+7</option>
								<option value="8">GMT+8</option>
								<option value="9">GMT+9</option>
								<option value="10">GMT+10</option>
								<option value="11">GMT+11</option>
								<option value="12">GMT+12</option>
							</select></td>
					</tr>
					<tr bgcolor="#DDDDDD">
						<td align="right">Active:</td>
						<td><input type="checkbox" name="active" id="active" value="1" checked="checked"/></td>
					</tr>
					<tr bgcolor="#3F3F3F">
						<td colspan="2" align="center" class="textboldWhite">Administrator details</td>
					</tr>
					<tr bgcolor="#EEEEEE">
						<td align="right">Name:</td>
						<td><input type="text" name="administrator" id="administrator" /></td>
					</tr>
					<tr bgcolor="#DDDDDD">
						<td align="right">Email:</td>
						<td><input type="text" name="admin_email" id="admin_email" /></td>
					</tr>
					<tr bgcolor="#EEEEEE">
						<td align="right">Telephone:</td>
						<td><input type="text" name="admin_tel" id="admin_tel" /></td>
					</tr>
					<tr bgcolor="#3F3F3F">
						<td align="right">&nbsp;</td>
						<td><input type="submit" name="button" id="button" value="Insert" /></td>
					</tr>
				</table>
				<input type="hidden" name="action" value="insert" />
				<input type="hidden" name="nid" value="<?php echo $nid?>" />
			</form></td>
	</tr>
	<tr>
		<td height="36" bgcolor="#000000">&nbsp;</td>
	</tr>
</table>
<?php require("_includes/menufooter.inc")?>
</body>
</html>
<?php
function makenid($link) {

	//Make a new network ID

	//First find last NID in DB

	$strSql = "SELECT nid FROM exchanges ORDER BY nid DESC";
	$result = mysqli_query($link, $strSql);

	if (!$result) {
		$message  = 'Invalid query: ' . mysqli_error() . "<br>";
		$message .= 'SQL: ' . $strSql;
		die($message);
	} else {
		$row		= mysqli_fetch_assoc($result);
		$lastnid	= $row['nid']; 	//Highest NID
	}

	$lastnid = str_replace('cen','',$lastnid);

	if ($lastnid == "") {
		die("Failed to create new Exchange ID");
	}

	$nid = intval($lastnid);
	$nid = $nid + 1;
	$nid = strval($nid);

	if (strlen($nid) == 1) {$nid = "cen000" . $nid;}
	if (strlen($nid) == 2) {$nid = "cen00" . $nid;}
	if (strlen($nid) == 3) {$nid = "cen0" . $nid;}
	if (strlen($nid) == 4) {$nid = "cen" . $nid;}

	return $nid;

}

function append_dialling_code($con,$country) {

	//Append telephone code from dialling codes table

	$strSql = "SELECT dialling_code FROM countries WHERE iso = '$country'";

	$result = mysqli_query($con, $strSql);

	if (!$result) {
		$message  	= 'Invalid query: ' . mysqli_error() . "<br>";
		$message   .= 'SQL: ' . $strSql;
		die($message);
	} else {
		$row		= mysqli_fetch_assoc($result);
		$dcode		= $row['dialling_code'];
	}

	return $dcode;

}
?>
