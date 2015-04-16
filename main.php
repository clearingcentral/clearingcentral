<?php
require("_includes/session.php");
?>
<html>
<head>
<title>Index Page</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles/cxn.css" rel="stylesheet" type="text/css">
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
</head>
<body style="background-color:#2F2F2F">
<div id="topstrap"><div class="header">Clearing Central Index Page</div></div>
<table width="80%" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td height="36" bgcolor="#000000"><?php require("_includes/dropmenu.inc")?></td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td><table width="100%" border="0" align="center" cellpadding="2" cellspacing="20">
				<tr>
					<td width="25%" align="center" nowrap class="textbold" title="Edit my record"><a href="account.php"><img src="images/myrecord.png" width="64" height="64" border="0"></a><br>
						My Record</td>
					<td width="25%" align="center" nowrap class="textbold"><a href="txlist.php" title="Transactions"><img src="images/tx.png" width="73" height="64" border="0"></a><br>
						Transactions</td>
					<td width="25%" align="center" nowrap class="textbold"><a href="main.php" title="Conversion rates"><img src="images/rates.png" width="64" height="64" border="0"></a><br>
						Rates</td>
					<td width="25%" align="center" nowrap class="textbold"><a href="main.php" title="Statistics and reports"><img src="images/stats.png" width="64" height="64" border="0"></a><br>
						Statistics</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td align="center" class="textbold"><a href="logout.php" title="Log out" target="_blank"><img src="images/logout.png" width="64" height="64" border="0"></a><br>
						Log Out</td>
				</tr>
		</table></td>
	</tr>
	<tr>
		<td height="36" bgcolor="#000000" class="textWhiteSmall" style="padding-left:20px">This web service is provided by the Community Exchange System (<a href="http://www.community-exchange.org" target="_blank">CES</a>)</td>
	</tr>
</table>
<?php require("_includes/menufooter.inc")?>
</body>
</html>
