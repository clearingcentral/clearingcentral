<?php
require("_includes/session.php");
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
		<td width="80%" style="height:100px; background-image:url(images/header.gif); vertical-align:middle"><span style="color:#FFF; font-size:18pt; font-weight:bold">Administration Index</span></td>
		<td width="10%" style="height:100px; background-image:url(images/header.gif); vertical-align:middle">&nbsp;</td>
	</tr>
</table>
<table width="80%" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td height="36" bgcolor="#000000"><?php require("_includes/dropmenu.inc")?></td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td><table width="100%" border="0" align="center" cellpadding="2" cellspacing="20">
				<tr>
					<td width="25%" align="center" nowrap class="textbold" title="List active exchanges"><a href="listexchanges.php"><img src="images/exchanges.png" width="64" height="64" border="0"></a><br>
						Exchanges</td>
					<td width="25%" align="center" nowrap class="textbold"><a href="txlist.php" title="Enter transactions"><img src="images/tx.png" width="73" height="64" border="0"></a><br>
						Transactions</td>
					<td width="25%" align="center" nowrap class="textbold"><a href="ratelist.php" title="List/edit conversion rates"><img src="images/rates.png" width="64" height="64" border="0"></a><br>
						Rates</td>
					<td width="25%" align="center" nowrap class="textbold"><a href="statsindex.php" title="Statistics and reports"><img src="images/stats.png" width="64" height="64" border="0"></a><br>
						Statistics</td>
				</tr>
				<tr>
					<td align="center" nowrap class="textbold"><p><br>
						</p></td>
					<td align="center" title="><p class="textbold"><br>
						</p></td>
					<td align="center" class="textbold"><br></td>
					<td align="center" class="textbold"><a href="logout.php" title="Log out" target="_blank"><img src="images/logout.png" width="64" height="64" border="0"></a><br>
						Log Out</td>
				</tr>
		</table></td>
	</tr>
	<tr>
		<td height="36" bgcolor="#000000" class="textWhiteSmall">&nbsp;</td>
	</tr>
</table>
<?php require("_includes/menufooter.inc")?>
</body>
</html>
