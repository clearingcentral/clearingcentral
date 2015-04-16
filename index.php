<html>
<head>
<title>Community Exchange Network - Home</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles/cxn.css" rel="stylesheet" type="text/css">
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
</head>
<body>
<form method="post" action="logon.php">
	<div id="topstrap"><div class="header">Community Exchange Network</div></div>
	<table width="80%" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="2"><div id="topbar">&nbsp;</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td width="60" style="padding:25px"><table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
					<tr>
						<td colspan="2" class="black18Bold" style="padding-bottom:15px">Clearing Central</td>
						<td nowrap class="black18Bold" style="padding-bottom:15px">Log in</td>
					</tr>
					<tr>
						<td rowspan="3" valign="top" style="padding-right:25px"><img src="images/cxnlogo.jpg" width="100" height="100"></td>
						<td rowspan="3" valign="top" class="text">This web site serves as a central 'clearing house' allowing users of diverse exchange systems (CES exchanges, LETS groups, time banks etc.) to trade with each other, either directly from their own exchanges or manually through this site.
							<p>Through 'Clearing Central' remote trades can be settled. This can either be performed automatically through your exchange linking to the remote exchange via this site, or manually by logging into this site.</p></td>
						<td valign="top" nowrap class="text">Network ID:<br />
							<input name="nid" type="text" class="text" id="nid" size="10" maxlength="7" />
							</p></td>
					</tr>
					<tr>
						<td valign="top" class="text">Password:<br >
							<input name="password" type="password" class="text" id="password" size="10" />
							</span></td>
					</tr>
					<tr>
						<td height="300" valign="top"><input type="submit" name="button" id="button" value="Submit"></td>
					</tr>
				</table></td>
		</tr>
		<tr>
			<td><div id="footerline">This web service is provided by Community Exchange Systems (<a href="http://www.community-exchange.org" target="_blank">CES</a>)</div></td>
		</tr>
	</table>
</form>
<?php require("_includes/menufooter.inc")?>
</body>
</html>
