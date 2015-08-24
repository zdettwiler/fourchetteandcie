<?php namespace FandC\Models;

use Illuminate\Database\Eloquent\Model;

use Config;
use DB;
use Session;

/* WILL BE NEEDED IN Order MODEL
	Attributes
		- order unique id
		- date and time of creation
		- is_validated
		- is_payed
		- basket Model instance
		- name of client
		- shipping address
		- shipping price

	Methods
		- make paypal payment
		- update on db
		- retrieve from db
		- getters and setters

*/

class Order extends Model
{
	// ATTRIBUTES

	// technical
	private $order_id;						// unique id, datetime?
	private $order_token;						// unique id, datetime?
	private $placed_datetime;				// when the order was placed
	private $is_validated = 0;				// has been checked and approved by admin
	private $is_payed = 0;					// has been payed (paypal)
	private $is_wholesale = 0;

	// customer details
	private $customer_name;
	private $customer_address;
	private $customer_email;
	private $customer_phone;

	// order
	private $order;
	private $order_nb_items;
	private $order_subtotal;
	private $order_shipping;
	private $order_discount;
	private $order_total;


	// METHODS

	// load order
	public function __construct($order_token)
	{
		$loaded_order = DB::table('orders')
			->where('order_token', '=', $order_token)
			->first();

		if(is_null($loaded_order))
		{
			// Session::put('order', array());
			$this->order_token = $order_token;
			DB::table('orders')->insert([
				'order_token' => $order_token
			]);
		}
		else
		{
			// technical
			$this->order_id         = $loaded_order->id;
			$this->order_token      = $loaded_order->order_token;
			$this->placed_datetime  = $loaded_order->placed_datetime;
			$this->is_validated     = $loaded_order->is_validated;
			$this->is_payed         = $loaded_order->is_payed;
			$this->is_wholesale     = $loaded_order->is_wholesale;

			// customer details
			$this->customer_name    = $loaded_order->customer_name;
			$this->customer_address = $loaded_order->customer_address;
			$this->customer_email   = $loaded_order->customer_email;
			$this->customer_phone   = $loaded_order->customer_phone;

			// order
			$this->order            = $loaded_order->order;
			$this->order_nb_items   = $loaded_order->order_nb_items;
			$this->order_subtotal   = $loaded_order->order_subtotal;
			$this->order_shipping   = $loaded_order->order_shipping;
			// $this->order_discount   = $loaded_order->order_discount;
			$this->order_total      = $loaded_order->order_total;
		}
	}


	// update order on db
	public function save_to_db()
	{
		DB::table('orders')
			->where('order_token', $this->order_token)
			->update([
				// technical
				'placed_datetime'  => $this->placed_datetime,
				'is_validated'     => $this->is_validated,
				'is_payed'         => $this->is_payed,
				'is_wholesale'     => $this->is_wholesale,

				// customer details
				'customer_name'    => $this->customer_name,
				'customer_address' => $this->customer_address,
				'customer_email'   => $this->customer_email,
				'customer_phone'   => $this->customer_phone,

				// order
				'order'            => $this->order,
				'order_nb_items'   => $this->order_nb_items,
				'order_subtotal'   => $this->order_subtotal,
				'order_shipping'   => $this->order_shipping,
				// 'order_discount'   => $this->order_discount,
				'order_total'      => $this->order_total
			]);
	}

	public static function update_validated_order($ref, $ppt, $new_val)
	{
		if($new_qty == 0)
		{
			self::remove($ref);
			return;
		}

		if($ppt == "qty")
		{

			$validated_order = Session::get('validated_order', []);

			// Check/Find if item is already in the basket
			for($i=0 ; $i<=count($validated_order)-5 ; $i++)
			{
				// If YES, update its qty
				if($validated_order[$i]['ref'] == $ref)
				{
					$validated_order[$i]['qty'] = $new_val;
					break;
				}
			}
		}


		Session::set('validated_order', $validated_order);

		return false;
	}







	// getters
	public function get_order_id()
	{
		return $this->order_id;
	}
	public function get_order_token()
	{
		return $this->order_token;
	}
	public function get_shipping_price()
	{
		return $this->shipping_price;
	}
	public function get_basket_price()
	{
		return $this->basket_price;
	}
	public function get_total()
	{
		return $this->total;
	}
	public function get_placed_datetime()
	{
		return $this->placed_datetime;
	}
	public function get_is_validated()
	{
		return $this->is_validated;
	}
	public function get_is_payed()
	{
		return $this->is_payed;
	}
	public function get_customer_name()
	{
		return $this->customer_name;
	}
	public function get_customer_address()
	{
		return $this->customer_address;
	}
	public function get_customer_phone()
	{
		return $this->customer_phone;
	}
	public function get_customer_email()
	{
		return $this->customer_email;
	}

	// setters
	public function set_placed_datetime($datetime)
	{
		$this->placed_datetime = $datetime;
	}
	public function set_is_validated($validated)
	{
		$this->is_validated = $validated;
	}
	public function set_is_payed($payed)
	{
		$this->is_payed = $payed;
	}
	public function set_is_wholesale($wholesale)
	{
		$this->is_wholesale = $wholesale;
	}
	public function set_customer_name($name)
	{
		$this->customer_name = $name;
	}
	public function set_customer_address($address)
	{
		$this->customer_address = $address;
	}
	public function set_customer_email($email)
	{
		$this->customer_email = $email;
	}
	public function set_customer_phone($phone)
	{
		$this->customer_phone = $phone;
	}
	public function set_order($order)
	{
		$this->order = $order;
	}
	public function set_order_nb_items($nb_items)
	{
		$this->order_nb_items = $nb_items;
	}
	public function set_order_subtotal($subtotal)
	{
		$this->order_subtotal = $subtotal;
	}
	public function set_order_shipping($shipping)
	{
		$this->order_discount = $shipping;
	}
	public function set_order_discount($discount)
	{
		$this->order_discount = $discount;
	}
	public function set_order_total($total)
	{
		$this->order_total = $total;
	}
}
