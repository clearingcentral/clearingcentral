<?php
$strRemoteURL = "http://www.ces.org.za/txrengine.asp";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Community Exchange Network</title>
<style type="text/css">
<!--
body {
	font: 100% Verdana, Arial, Helvetica, sans-serif;
	background-color: #F2FBEE;
	margin: 0; /* it's good practice to zero the margin and padding of the body element to account for differing browser defaults */
	padding: 0;
	text-align: center; /* this centers the container in IE 5* browsers. The text is then set to the left aligned default in the #container selector */
	color: #000000;
}
.thrColLiqHdr #container {
	width: 80%;  /* this will create a container 80% of the browser width */
	background: #FFFFFF;
	margin: 0 auto; /* the auto margins (in conjunction with a width) center the page */
	border: 10px solid #FFFFFF;
	text-align: left; /* this overrides the text-align: center on the body element. */
}
.thrColLiqHdr #header {
	background: #006600;
	padding: 0 10px;  /* this padding matches the left alignment of the elements in the divs that appear beneath it. If an image is used in the #header instead of text, you may want to remove the padding. */
	text-align:center;
	color:#FFF;
}
.thrColLiqHdr #header h1 {
	margin: 0; /* zeroing the margin of the last element in the #header div will avoid margin collapse - an unexplainable space between divs. If the div has a border around it, this is not necessary as that also avoids the margin collapse */
	padding: 10px 0; /* using padding instead of margin will allow you to keep the element away from the edges of the div */
}
/* Tips for sidebars:
1. Since we are working in percentages, it's best not to use side padding on the sidebars. It will be added to the width for standards compliant browsers creating an unknown actual width. 
2. Space between the side of the div and the elements within it can be created by placing a left and right margin on those elements as seen in the ".thrColLiqHdr #sidebar1 p" rule.
3. Since Explorer calculates widths after the parent element is rendered, you may occasionally run into unexplained bugs with percentage-based columns. If you need more predictable results, you may choose to change to pixel sized columns.
*/
.thrColLiqHdr #sidebar1 {
	float: left; /* this element must precede in the source order any element you would like it be positioned next to */
	width: 22%; /* since this element is floated, a width must be given */
	background: #C6ECB2; /* the background color will be displayed for the length of the content in the column, but no further */
	padding: 15px 0; /* top and bottom padding create visual space within this div  */
}
.thrColLiqHdr #sidebar2 {
	float: right; /* this element must precede in the source order any element you would like it be positioned next to */
	width: 23%; /* since this element is floated, a width must be given */
	background: #C6ECB2; /* the background color will be displayed for the length of the content in the column, but no further */
	padding: 15px 0; /* top and bottom padding create visual space within this div */
}
.thrColLiqHdr #sidebar1 p, .thrColLiqHdr #sidebar1 h3, .thrColLiqHdr #sidebar2 p, .thrColLiqHdr #sidebar2 h3 {
	margin-left: 10px; /* the left and right margin should be given to every element that will be placed in the side columns */
	margin-right: 10px;
}
/* Tips for mainContent:
1. the space between the mainContent and sidebars is created with the left and right margins on the mainContent div.
2. to avoid float drop at a supported minimum 800 x 600 resolution, elements within the mainContent div should be 300px or smaller (this includes images).
3. in the Internet Explorer Conditional Comment below, the zoom property is used to give the mainContent "hasLayout." This avoids several IE-specific bugs.
*/

.thrColLiqHdr #sidebar1 p {
	font-size: 8pt;
}
.thrColLiqHdr #mainContent {
	margin: 0 24% 0 23.5%; /* the right and left margins on this div element creates the two outer columns on the sides of the page. No matter how much content the sidebar divs contain, the column space will remain. You can remove this margin if you want the #mainContent div's text to fill the sidebar spaces when the content in each sidebar ends. */
}
.thrColLiqHdr #mainContent p {
	font-size: 10pt;
}
.thrColLiqHdr #footer {
	padding: 0 10px; /* this padding matches the left alignment of the elements in the divs that appear above it. */
	background:#006600;
	text-align: center;
	font-size: 8pt;
	color: #FFF
}
.thrColLiqHdr #footer p {
	margin: 0; /* zeroing the margins of the first element in the footer will avoid the possibility of margin collapse - a space between divs */
	padding: 10px 0; /* padding on this element will create space, just as the the margin would have, without the margin collapse issue */
}
/* Miscellaneous classes for reuse */
.fltrt { /* this class can be used to float an element right in your page. The floated element must precede the element it should be next to on the page. */
	float: right;
	margin-left: 8px;
}
.fltlft { /* this class can be used to float an element left in your page The floated element must precede the element it should be next to on the page. */
	float: left;
	margin-right: 8px;
}
.clearfloat { /* this class should be placed on a div or break element and should be the final element before the close of a container that should fully contain its child floats */
	clear:both;
	height:0;
	font-size: 1px;
	line-height: 0px;
}
-->
</style>
<!--[if IE]>
<style type="text/css"> 
/* place css fixes for all versions of IE in this conditional comment */
.thrColLiqHdr #sidebar2, .thrColLiqHdr #sidebar1 { padding-top: 30px; }
.thrColLiqHdr #mainContent { zoom: 1; padding-top: 15px; }
/* the above proprietary zoom property gives IE the hasLayout it needs to avoid several bugs */
</style>
<![endif]-->
</head>
<body class="thrColLiqHdr">
<div id="container">
	<div id="header">
		<h1>Community Exchange Network</h1>
		<!-- end #header -->
	</div>
	<div id="sidebar1" style="height:350px">
		<h3>Trade</h3>
		<p>Enter a transaction with a user in another exchange in your system or in another system.</p>
		<p><a href="index.php">Home</a></p>
			<!-- end #sidebar1 -->
	</div>
	<div id="sidebar2" style="height:350px"></div>
	<div id="mainContent">
		<h1 align="center">Enter a trade</h1>
		<form id="form1" name="form1" method="post" action="<?php echo $strRemoteURL; ?>">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td align="right">Your exchange ID:</td>
					<td><input type="text" name="xid" id="xid" /></td>
				</tr>
				<tr>
					<td align="right">Your account number:</td>
					<td><input type="text" name="seller" id="seller" /></td>
				</tr>
				<tr>
					<td align="right">Your password:</td>
					<td><input type="password" name="password" id="password" /></td>
				</tr>
				<tr>
					<td align="right">Buyer's exchange ID:</td>
					<td><input type="text" name="rxid" id="rxid" /></td>
				</tr>
				<tr>
					<td align="right">Buyer's account number:</td>
					<td><input type="text" name="buyer" id="buyer" /></td>
				</tr>
				<tr>
					<td align="right">Description:</td>
					<td><input name="descr" id="descr" /></td>
				</tr>
				<tr>
					<td align="right">Amount:</td>
					<td><input type="text" name="amount" id="amount" /></td>
				</tr>
				<tr bgcolor="#C6ECB2">
					<td align="right">&nbsp;</td>
					<td><input type="submit" name="button" id="button" value="Submit" /></td>
				</tr>
			</table>
			<!-- end #mainContent -->
			<input type="hidden" name="action" value="trade" />
			<br class="clearfloat" />
		</form>
	</div>
	<div id="footer">
		<p>A service provided by Community Exchange Systems (CES)</p>
		<!-- end #footer -->
	</div>
	<!-- end #container -->
</div>
</body>
</html>
