<?php
require_once('_includes/constants.php');

// Connect to DB

$link = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD); 

if (!$link) {
   	die('Could not connect: ' . mysql_error());
}

mysql_select_db(DB_NAME, $link);

//$strSql	= "SELECT nid, xname, countries.country FROM exchanges, countries WHERE exchanges.country = countries.iso AND exchanges.active AND countries.active ORDER BY countries.country ASC, xname ASC";

$strSql	= "SELECT nid, xname FROM exchanges WHERE active ORDER BY country ASC, xname ASC";

$result = mysql_query($strSql,$link);

if (!$result) {
	$message  = 'Invalid query: ' . mysql_error() . "<br>";
	$message .= 'SQL: ' . $strSql;
	die($message);
}

$intCount = 1;

while ($row = mysql_fetch_assoc($result)) {

	//nid, xname, password, system, administrator, admin_tel, admin_email, location, country, currency_name, currency_symbol, currency_type, protocol_back, protocol_out, conv_rate, trade_surplus_limit, trade_deficit_limit, url_back, url_out, date_added, date_edited, time_offset, active, approve

	$nid			= $row['nid'];
	$xname			= $row['xname'];
	$country		= $row['countries.country'];

	$list .= "<option value=\"$nid\">$xname</option>\n"; 
	
	$intCount = $intCount + 1;
}

echo $list;

//strCtTemp = strCountries(1)

//echo "<optgroup label=\"" & strCtTemp & """>" & strCtTemp & "</option>\n";

/*For n = 1 To intGroups - 1
	strCd = strCodes (n)
	strGp = strGroups(n)
	strCt = strCountries(n)
	If strCt <> strCtTemp Then
		Response.Write "<optgroup label=""" & strCt & """>" & strCt & "</option>" & vbCrLf
	End If
	strCtTemp = strCt
	Response.Write "<option value=""wantlist.asp?xid=" & strCd & """"
	If strCd = strXID Then Response.Write " selected"
	If InStr(strGp,"#") = 0 Then strGpItem = Left(strGp,28) Else strGpItem = strGp
	Response.Write ">" & strGpItem & "</option>" & vbCrLf
Next*/
?>