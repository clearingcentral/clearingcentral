<?php

//Get responses from clearing central

$txid            = $_REQUEST['txid'];
$buyer_nid        = $_REQUEST['buyer_nid'];
$buyer_xname    = $_REQUEST['buyer_xname'];
$buyer_country    = $_REQUEST['buyer_country'];
$buyer_id        = $_REQUEST['buyer_id'];
$buyer_name        = $_REQUEST['buyer_name'];
$buyer_email    = $_REQUEST['buyer_email'];
$seller_nid        = $_REQUEST['seller_nid'];
$seller_xname    = $_REQUEST['seller_xname'];
$seller_country    = $_REQUEST['seller_country'];
$seller_id        = $_REQUEST['seller_id'];
$seller_name    = $_REQUEST['seller_name'];
$seller_email    = $_REQUEST['seller_email'];
$description    = $_REQUEST['description'];
$amount            = $_REQUEST['amount'];
$response        = $_REQUEST['response'];

$transaction_object =
"Transaction ID: " . $txid . "<br>" .
"Buyer's network ID: " . $buyer_nid . "<br>" .
"Buyer's exchange name: " . $buyer_xname . "<br>" .
"Buyer's country: " . $buyer_country . "<br>" .
"Buyer's account #: " . $buyer_id . "<br>" .
"Buyer's name: " . $buyer_name . "<br>" .
"Buyer's email: " . $buyer_email . "<br>" .
"Seller's network ID: " . $seller_nid . "<br>" .
"Seller' exchange name: " . $seller_xname . "<br>" .
"Seller's country: " . $seller_country . "<br>" .
"Seller's account #: " . $seller_id . "<br>" .
"Seller's name: " . $seller_name . "<br>" .
"Seller's email: " . $seller_email . "<br>" .
"Description: " . $description . "<br>" .
"Amount: " . $amount . "<br>" .
"Response: " . $response;

echo $transaction_object;
?>
