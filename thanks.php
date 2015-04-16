<?php

require_once('constants.inc');

session_start();

$link = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD); 

if (!$link) {
   	die('Could not connect: ' . mysql_error());
}

mysql_select_db('remotrades');

$stage = 1;

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
	$url_out			= trim($_POST['url_out']);
	$url_back			= trim($_POST['url_back']);
	$protocol_out		= trim($_POST['protocol_out']);
	$protocol_back		= trim($_POST['protocol_back']);
	$administrator		= trim($_POST['administrator']);
	$admin_email		= trim($_POST['admin_email']);
	$admin_tel			= trim($_POST['admin_tel']);

	if (stristr($url_back, 'http://') === FALSE) { $url_back = "http://" . $url_back; }
	if (stristr($url_out, 'http://') === FALSE) { $url_out = "http://" . $url_out; }
	//if (stripos($url_out,'http://') == 0 ) {$url_out	= str_replace('http://','',$url_out);}
	//if (stripos($url_back,'http://') == 0 ) {$url_back	= str_replace('http://','',$url_back);}

	mysql_select_db('exchanges');

	$strSql = "INSERT INTO exchanges (nid, xname, password, system, administrator, admin_tel, admin_email, location, country, currency_name, currency_symbol, currency_type, protocol_back, protocol_out, url_back, url_out, approve) VALUES ('" . $nid . "','" . $xname . "','" . $password . "','" . $system . "','" . $administrator . "','" . $admin_tel . "','" . $admin_email . "','" . $location . "','" . $country . "','" . $currency_name . "','" . $currency_symbol . "','" . $currency_type . "','" . $protocol_back . "','" . $protocol_out . "','" . $url_back . "','" . $url_out . "',-1)";

	//die($strSql);

	$result = mysql_query($strSql);

	if (!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "<br>";
		$message .= 'SQL: ' . $strSql;
		die($message);
	}

	$stage = 2;

}
$strSql = "SELECT iso, country FROM countries ORDER BY country ASC";
$result = mysql_query($strSql);

if (!$result) {
	$message  = 'Invalid query: ' . mysql_error() . "<br>";
	$message .= 'SQL: ' . $strSql;
	die($message);
} 

?>
<html>
<head>
<title>Community Exchange Network - Register</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles/cxn.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	background-color:#2F2F2F;
	font-family:Verdana, Geneva, sans-serif
}
.white18Bold {
	color:#FFF;
	font-size:18pt;
	font-weight:bold
}
.black18Bold {
	color:#000;
	font-size:18pt;
	font-weight:bold
}
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
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
</head>
<body>
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td width="10%" style="height:100px; background-image:url(images/header.gif); vertical-align:middle">&nbsp;</td>
			<td width="80%" style="height:100px; background-image:url(images/header.gif); vertical-align:middle"><span style="color:#FFF; font-size:18pt; font-weight:bold">Community Exchange Network</span></td>
			<td width="10%" style="height:100px; background-image:url(images/header.gif); vertical-align:middle">&nbsp;</td>
		</tr>
	</table>
<?php if ($stage == 1) { $newnid = makenid(); ?>
	<form method="post" action="register.php">
	<table width="80%" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td height="36" colspan="2" align="center" bgcolor="#000000" class="textwhite"><div style="float:left; padding:6px; margin-left:10px; border-right:1px solid #666"><a href="index.php" class="textWhite">Home</a>&nbsp;&nbsp;</div></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td width="60" align="center" style="padding:25px"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" valign="top" class="black18Bold" style="padding-bottom:15px">&nbsp;</td>
					<td align="center" valign="top" class="black18Bold" style="padding-bottom:15px"><span class="black18Bold" style="padding-bottom:15px">Register your Exchange</span></td>
					</tr>
				<tr>
					<td width="20%" valign="top"><p class="textbold" style=" text-align: left; ">Register your exchange</p>
						<p class="text" style=" text-align: left; ">Register your exchange group with the <span style="font-weight: bold;">Community Exchange Network</span> so that your users can trade with users of other exchange groups around the world. </p></td>
					<td><table border="0" cellspacing="0" align="center" cellpadding="2">
						<tr bgcolor="#3F3F3F">
							<td colspan="2" align="center" bgcolor="#3F3F3F" class="textboldWhite">Exchange details</td>
						</tr>
						<tr bgcolor="#DDDDDD">
							<td align="right" class="text">Network ID:</td>
							<td class="text"><b><?php echo $newnid;?></b></td>
						</tr>
						<tr bgcolor="#EEEEEE">
							<td align="right" class="text">Exchange name:</td>
							<td><input name="xname" type="text" class="text" id="xname" size="36" /></td>
						</tr>
						<tr bgcolor="#DDDDDD">
							<td align="right" class="text">Password:</td>
							<td><input name="password" type="password" class="text" id="password" /></td>
						</tr>
						<tr bgcolor="#EEEEEE">
							<td align="right" class="text">System (e.g. CES, Cyclos etc.):</td>
							<td><input name="system" type="text" class="text" id="system" /></td>
						</tr>
						<tr bgcolor="#DDDDDD">
							<td align="right" class="text">Location:</td>
							<td><input name="location" type="text" class="text" id="location" /></td>
						</tr>
						<tr bgcolor="#EEEEEE">
							<td align="right" class="text">Country:</td>
							<td><select name="country" class="text">
								<option value="" selected="selected">Select Country...</option>
	<?php
	while ($row = mysql_fetch_assoc($result)) {

		$iso		= $row['iso'];
		$country	= $row['country'];

		echo '<option value="' . $iso . '">' . $country . '</option>\n';

	} ?>
							</select></td>
						</tr>
						<tr bgcolor="#DDDDDD">
							<td align="right" class="text">Currency name:</td>
							<td><input name="currency_name" type="text" class="text" id="currency_name" /></td>
						</tr>
						<tr bgcolor="#EEEEEE">
							<td align="right" class="text">Currency symbol:</td>
							<td><input name="currency_symbol" type="text" class="text" id="currency_symbol" size="6" /></td>
						</tr>
						<tr bgcolor="#DDDDDD">
							<td align="right" class="text">Currency type:</td>
							<td><select name="currency_type" class="text" id="currency_type">
								<option value="">Select...</option>
								<option value="mc">Mutual Credit</option>
								<option value="tb">Timebank</option>
							</select></td>
						</tr>
						<tr bgcolor="#EEEEEE">
							<td align="right" class="text">URL for incoming requests:</td>
							<td><input name="url_out" type="text" class="text" id="url_out" size="36" /></td>
						</tr>
						<tr bgcolor="#DDDDDD">
							<td align="right" class="text">Protocol for incoming requests:</td>
							<td><select name="protocol_out" class="text" id="protocol_out">
								<option value="get">Get</option>
								<option value="post" selected="selected">Post</option>
							</select></td>
						</tr>
						<tr bgcolor="#EEEEEE">
							<td align="right" class="text">URL for incoming responses:</td>
							<td><input name="url_back" type="text" class="text" id="url_back" size="36" /></td>
						</tr>
						<tr bgcolor="#DDDDDD">
							<td align="right" class="text">Protocol for incoming responses:</td>
							<td><select name="protocol_back" class="text" id="protocol_back">
								<option value="get">Get</option>
								<option value="post" selected="selected">Post</option>
							</select></td>
						</tr>
						<tr bgcolor="#3F3F3F">
							<td colspan="2" align="center" class="textboldWhite">Administrator details</td>
						</tr>
						<tr bgcolor="#EEEEEE">
							<td align="right" class="text">Name:</td>
							<td><input name="administrator" type="text" class="text" id="administrator" /></td>
						</tr>
						<tr bgcolor="#DDDDDD">
							<td align="right" class="text">Email:</td>
							<td><input name="admin_email" type="text" class="text" id="admin_email" /></td>
						</tr>
						<tr bgcolor="#EEEEEE">
							<td align="right" class="text">Telephone:</td>
							<td><input name="admin_tel" type="text" class="text" id="admin_tel" /></td>
						</tr>
						<tr bgcolor="#3F3F3F">
							<td align="right">&nbsp;</td>
							<td><input name="button" type="submit" class="text" id="button" value="Submit" /></td>
						</tr>
					</table></td>
				</tr>
			</table>
			<input type="hidden" name="action" value="insert">
			<input type="hidden" name="nid" value="<?php echo $newnid?>">
			</form>
<?php } if ($stage == 2) { ?>
			<table width="300" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td style="border: 10px solid #C6ECB2"><p class="textbold">Thank you for your registration!</p>
						<p class="text">Please remember your Community Exchange Network ID: <b><?php echo $nid;?></b></p>
						<p class="text">With the password you supplied, you can log in at <a href="index.php">www.cxn.org.za</a> to edit your details and perform other actions</p>
					</td>
				</tr>
			</table>
<?php } ?>
			</td>
		</tr>
		<tr>
			<td height="36" bgcolor="#000000" class="textWhiteSmall" style="padding-left:20px">This web service is provided by Community Exchange Systems (<a href="http://www.community-exchange.org" target="_blank">CES</a>)</td>
		</tr>
	</table>
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
