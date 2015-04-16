<?php

require_once('_includes/constants.php');

// Connect to DB

$link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (!$link) {
   	die('Could not connect: ' . mysqli_error($link));
}

$intCount	= 1;
$strList	= "";
$strSort	= $_REQUEST['sort'];
$strSearch	= $_REQUEST['searchtext'];
$strSql		= "SELECT nid, xname, location, country FROM exchanges WHERE active";

if (!empty($strSearch)) {
	$strSql .= " AND location LIKE '%" . $strSearch . "%' OR xid LIKE '%" . $strSearch . "%' OR xname LIKE '%" . $strSearch . "%' OR nid LIKE '%" . $strSearch . "%' OR country LIKE '%" . $strSearch . "%'";
}

//echo $strSql;

switch ($strSort) {

    case "nid":
    	$strSql .= " ORDER BY nid ASC";
    	break;
	case "name":
    	$strSql .= " ORDER BY xname ASC";
		break;
    case "co":
    	$strSql .= " ORDER BY country ASC, xname ASC";
    	break;
    case "loc":
    	$strSql .= " ORDER BY location ASC, country ASC";
    	break;
    default:
	    $strSql .= " ORDER BY xname ASC";
}

$result = mysqli_query($link,$strSql);

if (!$result) {
	$message  = 'Invalid query: ' . mysqli_error($link) . "<br>";
	$message .= 'SQL: ' . $strSql;
	die($message);
}

$strHead  = "<table border=\"0\" align=\"center\" cellpadding=\"3\" cellspacing=\"1\">\n";
$strHead .=	"<tr id=\"listheader\">\n";
$strHead .=	"<td align=\"center\">#</td>\n";
$strHead .=	"<td title=\"Network ID\"><a href=\"showexchanges.php?sort=nid\">NID</a></td>\n";
$strHead .=	"<td><a href=\"showexchanges.php?sort=name\">Exchange Name</a></td>\n";
$strHead .=	"<td align=\"center\" title=\"Country\"><a href=\"showexchanges.php?sort=co\">Co</a></td>\n";
$strHead .=	"<td><a href=\"showexchanges.php?sort=loc\">Location</a></td>\n";
$strHead .=	"</tr>\n";

while ($row = mysqli_fetch_assoc($result)) {

	$nid		= $row['nid'];
	$xname		= $row['xname'];
	$country	= $row['country'];
	$location	= $row['location'];

	$strTitle	= "";
	/*$lenName	= strlen($xname);
	$lenLoc		= strlen($location);

	if ($lenName > 30) {
		$strTitle	= $xname;
		if(stristr($strTitle, '&#') === FALSE) {
			$xname = substr($xname,0,30) . "...";
		}
	}

	if ($lenLoc > 30) {
		$locTitle	= $location;
		$location	= substr($location,0,30) . "...";
	}*/

	if ($intCount % 2) { $strBgColor = "#DDDDDD"; } else { $strBgColor = "#EEEEEE"; }

		$strList .=	"<tr valign=\"top\" bgcolor=\"" . $strBgColor. "\" class=\"textsmall\">\n";
		$strList .=	"<td align=\"center\">" . $intCount . "</td>\n";
		$strList .=	"<td>" . $nid . "</td>\n";
		$strList .=	"<td title=\"" . $strTitle . "\">" . $xname . "</td>\n";
		$strList .=	"<td align=\"center\">" . $country . "</td>\n";
		$strList .=	"<td title=\"" . $locTitle . "\">" . $location . "</td>\n";
		$strList .=	"</tr>\n";

	$intCount += 1;
}

if ($intCount == 1) {

	$strList .=	"<tr valign=\"top\" bgcolor=\"#DDDDDD\" class=\"textsmall\">\n";
	$strList .=	"<td align=\"center\">0</td>\n";
	$strList .=	"<td colspan=\"5\">No records found</td>\n";
	$strList .=	"</tr>\n";

}

$strList .=	"</table>";
$strList  = $strHead . $strList;

die($strList);
?>
