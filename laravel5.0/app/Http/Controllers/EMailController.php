<?php namespace FandC\Http\Controllers;

use FandC\Http\Requests;
use FandC\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DB;
use Mail;


class EMailController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function send_papi_new_order($order_id=2)
	{
		$order = DB::table('orders')
			->where('id', $order_id)
			->first();

		// dd($order);

		// return view('emails.papi_new_order', compact('order'));

		$send = Mail::send('emails.papi_new_order', compact('order'), function($message)
		{
			$message->from('orders@fourchetteandcie.com', 'Fourchette & Cie - Admin');
			
			$message->subject('New Orderjjj!');

			$message->to('z.dettwiler@gmail.com');

			// $message->attach($pathToFile);
		});

		// if($send)
	}

	/*public function send_papi_payed_order($order_id)
	{
		Mail::send('emails.papi_payed_order', [], function($message)
		{
			$message->from('orders@fourchetteandcie.com', 'Fourchette & Cie - Admin');

			$message->subject('The order {{ $order_id }} has been payed!');

			$message->to('fourchetteandcie@gmail.com');

			// $message->attach($pathToFile);
		});
	}

	public function send_cust_placed_order()
	{
		Mail::send('emails.cust_placed_order', $, function($message)
		{
			$message->from('orders@fourchetteandcie.com', 'Fourchette & Cie - Admin');

			$message->subject('We have received your order (#{{ $order->id }})');

			$message->to('{{ $order->customer_email }}');

			// $message->attach($pathToFile);
		});
	}

	public function send_cust_($order_id)
	{
		Mail::send('emails.cust_', [], function($message)
		{
			$message->from('orders@fourchetteandcie.com', 'Fourchette & Cie - Admin');

			$message->subject('The order {{ $order_id }} has been payed!');

			$message->to('fourchetteandcie@gmail.com');

			// $message->attach($pathToFile);
		});
	}

	public function send_cust_($order_id)
	{
		Mail::send('emails.cust_', [], function($message)
		{
			$message->from('orders@fourchetteandcie.com', 'Fourchette & Cie - Admin');

			$message->subject('The order {{ $order_id }} has been payed!');

			$message->to('fourchetteandcie@gmail.com');

			// $message->attach($pathToFile);
		});
	}*/


}
