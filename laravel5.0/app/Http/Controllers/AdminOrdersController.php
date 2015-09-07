<?php namespace FandC\Http\Controllers;

use FandC\Http\Requests;
use FandC\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Basket;
use Config;
use DB;
use EMailGenerator;
use FandC\Models\Order;
use OrderValidation;
use PDF;
use Session;

class AdminOrdersController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function all_orders()
	{
		$orders = DB::table('orders')
			->orderBy('placed_datetime', 'desc')
			->get();
		return view('admin.orders.all_orders', compact('orders'));
	}

	public function one_order($id)
	{
		$order = DB::table('orders')->where('id', $id)->first();
		$cutlery_categ_list = Config::get('fandc_arrays')['cutlery_categ_list'];

		if($order->is_validated == 1)
		{
			$order_details = Basket::json_encode_decode($order->val_order);
		}
		else
		{
			$order_details = Basket::json_encode_decode($order->order);
		}

		// var_dump($order);

		if($order->order_currency == 'eur')
			$currency = '&euro;';
		elseif($order->order_currency == 'aud')
			$currency = 'AU$';

		return view('admin.orders.one_order', compact('order', 'order_details', 'currency'));
	}

	public function validate_order($id)
	{
		$order = DB::table('orders')->where('id', $id)->first();

		new OrderValidation($id);
		// dd(Session::get('validation_order', []));

		return view('admin.orders.validate_order', compact('order'));
	}

	public function validate_order_command($id, $command, $ref=0, $value=0)
	{
		$command = urldecode($command);
		$ref = urldecode($ref);
		$value = urldecode($value);

		switch ($command)
		{
			case 'SHOW':
				OrderValidation::validation_table_html($id);
				break;

			case 'TOGGLE_CURRENCY':
				OrderValidation::toggle_currency($id);
				OrderValidation::validation_table_html($id);
				break;

			case 'UPDATE_QTY':
				OrderValidation::update_qty($id, $ref, $value);
				OrderValidation::validation_table_html($id);
				break;

			case 'UPDATE_COMMENT':
				OrderValidation::update_comment($id, $ref, $value);
				OrderValidation::validation_table_html($id);
				break;

			case 'UPDATE_UNIT_PRICE':
				OrderValidation::update_unit_price($id, $ref, $value);
				OrderValidation::validation_table_html($id);
				break;

			case 'UPDATE_SHIPPING':
				OrderValidation::update_shipping($id, $value);
				OrderValidation::validation_table_html($id);
				break;

			case 'UPDATE_SHIPPING_DETAILS':
				OrderValidation::update_shipping_details($id, $value);
				OrderValidation::validation_table_html($id);
				break;

			case 'ADD':
				OrderValidation::add($id, $ref);
				OrderValidation::validation_table_html($id);
				break;

			case 'ADD_CUSTOM':
				OrderValidation::add_custom($id, $value);
				OrderValidation::validation_table_html($id);
				break;

			case 'TOGGLE_WHOLESALE':
				OrderValidation::toggle_wholesale($id);
				OrderValidation::validation_table_html($id);
				break;

			case 'TOGGLE_PAYED':
				OrderValidation::toggle_payed($id);
				break;

			case 'UPDATE_MESSAGE':
				OrderValidation::update_message($id, $value);
				OrderValidation::validation_table_html($id);
				break;
		}
	}

	public function submit_validated_order($id)
	{
		DB::table('orders')
			->where('id', $id)
			->update([
						'is_validated' => 1
					]);
		$this->make_pdf_invoice($id);
		EMailGenerator::send_cust_validated_order($id);

		return redirect('admin/orders/'.$id);
	}

	public function make_pdf_invoice($id)
	{
		$order = DB::table('orders')->where('id', $id)->first();
		$order_details = Basket::json_encode_decode($order->val_order);

		if($order->order_currency == 'eur')
			$currency = '&euro;';
		elseif($order->order_currency == 'aud')
			$currency = 'AU$';

		// return view('admin.orders.invoice', compact('order', 'order_details'));

		$pdf = PDF::loadView('admin.orders.invoice', compact('order', 'order_details', 'currency'))
			->save('/home/fouraqir/invoices/'. $order->order_token .'.pdf');
	}

	public function show_pdf_invoice($id)
	{
		$order = DB::table('orders')->where('id', $id)->first();
		$order_details = Basket::json_encode_decode($order->val_order);

		if($order->order_currency == 'eur')
			$currency = '&euro;';
		elseif($order->order_currency == 'aud')
			$currency = 'AU$';

		// return view('admin.orders.invoice', compact('order', 'order_details'));

		$pdf = PDF::loadView('admin.orders.invoice', compact('order', 'order_details', 'currency'));
			// ->save('/home/fouraqir/invoices/my_stored_file.pdf');
		// $pdf->loadHTML('<h1>Test</h1>');
		return $pdf->stream();
	}

}
