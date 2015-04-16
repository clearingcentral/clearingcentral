<?php

require('session.inc');

if ($_POST['action'] == "insert") {

	$nid				= $_POST['nid'];
	$xname				= trim($_POST['xname']);
	$password			= trim($_POST['password']);
	$system				= trim($_POST['system']);
	$location			= trim($_POST['location']);
	$country			= trim($_POST['country']);
	$currency_name		= trim($_POST['currency_name']);
	$currency_symbol	= trim($_POST['currency_symbol']);
	$currency_type		= trim($_POST['currency_type']);
	$data_url			= trim($_POST['data_url']);
	$request_format		= trim($_POST['request_format']);
	$response_format	= trim($_POST['response_format']);
	$administrator		= trim($_POST['administrator']);
	$admin_email		= trim($_POST['admin_email']);
	$admin_tel			= trim($_POST['admin_tel']);

	if (stripos($url_out,'http://') == 0 ) {$url_out	= str_replace('http://','',$url_out);}
	if (stripos($url_back,'http://') == 0 ) {$url_back	= str_replace('http://','',$url_back);}

	$strSql = "INSERT INTO exchanges (nid, xname, password, system, administrator, admin_tel, admin_email, location, country, currency_name, currency_symbol, currency_type, request_format, response_format, data_url, approve) VALUES ('" . $nid . "','" . $xname . "','" . $password . "','" . $system . "','" . $administrator . "','" . $admin_tel . "','" . $admin_email . "','" . $location . "','" . $country . "','" . $currency_name . "','" . $currency_symbol . "','" . $currency_type . "','" . $request_format . "','" . $response_format . "','" . $data_url . "',-1)";

	die($strSql);

	$result = mysql_query($strSql);

	if (!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "<br>";
		$message .= 'SQL: ' . $strSql;
		die($message);
	}

	die("Done!");

}
$strSql = "SELECT iso, country FROM countries ORDER BY country ASC";
$result = mysql_query($strSql);

if (!$result) {
	$message  = 'Invalid query: ' . mysql_error() . "<br>";
	$message .= 'SQL: ' . $strSql;
	die($message);
} 

$newnid = makenid();
?>
<html>
<head>
<title>Administration Index</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
		<td width="80%" style="height:100px; background-image:url(images/header.gif); vertical-align:middle"><span style="color:#FFF; font-size:18pt; font-weight:bold">Approve Registration</span></td>
		<td width="10%" style="height:100px; background-image:url(images/header.gif); vertical-align:middle">&nbsp;</td>
	</tr>
</table>
<table width="80%" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td height="36" bgcolor="#000000"><?php require("dropmenu.inc")?></td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td><form id="form1" name="form1" method="post" action="../register.php">
				<table border="0" cellspacing="0" align="center" cellpadding="2">
					<tr bgcolor="#3F3F3F">
						<td colspan="2" align="center" bgcolor="#3F3F3F" class="textboldWhite">Exchange details</td>
					</tr>
					<tr bgcolor="#DDDDDD">
						<td align="right">Network ID:</td>
						<td><b><?php echo $newnid;?></b></td>
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
						<td><input type="text" name="system" id="system" /></td>
					</tr>
					<tr bgcolor="#DDDDDD">
						<td align="right">Location:</td>
						<td><input type="text" name="location" id="location" /></td>
					</tr>
					<tr bgcolor="#EEEEEE">
						<td align="right">Country:</td>
						<td><select name="country">
								<option value="" selected="selected">Select Country...</option>
								<?php
while ($row = mysql_fetch_assoc($result)) {

	$iso		= $row['iso'];
	$country	= $row['country'];

	echo '<option value="' . $iso . '">' . $country . '</option>\n';

}
?>
							</select></td>
					</tr>
					<tr bgcolor="#DDDDDD">
						<td align="right">Currency name:</td>
						<td><input type="text" name="currency_name" id="currency_name" /></td>
					</tr>
					<tr bgcolor="#EEEEEE">
						<td align="right">Currency symbol:</td>
						<td><input name="currency_symbol" type="text" id="currency_symbol" size="6" /></td>
					</tr>
					<tr bgcolor="#DDDDDD">
						<td align="right">Currency type:</td>
						<td><select name="currency_type" id="currency_type">
								<option value="">Select...</option>
								<option value="mc">Mutual Credit</option>
								<option value="tb">Timebank</option>
							</select></td>
					</tr>
					<tr bgcolor="#EEEEEE">
						<td align="right">URL for incoming transactions:</td>
						<td><input type="text" name="data_url" id="data_url" /></td>
					</tr>
					<tr bgcolor="#DDDDDD">
						<td align="right">Request format:</td>
						<td><select name="request_format" id="request_format">
							<option value="get">Get</option>
							<option value="post">Post</option>
								<option value="xml">XML</option>
							</select></td>
					</tr>
					<tr bgcolor="#EEEEEE">
						<td align="right">Response format:</td>
						<td><select name="response_format" id="response_format">
							<option value="post">URL format</option>
							<option value="xml">XML format</option>
						</select></td>
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
						<td><input type="submit" name="button" id="button" value="Submit" /></td>
					</tr>
				</table>
				<input type="hidden" name="action" value="insert" />
				<input type="hidden" name="nid" value="<?php echo $newnid?>" />
			</form></td>
	</tr>
	<tr>
		<td height="36" bgcolor="#000000" class="textWhiteSmall"><span style="color:#FFF; padding-left:10px">This web service is provided by the Community Exchange System (CES)</span></td>
	</tr>
</table>
<?php require("menufooter.inc")?>
</body>
</html>
<?php
function makenid() {

	//Make a new network ID

	//First find last NID in DB

	$strSql = "SELECT nid FROM exchanges ORDER BY nid DESC";
	$result = mysql_query($strSql);

	if (!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "<br>";
		$message .= 'SQL: ' . $strSql;
		die($message);
	} else {
		$row		= mysql_fetch_assoc($result);
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
?>
