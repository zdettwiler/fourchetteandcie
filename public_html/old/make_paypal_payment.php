<?php

require '../vendor/autoload.php';

use Config;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;

// get PayPal credentials
$paypal_conf = Config::get('paypal');
$paypal = new ApiContext(new OAuthTokenCredential( $paypal_conf['client_id'], $paypal_conf['secret'] ));

// $basket = $_SESSION['basket'];
$total = 15.00;
$shipping = 15.00;
$discount = 10.00; // %

// define payer
$payer = new Payer();
$payer->setPaymentMethod('paypal');

// define items
$item = new Item();
$item->setName('item name')
	 ->setQuantity(1)
	 ->setPrice(15.00)
	 ->setCurrency('EUR');

// define item list
$item_list = new ItemList();
$item_list->setItems([$item]);

// define details
$details = new Details();
$details->setShipping($shipping)
		->setSubtotal($total);

// define amount
$amount = new Amount();
$amount->setCurrency('EUR')
	   ->setTotal($total+$shipping)
	   ->setDetails($details);

// define transaction
$transaction = new Transaction();
$transaction->setAmount($amount)
			->setItemList($item_list)
			->setDescription('Friday Bowtie Payment')
			->setInvoiceNumber(uniqid());

// define redirect urls
$redirect_urls = new RedirectUrls();
$redirect_urls->setReturnUrl('http://localhost/fridaybowtie/public')
			  ->setCancelUrl('http://localhost/fridaybowtie/public');

// define payment
$payment = new Payment();
$payment->setIntent('sale')
		->setPayer($payer)
		->setRedirectUrls($redirect_urls)
		->setTransactions([$transaction]);

// initiate payment
try
{
	$payment->create($paypal);
}
catch(Exception $e)
{
	die($e); //Change this later
}

$approval_url = $payment->getApprovalLink();

header("Location: {$approval_url}");
exit;
