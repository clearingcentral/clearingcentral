<?php

require_once('../constants.inc');

session_start();

$link = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD); 

if (!$link) {
   	die('Could not connect: ' . mysql_error());
}

mysql_select_db('remotrades');

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

	if (stripos($url_out,'http://') == 0 ) {$url_out	= str_replace('http://','',$url_out);}
	if (stripos($url_back,'http://') == 0 ) {$url_back	= str_replace('http://','',$url_back);}

	mysql_select_db('exchanges');

	$strSql = "INSERT INTO exchanges (nid, xname, password, system, administrator, admin_tel, admin_email, location, country, currency_name, currency_symbol, currency_type, protocol_back, protocol_out, url_back, url_out, approve) VALUES ('" . $nid . "','" . $xname . "','" . $password . "','" . $system . "','" . $administrator . "','" . $admin_tel . "','" . $admin_email . "','" . $location . "','" . $country . "','" . $currency_name . "','" . $currency_symbol . "','" . $currency_type . "','" . $protocol_back . "','" . $protocol_out . "','" . $url_back . "','" . $url_out . "',-1)";

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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Register - Community Exchange Network</title>
<script type='text/javascript'>var STATIC_BASE = 'http://www.dragndropbuilder.com/';</script>
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/prototype/1.6.1/prototype.js' ></script>
<script type='text/javascript' src='http://www.dragndropbuilder.com/weebly/images/common/effects-1.8.2.js' ></script>
<script type='text/javascript' src='http://www.dragndropbuilder.com/weebly/images/common/weebly.js' ></script>
<script type='text/javascript' src='http://www.dragndropbuilder.com/weebly/images/common/lightbox202.js?6' ></script>
<script type='text/javascript' src='http://www.dragndropbuilder.com/weebly/libraries/flyout_menus.js?6'></script>
<script type='text/javascript'>function initFlyouts(){initPublishedFlyoutMenus([{"id":"329911791728099","title":"Home","url":"index.html"},{"id":"86509434","title":"Register","url":"register.html"},{"id":"469644241484706873","title":"Edit\/Update","url":"editupdate.html"}],'86509434','<li class=\'weebly-nav-more\'><a href=\"#\">more...</a></li>','active')}if (Prototype.Browser.IE) window.onload=initFlyouts; else document.observe('dom:loaded', initFlyouts);</script>
<link rel='stylesheet' href='http://www.dragndropbuilder.com/weebly/images/common/common.css?4' type='text/css' />
<link rel='stylesheet' type='text/css' href='/files/main_style.css' title='weebly-theme-css' />
<link rel='stylesheet' type='text/css' href='/styles/cxn.css' />
<style type='text/css'>
#weebly_page_content_container div.paragraph, #weebly_page_content_container p, #weebly_page_content_container .product-description, .blog-sidebar div.paragraph, .blog-sidebar p {
}
#weebly_page_content_container h2, #weebly_page_content_container .product-title, .blog-sidebar h2 {
}
#weebly_site_title {
}
</style>
</head>
<body class="weeblypage-register" >
<!-- Header -->
<div id="header" class="box">
	<div class="main">
		<!-- Your logo -->
		<h1 id="logo"><span id="weebly_site_title">Community Exchange Network</span></h1>
		<hr class="noscreen" />
	</div>
	<!-- /main -->
</div>
<!-- /header -->
<div class="main bg box">
	<!-- Navigation -->
	<div id="nav" class="box">
		<ul>
			<li id='pg329911791728099'><a href="/index.php">Home</a></li>
		</ul>
		<hr class="noscreen" />
	</div>
	<!-- /nav -->
	<div class="box">
		<div id="content">
			<div id='weebly_page_content_container'>
				<!-- WEEBLY_START_CONTENT -->
				<div >
					<div id="740891118855784628-parent" class="weebly-splitpane-2" style="width: 100%;">
						<div id="740891118855784628-lhs" class="column" style="width: 32.297%; float: left; overflow: visible; margin: 0; padding: 0;">
							<div style="padding-right: 5px;" class="columnlistp">
								<h2  style=" text-align: left; ">Register your exchange</h2>
								<div  class="paragraph" style=" text-align: left; display: block; ">Register your exchange group with the <span style="font-weight: bold;">Community Exchange Network</span> so that your users can trade with users of other exchange groups around the world. <br />
								</div>
							</div>
						</div>
						<div id="740891118855784628-rhs" class="column" style="width: 66.703%; left: 66.703%; float: left; overflow: visible; margin: 0; padding: 0;">
							<div style="padding-left: 5px;" class="columnlistp" align="center">
								<form id="form1" name="form1" method="post" action="../register.php">
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
											<td align="right">URL for incoming requests:</td>
											<td><input type="text" name="url_out" id="url_out" /></td>
										</tr>
										<tr bgcolor="#DDDDDD">
											<td align="right">Protocol for incoming requests:</td>
											<td><select name="protocol_out" id="protocol_out">
													<option value="get">Get</option>
													<option value="post" selected="selected">Post</option>
												</select></td>
										</tr>
										<tr bgcolor="#EEEEEE">
											<td align="right">URL for incoming responses:</td>
											<td><input type="text" name="url_back" id="url_back" /></td>
										</tr>
										<tr bgcolor="#DDDDDD">
											<td align="right">Protocol for incoming responses:</td>
											<td><select name="protocol_back" id="protocol_back">
													<option value="get">Get</option>
													<option value="post" selected="selected">Post</option>
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
									<br class="clearfloat" />
								</form>
								<!-- end #mainContent -->
							</div>
						</div>
					</div>
					<div style="clear: both; visibility: hidden; height: 0px; overflow: hidden;"></div>
				</div>
			</div>
		</div>
		<!-- /content -->
		<hr class="noscreen" />
	</div>
	<!-- /box -->
	<hr class="noscreen" />
	<!-- Footer -->
	<div id="footer" class="box">
		<p><span id='weeblyFooter'>This web service is provided by Community Exchange Systems (<a href='http://www.community-exchange.org/' target='_blank'>CES</a>)</span></p>
	</div>
	<!-- /footer -->
</div>
<!-- /main -->
<!--#include virtual="/ajax/footerCode.php" -->
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
