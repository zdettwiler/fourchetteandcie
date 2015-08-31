<?php namespace FandC\Http\Controllers;

use FandC\Http\Requests;
use FandC\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Basket;
use Config;
use DB;
use EMailGenerator;
use FandC\Models\Order;


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
use PayPal\Api\PaymentExecution;

/* CHECKOUT PROCESS
	1. index()				Show Basket

*/

class CheckoutController extends Controller
{
//----------------------------------------------------------------------------//
// STEP 1: SHOW BASKET
//----------------------------------------------------------------------------//
	public function index()
	{
		$basket = Basket::show_basket();
		return view('checkout.index', compact('basket'));
	}

//----------------------------------------------------------------------------//
// STEP 2: SHIPPING
//----------------------------------------------------------------------------//
	public function shipping()
	{
		return view('checkout.shipping');
	}

//----------------------------------------------------------------------------//
// STEP 3: CONFIRMATION
//----------------------------------------------------------------------------//
	public function confirm($order_token, Request $shipping_details)
	{
		$order = new Order($order_token);
		$order->set_customer_name($shipping_details['name']);
		$order->set_customer_phone($shipping_details['phone']);
		$order->set_customer_email($shipping_details['email']);
		$order->set_customer_address($shipping_details['address1'].'\n'.$shipping_details['address2'].'\n'.$shipping_details['zip'].' - '.$shipping_details['city'].'\n'.$shipping_details['country']);

		$order->save_to_db();
		return view('checkout.confirm', compact('shipping_details', 'order_token'));
	}

//----------------------------------------------------------------------------//
// STEP 4: PLACE ORDER
//----------------------------------------------------------------------------//
	public function place($order_token)
	{
		$order = new Order($order_token);
		$order_id = $order->get_order_id();

		$order->set_order(Basket::json_encode_decode());
		$order->set_placed_datetime( time() );

		list($nb_items_in_basket, $subtotal) = Basket::get_nb_items_subtotal();
		$order->set_order_nb_items($nb_items_in_basket);
		$order->set_order_subtotal($subtotal);
		$order->set_order_total($subtotal);

		$order->save_to_db();

		EMailGenerator::send_papi_new_order($order_id);
		EMailGenerator::send_cust_placed_order($order_id);

		return view('checkout.placed', compact('order_id'));
	}

//----------------------------------------------------------------------------//
// STEP 5: PAYPAL PAYMENT
//----------------------------------------------------------------------------//
	public function payment($order_token)
	{
		$order = DB::table('orders')->where('order_token', $order_token)->first();
		$order_details = Basket::json_encode_decode($order->val_order);
		$section_ref_code = Config::get('fandc_arrays')['section_ref_code'];

		if($order->order_currency == 'eur')
			$currency = '&euro;';
		elseif($order->order_currency == 'aud')
			$currency = 'AU$';

		// If order hasn't beem validated, don't allow access
		if($order->is_validated == 0)
		{
			// Custom Error Message...
			return view('checkout.placed', compact('order'))
				->with('notification', ['type' => 'negative', 'message' => "You can't pay now, your order has not been validated yet."]);
		}
		elseif($order->is_validated == 1)
		{
			return view('checkout.payment', compact('order', 'order_details', 'currency'));
		}

	}

	public function init_payment($order_token)
	{

		$order = DB::table('orders')->where('order_token', $order_token)->first();
		$order_details = Basket::json_encode_decode($order->val_order);

		// echo getcwd();
		require '../laravel5.0/vendor/autoload.php';

		// get PayPal credentials
		$paypal_conf = Config::get('paypal');
		$paypal = new ApiContext(new OAuthTokenCredential( $paypal_conf['client_id'], $paypal_conf['secret'] ));

		// from database
		$subtotal = $order->val_order_subtotal;
		$shipping = $order->val_order_shipping;
		// $discount = 10.00; // %
		$total = $order->val_order_total;

		// define payer
		$payer = new Payer();
		$payer->setPaymentMethod('paypal');

		// define items
		$items = [];
		$test = 0;
		foreach($order_details as $order_item)
		{
			$item = new Item();
			$item->setName($order_item['stamped'] . $order_item['name'])
				 ->setQuantity($order_item['qty'])
				 ->setPrice($order_item['price'])
				 ->setCurrency('EUR');
			$items[] = $item;
		}

		// define wholesale discount if set
		if($order->is_wholesale)
		{
			$item = new Item();
			$item->setName('--WHOLESALE DISCOUNT--')
				 ->setQuantity(1)
				 ->setPrice(-0.3 * $subtotal)
				 ->setCurrency('EUR');
			$items[] = $item;
		}

		// define item list
		$item_list = new ItemList();
		$item_list->setItems($items);

		// define details
		$details = new Details();
		$details->setShipping($shipping)
				->setSubtotal(0.7 * $subtotal);

		// define amount
		$amount = new Amount();
		$amount->setCurrency('EUR')
			   ->setTotal($total)
			   ->setDetails($details);

		// define transaction
		$transaction = new Transaction();
		$transaction->setAmount($amount)
					->setItemList($item_list)
					->setDescription('Fourchette and Cie - Payment')
					->setInvoiceNumber($order->id);

		// define redirect urls
		$redirect_urls = new RedirectUrls();
		$redirect_urls->setReturnUrl('http://localhost/display-only/fourchetteandcie/public_html/checkout/'. $order_token .'/shipping/confirm/placed/payment/pay')
					  ->setCancelUrl('http://localhost/display-only/fourchetteandcie/public_html/checkout/'. $order_token .'/shipping/confirm/placed/payment');

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
		catch(\PayPal\Exception\PayPalConnectionException $e)
		{
			return redirect('http://localhost/display-only/fourchetteandcie/public_html/checkout/'.$order_token.'/shipping/confirm/placed/payment')
				->with('notification', ['type' => 'negative', 'message' => 'There has been an error when connecting with PayPal...<br>'.$e->getData()]);
			// dd($e->getData()); //Change this later
		}

		echo $approval_url = $payment->getApprovalLink();

		header("Location: {$approval_url}");
		exit;
	}

	public function make_payment($order_token)
	{
		// get PayPal credentials
		$paypal_conf = Config::get('paypal');
		$paypal = new ApiContext(new OAuthTokenCredential( $paypal_conf['client_id'], $paypal_conf['secret'] ));

		if(!isset($_GET['paymentId'], $_GET['PayerID']))
		{
			return redirect('http://localhost/display-only/fourchetteandcie/public_html/checkout/'.$order_token.'/shipping/confirm/placed/payment')
				->with('notification', ['type' => 'negative', 'message' => 'There has been an error when connecting with PayPal...']);
		}

		$paymentID = $_GET['paymentId'];
		$payerID = $_GET['PayerID'];

		$payment = Payment::get($paymentID, $paypal);

		$execute = new PaymentExecution();
		$execute->setPayerId($payerID);

		try
		{
			$result = $payment->execute($execute, $paypal);
		}
		catch (\Exception $e)
		{
			return redirect('http://localhost/display-only/fourchetteandcie/public_html/checkout/'.$order_token.'/shipping/confirm/placed/payment')
				->with('notification', ['type' => 'negative', 'message' => 'There has been an error when trying to execute the payment with PayPal...<br>'.$e]);
			//die($e);
		}

		// update database about payment
		DB::table('orders')
			->where('order_token', $order_token)
			->update(['is_payed' => 1]);

		// send emails
		$order_id = DB::table('orders')
						->where('order_token', $order_token)
						->pluck('id');

		EMailGenerator::send_papi_paid_order($order_id);
		EMailGenerator::send_cust_thank_you($order_id);

		// detroy Basket
		Basket::empty_basket();

		return redirect('http://localhost/display-only/fourchetteandcie/public_html/checkout/'. $order_token .'/shipping/confirm/placed/payment/thanks');

	}

//----------------------------------------------------------------------------//
// STEP 6: THANK YOU
//----------------------------------------------------------------------------//
	public function thanks($order_token)
	{
		$order = DB::table('orders')->where('order_token', $order_token)->first();
		$order_details = Basket::json_encode_decode($order->val_order);
		$section_ref_code = Config::get('fandc_arrays')['section_ref_code'];

		if($order->is_payed == 1)
		{
			return view('checkout.thanks', compact('order', 'order_details', 'section_ref_code'));
		}
		else
		{
			echo "You're not allowed here...";
		}

	}


}
