<?php
/*This script transfers transaction data sent from seller to the buyer's remote exchange, and sends back a result code and required data to complete the seller's record

*********************

Transaction object:

txid			Transaction ID
buyer_nid		Network ID of buyer's exchange (e.g. CEN1234)
buyer_xname		Name of buyer's exchange (e.g. Cape Town Talent Exchange)
buyer_country	Country where buyer's exchange is registered
buyer_id		Buyer's ID or account number
buyer_name		Buyer's name
buyer_email		Buyer's email address
seller_nid		Network ID of seller's exchange (e.g. cen1234)
seller_xname	Name of seller's exchange (e.g. Cape Town Talent Exchange)
seller_country	Country where seller's exchange is registered
seller_id		Seller's ID or account number
seller_name		Seller's name
seller_email	Seller's email
description		Description of trade (e.g. Books, Web design)
amount			Amount (e.g. 10.00, 15, 123.45)
nolevy			Suppresses levy (CES only)
response		Response/progress code

*********************

Response codes:

0 = failure/default state
1 = success
2 = user (buyer) does not exist (unknown account number)
3 = exchange not recorded on CC (NID not recognised)
4 = transaction denied ("no funds", over limit, account locked, exchange over deficit limit etc.)
5 = faulty data
6 = repeat transaction and so rejected by CC
7 = URL error
8 = Conversion rate not set
9 = Server error (e.g. can't access db)
10 = Password incorrect
11 = IP of incoming server not in CC DB
12 = No TXID provided (update/delete only)
13 = TXID doesn't exist (update/delete only)
14 = Unable to connect to remote server

*********************

Test URL

http://www.clearingcentral.net/txinput.php?txid=12345&password=OpelK7hB5&buyer_nid=cen0008&buyer_id=mcgr0014&seller_nid=cen0920&seller_id=test0001&seller_name=Esteve+Badia&seller_email=badia.orive%40gmail.com&description=Testing&amount=20

http://www.clearingcentral.net/txinput.php?password=OpelK7hB5&buyer_nid=cen0746&buyer_id=test0001&seller_nid=cen0920&seller_id=HORA1000&seller_xname=A%20bona%20hora%20%28Ecoxarxa%20del%20Bages%29&seller_name=Riemann&seller_email=badia.orive%2Briemann%40gmail.com&description=Test%20interexchange%20transaction&amount=0.0100

*********************

Testing

Look for this line (approx line 350) and uncomment to see responses from buyer's server:

//die("Txinput: " . $postdata . "<br>"); //Uncomment to see responses from txrengine

*********************/

require('_includes/constants.php');

session_start();

$seller_ip		= $_SERVER['REMOTE_ADDR'];				//IP of seller's server

//if ($seller_ip == "223.252.32.216") {$seller_ip = "223.252.32.210";} //Stupid Oz server error!

//die($seller_ip);

//Transaction data received from seller's server

$txid			= checkinput('txid'); 					//Transaction ID
$password		= checkinput('password');				//Seller exchange password
$description	= checkinput('description');
$seller_amount	= checkinput('amount');
$nolevy			= checkinput('no_levy');

//Connect to db

$link = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD);

if (!$link) {
	exit("response=9&txid=" . $txid);
}

mysql_select_db(DB_NAME);

//If this $txid is already in db then this is an edit/delete or a repeat transaction

$strSql = "SELECT buyer_nid, seller_nid, description, seller_amount FROM transactions WHERE txid = '$txid'";

if (mysql_num_rows(mysql_query($strSql))) { //This is an edit/delete or repeat transaction

	$result = mysql_query($strSql);

	if (!$result) {
		exit("response=9&txid=" . $txid);
	} else {

		$row			= mysql_fetch_assoc($result);
		$buyer_nid		= $row['buyer_nid'];
		$seller_nid		= $row['seller_nid'];
		$dbDescr		= $row['description'];
		$dbAmount		= $row['seller_amount'];

	}

	$edit = true;

	if (($dbDescr == $description && $dbAmount == $seller_amount) && ($description != "" && $seller_amount != 0)) { //Repeat
		exit("response=6&txid=" . $txid);
	} else {
		$response = 0;
		$action = "edit";
		if ($description == '' && $seller_amount = 0) {
			$action = "delete";
		}
	}

} else { //this is a new transaction

	//The following only required for new transactions

	$buyer_id		= checkinput('buyer_id');				//Buyer's account #
	$buyer_nid		= strtolower(checkinput('buyer_nid'));	//Buyer's network ID
	$seller_id		= checkinput('seller_id');				//Seller's account #
	$seller_nid		= strtolower(checkinput('seller_nid'));	//Seller's network ID
	$seller_name	= checkinput('seller_name');				//Seller's name
	$seller_email	= strtolower(checkinput('seller_email'));//Seller's email address
	$response		= 0;
	$action			= "new";

	/*die(
	$txid . "<br>" .
	$buyer_id . "<br>" .
	$buyer_nid . "<br>" .
	$seller_id . "<br>" .
	$seller_nid . "<br>" .
	$seller_name . "<br>" .
	$seller_email . "<br>" .
	$description . "<br>" .
	$seller_amount . "<br>" .
	$response);*/

	if (empty($txid)) {$txid = maketxid($buyer_nid, $seller_nid);} //Create a $txid

	//die($txid);

	$edit = false;

	//See if requested remote exchange exists. If not report error 3

	if (!mysql_num_rows(mysql_query("SELECT nid FROM exchanges WHERE nid = '$buyer_nid'"))) {
		exit("response=3&txid=" . $txid . "&buyer_nid=" . $buyer_nid); //No exchange registered with given network ID
	}

}

//Get details of seller's exchange to send to buyer's server

$strSql = "SELECT xname, password, country, conv_rate, server_ip FROM exchanges WHERE nid = '" . $seller_nid . "'";
$result = mysql_query($strSql);

if (!$result) {

	exit("response=9&txid=" . $txid);

} else {

	$row				= mysql_fetch_assoc($result);
	$spassword			= $row['password']; //Seller's exchange password
	$seller_xname		= $row['xname']; 	//Seller's exchange name
	$seller_country		= $row['country'];	//Seller's country
	$seller_conv_rate	= $row['conv_rate'];//Seller's conversion rate (hourly rate)
	$server_ip			= $row['server_ip'];//Seller's server IP

}

//Check passwords

if (empty($spassword) || empty($password)) { //Abort if any passwords missing
	exit("response=10&txid=" . $txid);
}

if ($spassword != $password) { //Abort if passwords do not match
	exit("response=10&txid=" . $txid);
}

//Check IPs

//die("(" . $server_ip . ")<br>(" . $seller_ip . ")<br>");

if ($server_ip != $seller_ip) {
	exit("response=11&txid=" . $txid);
}

//Get URL of buyer's server and data format so that transaction data can be sent to it

$strSql = "SELECT data_url, request_format, conv_rate FROM exchanges WHERE nid = '$buyer_nid'";
$result = mysql_query($strSql);

if (!$result) {

	exit("response=9&txid=" . $txid);

} else {

	$row				= mysql_fetch_assoc($result);
	$data_url			= $row['data_url'];
	$request_format		= $row['request_format'];	//format in which remote server requires request data
	$buyer_conv_rate	= $row['conv_rate'];		//Buyer's conversion rate (hourly rate)

}

//die($data_url . " " . $request_format);

if ($data_url == "") {exit("response=7&txid=" . $txid . "&buyer_nid=" . $buyer_nid);} //URL error

//if (strpos($data_url,"http://") === false) {$data_url = "http://" . $data_url;} //Add http:// if missing

//Do Amount conversion if conversion rates differ

if ($action != "delete") {

	if ($seller_conv_rate != $buyer_conv_rate) { //If conversion rates differ then do conversion

		if ($seller_conv_rate == 0 || $buyer_conv_rate == 0) {exit("response=8&txid=" . $txid);} //Respond error 8 if either conversion rate not set

		$buyer_amount = round(($seller_amount * ($buyer_conv_rate/$seller_conv_rate)),2);

	} else {

		$buyer_amount = $seller_amount; //Don't convert

	}

}

/*die(
"Buyer amount: " . $buyer_amount . "<br>" .
"Seller amount: " . $seller_amount . "<br>" .
"Buyer rate: " . $buyer_conv_rate . "<br>" .
"Seller rate: " . $seller_conv_rate . "<br>"
);*/

//Keep record of transaction on its way past

if ($action == "new") {

	$strSql = "INSERT INTO transactions (txid, buyer_id, buyer_nid, seller_id, seller_name, seller_email, seller_nid, description, seller_amount, buyer_amount, seller_conv_rate, buyer_conv_rate, response) VALUES ('$txid', '$buyer_id', '$buyer_nid', '$seller_id', '" . $seller_name . "', '$seller_email', '$seller_nid', '" . $description . "', '$seller_amount', '$buyer_amount', '$seller_conv_rate', '$buyer_conv_rate', '$response')";

	//die($strSql);

} else { //edit/delete

	$strSql = "UPDATE transactions SET seller_amount = '" . $seller_amount . "', buyer_amount = '" . $buyer_amount . "', seller_conv_rate = '" . $seller_conv_rate . "', buyer_conv_rate = '" . $buyer_conv_rate . "', response = '" . $response . "' WHERE txid = '" . $txid . "'";

}

$result = mysql_query($strSql);

if (!$result) {
	exit("response=9&txid=" . $txid);
}

//if ($result) {exit("response=" . $response . "&txid=" . $txid . "&buyer_nid=" . $buyer_nid);}

//Finally send transaction data to remote (buyer's) server and get response

switch ($request_format) {

    case "get":
    case "post":

		//Package data to send to remote server

		$fields  = "txid=" . urlencode($txid);
		$fields .= "&buyer_nid=" . urlencode($buyer_nid);
		$fields .= "&seller_nid=" . urlencode($seller_nid);
		$fields .= "&description=" . urlencode(stripslashes($description));
		$fields .= "&amount=" . $buyer_amount;

		if ($nolevy == "1") { $fields .= "&nolevy=1"; }

		if ($action == "new") {

			$fields .= "&seller_xname=" . urlencode(stripslashes($seller_xname));
			$fields .= "&seller_country=" . urlencode($seller_country);
			$fields .= "&seller_id=" . urlencode($seller_id);
			$fields .= "&seller_name=" . urlencode(stripslashes($seller_name));
			$fields .= "&seller_email=" . urlencode($seller_email);
			$fields .= "&buyer_id=" . urlencode($buyer_id);

			if ($nolevy == "1") { $fields .= "&no_levy=1"; }

		}

		/*echo($fields . "<br>");
		echo($data_url . "<br>");
		die();*/

		// Send data to remote (buyer's) server using cURL

		$ch = curl_init();

		if ($request_format == "post") {

			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($ch, CURLOPT_URL, $data_url);
			curl_setopt($ch, CURLOPT_POST, true);
 			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
 			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
 			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		}

		if ($request_format == "get") {

			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($ch, CURLOPT_URL, $data_url . "?" . $fields);
 			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
 			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		}

		if (strpos($data_url,"https://")) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		}

		$postdata = curl_exec($ch); // Get response from remote server (txrengine)

		$curlerror = curl_errno($ch);

		if ($curlerror) {
			switch ($curlerror) {
				case "28":
					exit("response=14&txid=" . $txid); //Timed out
					break;
				default:
					exit("response=" . $curlerror . "&txid=" . $txid);
			}
		}

		//if ($edit) {
			//die("Txinput: " . $postdata . "<br>"); //Uncomment to see responses from txrengine
		//}

		curl_close($ch);

		parse_str($postdata);

		//die($txid . "<br>" . $response . "<br>" . $buyer_name . "<br>" . $buyer_email);

        break;

	case "csv":

		$csv_data = '"'.$txid.'",'.
			'"'.$buyer_nid.'",'.
			'"'.$buyer_id.'",'.
			'"'.$seller_nid.'",'.
			'"'.$seller_xname.'",'.
			'"'.$seller_country.'",'.
			'"'.$seller_id.'",'.
			'"'.$seller_name.'",'.
			'"'.$seller_email.'",'.
			'"'.$description.'",'.
			'"'.$buyer_amount.'"';

			break;

	case "xml":

		$xml_data ='<?xml version=\"1.0\"?>' .
		'<transaction>' .
			'<txid>'.$txid.'</txid>' .
			'<buyernid>'.$buyer_nid.'</buyerid>' .
			'<buyerid>'.$buyer_id.'</buyernid>' .
			'<sellernid>'.$seller_nid.'</sellernid>' .
			'<sellerxname>'.$seller_xname.'</sellerxname>' .
			'<sellercountry>'.$seller_country.'</sellercountry>' .
			'<sellerid>'.$seller_id.'</sellerid>' .
			'<sellername>'.$seller_name.'</sellername>' .
			'<selleremail>'.$seller_email.'</selleremail>' .
			'<description>'.$description.'</description>' .
			'<amount>'.$buyer_amount.'</amount>' .
		'</transaction>';

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $data_url);
 		curl_setopt($ch, CURLOPT_POST, true);
 		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
 		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
 		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$xmldata = curl_exec($ch); // Get response from remote server

		//die($xmldata . "<br>");

		curl_close($ch);

		$xml = new SimpleXMLElement($xmldata);

		$txid			= $xml->txid[0];
		$response		= $xml->response[0];
		$buyer_name		= $xml->buyername[0];
		$buyer_email	= $xml->buyeremail[0];

		//die($txid . "<br>" . $response . "<br>" . $buyer_name . "<br>" . $buyer_email);

        break;

}

//Update transaction record with additional data supplied by buyer's server

if ($action == "new") {

	$strSql = "UPDATE transactions SET buyer_name = '" . $buyer_name . "', buyer_email = '" . $buyer_email . "', response = " . $response . " WHERE txid = '" . $txid . "'";

} else { //Edited or deleted transaction

	$strSql = "UPDATE transactions SET description = '" . $description . "', seller_amount = '" . $seller_amount . "', buyer_amount = '" . $buyer_amount . "', seller_conv_rate = '" . $seller_conv_rate . "', buyer_conv_rate = '" . $buyer_conv_rate . "', response = '" . $response . "' WHERE txid = '" . $txid . "'";

}

//die($strSql);

$result = mysql_query($strSql);

if (!$result) {
	exit("response=9&txid=" . $txid);
}

if ($action == "new") {

	//Get the traders' details from the transaction to send back to originating server

	$strSql = "SELECT seller_nid, seller_id, seller_name, seller_email, buyer_nid, buyer_id, buyer_name, buyer_email, description, seller_amount, buyer_amount, seller_conv_rate, buyer_conv_rate FROM transactions WHERE txid = '" . $txid . "'";
	$result = mysql_query($strSql);

	if (!$result) {
		exit("response=9&txid=" . $txid);
	} else {
		$row 				= mysql_fetch_assoc($result);
		$buyer_nid			= $row['buyer_nid'];	//Network ID of buyer's exchange
		$buyer_id			= $row['buyer_id'];		//Buyer's account #
		$buyer_name			= $row['buyer_name'];	//Buyer's name
		$buyer_email		= $row['buyer_email'];	//Buyer's email address
		$seller_nid			= $row['seller_nid'];	//Network ID of seller's exchange
		$seller_id			= $row['seller_id'];	//Seller's account #
		$seller_email		= $row['seller_email'];	//Seller's email address
		$seller_name		= $row['seller_name'];	//Seller's name
		$description		= $row['description'];
		$seller_amount		= $row['seller_amount'];
		$buyer_amount		= $row['buyer_amount'];
		$seller_conv_rate	= $row['seller_conv_rate'];
		$buyer_conv_rate	= $row['buyer_conv_rate'];
	}

	$buyer_name	= stripslashes($buyer_name);
	$seller_name = stripslashes($seller_name);
	$description = stripslashes($description);

	//Get buyer's exchange details to add to transaction object

	$strSql = "SELECT xname, country FROM exchanges WHERE nid = '$buyer_nid'";
	$result = mysql_query($strSql);

	if (!$result) {
		exit("response=9&txid=" . $txid);
	} else {
		$row				= mysql_fetch_assoc($result);
		$buyer_xname		= $row['xname'];		//Name of buyer's exchange
		$buyer_country		= $row['country'];		//Country where buyer's exchange is located
	}

}

//Get seller's exchange details to add to transaction object

$strSql = "SELECT xname, country, response_format FROM exchanges WHERE nid = '$seller_nid'";
$result = mysql_query($strSql);

if (!$result) {
	exit("response=9&txid=" . $txid);
} else {
	$row				= mysql_fetch_assoc($result);
	$seller_xname		= $row['xname'];			//Name of seller's exchange
	$seller_country		= $row['country'];			//Country where seller's exchange is located
	$response_format	= $row['response_format'];	//Format in which seller requires response
}

switch ($response) {

	case 1: //Success!

		doBalances($seller_nid, $buyer_nid, $seller_amount, $buyer_amount, $seller_conv_rate, $buyer_conv_rate);

		switch ($response_format) {

    		case "post":

				// Print full transaction object

				$fields  = "txid=" . $txid;
				$fields .= "&response=" . $response;

				if ($action == "new") {

					$fields	.= "&buyer_nid=" . $buyer_nid;
					$fields	.= "&buyer_xname=" . $buyer_xname;
					$fields .= "&buyer_country=" . $buyer_country;
					$fields	.= "&buyer_id=" . $buyer_id;
					$fields .= "&buyer_name=" . $buyer_name;
					$fields	.= "&buyer_email=" . $buyer_email;
					$fields	.= "&seller_nid=" . $seller_nid;
					//$fields	.= "&seller_xname=" . $seller_xname;
					//$fields	.= "&seller_country=" . $seller_country;
					$fields	.= "&seller_id=" . $seller_id;
					//$fields	.= "&seller_name=" . $seller_name;
					//$fields	.= "&seller_email=" . $seller_email;
					$fields	.= "&description=" . $description;
					$fields	.= "&amount=" . $seller_amount;

				}

				print $fields;

	      break;

			case "xml":

				break;
		}

		break;

	case "2": //Buyer error

		$fields  = "txid=" . $txid;
		$fields .= "&response=2";
		$fields	.= "&buyer_id=" . urlencode($buyer_id);
		$fields	.= "&buyer_xname=" . urlencode($buyer_xname);

		print $fields;

		break;

	default: //Transaction failed

		switch ($response_format) {

    		case "post":

				// Send transaction ID and response only

				$fields  = "txid=" . $txid;
				$fields .= "&response=" . $response;
				$fields	.= "&buyer_nid=" . urlencode($buyer_nid);

				print $fields;

	        	break;

	    	case "xml":

				/*$fields  = "?txid=" . $txid;
				$fields .= "&response=" . $response;
				$fields	.= "&buyer_nid=" . urlencode($buyer_nid);

		        print $xml;*/

		        break;
		}

		break;

}

function maketxid($bnid, $snid) {

	$timestamp	= microtime("now");
	$txid		= str_replace("cen","",$snid) . str_replace("cen","",$bnid);
	$txid	   .= $timestamp;

	return($txid);

}

function doBalances($s_nid, $b_nid, $s_amount, $b_amount, $s_rate, $b_rate) {

	//Record this transaction in 'balances' table

	// First get current position of seller's exchange, if any

	$strSql = "SELECT exports, income, time_income, balance, time_balance FROM balances WHERE nid = '" . $s_nid . "'";
	$result = mysql_query($strSql);

	if (!$result) {
		exit("response=9&txid=" . $txid);
	} else {
		$row					= mysql_fetch_assoc($result);
		$exports				= $row['exports'];
		$income					= $row['income'];
		$time_income			= $row['time_income'];
		$seller_balance			= $row['balance'];
		$seller_time_balance	= $row['time_balance'];
	}

	// Then get current position of buyer's exchange, if any

	$strSql = "SELECT imports, expenditure, time_expenditure, balance, time_balance FROM balances WHERE nid = '" . $b_nid . "'";
	$result = mysql_query($strSql);

	if (!$result) {
		exit("response=9&txid=" . $txid);
	} else {
		$row				= mysql_fetch_assoc($result);
		$imports			= $row['imports'];
		$expenditure		= $row['expenditure'];
		$time_expenditure	= $row['time_expenditure'];
		$buyer_balance		= $row['balance'];
		$buyer_time_balance	= $row['time_balance'];
	}

	//Update figures

	if ($exports == "" || $exports == 0) {
		$blnNoSellerRecord = true;
		$exports = 0;
		$income = 0;
		$time_income = 0;
		$seller_balance = 0;
		$seller_time_balance = 0;
	}

	if ($imports == "" || $imports == 0) {
		$blnNoBuyerRecord = true;
		$imports = 0;
		$expenditure = 0;
		$time_expenditure = 0;
		$buyer_balance = 0;
		$buyer_time_balance = 0;
	}

	++ $exports;
	++ $imports;

	$income					= $income + $s_amount;
	$time_income			= $time_income + round(($s_amount/$s_rate),2);
	$expenditure			= $expenditure + $b_amount;
	$time_expenditure		= $time_expenditure + round(($b_amount/$b_rate),2);
	$seller_balance			= $seller_balance + $s_amount;
	$seller_time_balance	= $seller_time_balance + round(($s_amount/$s_rate),2);
	$buyer_balance			= $buyer_balance - $b_amount;
	$buyer_time_balance		= $buyer_time_balance - round(($b_amount/$b_rate),2);

	//Now create or update seller's exchange balance

	if ($blnNoSellerRecord) {
		$strSql = "INSERT INTO balances (nid, exports, income, time_income, imports, expenditure, time_expenditure, balance, time_balance) VALUES ('" . $s_nid . "'," . $exports . "," . $s_amount . "," . $time_income . ",0,0,0," . $seller_balance . "," . $seller_time_balance . ")";
	} else {
		$strSql = "UPDATE balances SET exports = " . $exports . ", income = " . $income . ", time_income = " . $time_income . ", balance = " . $seller_balance . ", time_balance = " . $seller_time_balance . " WHERE nid = '" . $s_nid . "'";
	}

	//echo $strSql . "<br>";
	mysql_query($strSql);

	//Then create or update buyer's exchange balance

	if ($blnNoBuyerRecord) {
		$strSql = "INSERT INTO balances (nid, exports, income, time_income, imports, expenditure, time_expenditure, balance, time_balance) VALUES ('" . $b_nid . "',0,0,0," . $imports . "," . $b_amount . "," . $time_expenditure . "," . $buyer_balance . "," . $buyer_time_balance . ")";
	} else {
		$strSql = "UPDATE balances SET imports = " . $imports . ", expenditure = " . $expenditure . ", time_expenditure = " . $time_expenditure . ", balance = " . $buyer_balance . ", time_balance = " . $buyer_time_balance . " WHERE nid = '" . $b_nid . "'";
	}

	mysql_query($strSql);

}

function checkinput($inputstring) {

	$inputstring = trim($inputstring);
	$filtered_var = "";

	if (isset($_GET[$inputstring])){
		$filtered_var = htmlspecialchars($_GET[$inputstring], ENT_QUOTES);
	}
	if (isset($_POST[$inputstring])){
		$filtered_var = htmlspecialchars($_POST[$inputstring], ENT_QUOTES);
	}
	if (isset($_REQUEST[$inputstring])){
		$filtered_var = htmlspecialchars($_REQUEST[$inputstring], ENT_QUOTES);
	}

	return $filtered_var;

}
?>
