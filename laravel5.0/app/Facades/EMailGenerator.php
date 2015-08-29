<?php namespace FandC\Facades;

use Illuminate\Http\Request;

use Config;
use DB;
use Mail;

class EMailGenerator
{
    public static function send_papi_new_order($order_id)
	{
		$order = DB::table('orders')
			->where('id', $order_id)
			->first();

		$sent = Mail::send('emails.papi_new_order', compact('order'), function($message) use ($order_id)
		{
			$message->from('orders@fourchetteandcie.com', 'Fourchette & Cie - Admin');

			$message->subject('New Order! (nº'. sprintf('%03u', $order_id) .')');

			$message->to('z.dettwiler@gmail.com');

			// $message->attach($pathToFile);
		});
	}

	public static function send_cust_placed_order($order_id)
	{
		$order = DB::table('orders')
			->where('id', $order_id)
			->first();

		$sent = Mail::send('emails.cust_placed_order', compact('order'), function($message) use ($order_id)
		{
			$message->from('orders@fourchetteandcie.com', 'Fourchette & Cie - Admin');

			$message->subject('We have received your order (nº'. sprintf('%03u', $order_id) .')');

			$message->to('z.dettwiler@gmail.com');
			// $message->to('{{ $order->customer_email }}');

			// $message->attach($pathToFile);
		});
	}

	public static function send_cust_validated_order($order_id)
	{
		$order = DB::table('orders')
			->where('id', $order_id)
			->first();

        $order_token = $order->order_token;

		$sent = Mail::send('emails.cust_validated_order', compact('order'), function($message) use ($order_id, $order_token)
		{
			$message->from('orders@fourchetteandcie.com', 'Fourchette & Cie - Admin');

			$message->subject('Your order (nº'. sprintf('%03u', $order_id) .') has been validated!');

			$message->to('z.dettwiler@gmail.com');

			$message->attach('/home/fouraqir/invoices/'. $order_token .'.pdf');
		});
	}

	public static function send_papi_payed_order($order_id)
	{
		$sent = Mail::send('emails.papi_payed_order', ['order_id' => $order_id], function($message) use ($order_id)
		{
			$message->from('orders@fourchetteandcie.com', 'Fourchette & Cie - Admin');

			$message->subject('The order nº'. sprintf('%03u', $order_id) .' has been payed!');

			$message->to('z.dettwiler@gmail.com');

			// $message->attach($pathToFile);
		});
	}

	public static function send_cust_thank_you($order_id)
	{
		$order = DB::table('orders')
			->where('id', $order_id)
			->first();

		$sent = Mail::send('emails.cust_thank_you', compact('order'), function($message)
		{
			$message->from('orders@fourchetteandcie.com', 'Fourchette & Cie - Admin');

			$message->subject('Thank You!');

			$message->to('z.dettwiler@gmail.com');

			// $message->attach($pathToFile);
		});
	}

}
