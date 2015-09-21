<?php namespace FandC\Facades;

use DB;
use Config;
use Item;
use Session;

class OrderValidation
{
//----------------------------------------------------------------------------//
// CONSTRUCTOR
//----------------------------------------------------------------------------//
	public function __construct($order_id)
	{
		$val_order = DB::table('orders')->where('id', $order_id)->pluck('val_order');

		if(strlen($val_order) < 2)
		{
			$order = json_decode(DB::table('orders')
						->where('id', $order_id)
						->pluck('order'));

			// add comment to each item
			foreach($order as $key => $item)
			{
				$order[$key]->comment = '';
			}

			// echo $order[0]->comment;
			// echo json_encode($order);
			// dd($order);
			self::save_order_to_db($order_id, $order);
			return false;
		}

		return false;
	}

//----------------------------------------------------------------------------//
// TOGGLE ORDER CURRENCY EUR OR AUD
//----------------------------------------------------------------------------//
	public static function toggle_currency($order_id)
	{
		$ORDER = DB::table('orders')->where('id', $order_id)->first();

		if($ORDER->order_currency == 'eur')
		{
			DB::table('orders')
				->where('id', $order_id)
				->update(['order_currency' => 'aud']);
		}
		elseif($ORDER->order_currency == 'aud')
		{
			DB::table('orders')
				->where('id', $order_id)
				->update(['order_currency' => 'eur']);
		}

		return false;
	}

//----------------------------------------------------------------------------//
// UPDATE ITEM QUANTITY
//----------------------------------------------------------------------------//
	public static function update_qty($order_id, $ref, $new_qty)
	{
		if(!is_numeric($new_qty))
		{
			$new_qty = 1;
		}

		$ORDER = DB::table('orders')->where('id', $order_id)->first();
		$VALIDATED_ORDER = json_decode($ORDER->val_order);

		if($new_qty == 0)
		{
			self::remove($order_id, $ref);
			return;
		}

		// Check/Find if item is already in the basket
		foreach($VALIDATED_ORDER as $item)
		{
			// If YES, update its qty
			if($item->ref == $ref)
			{
				$item->qty = $new_qty;
				break;
			}
		}

		self::save_order_to_db($order_id, $VALIDATED_ORDER);
		return false;
	}

//----------------------------------------------------------------------------//
// UPDATE ITEM COMMENT
//----------------------------------------------------------------------------//
	public static function update_comment($order_id, $ref, $comment)
	{
		$ORDER = DB::table('orders')->where('id', $order_id)->first();
		$VALIDATED_ORDER = json_decode($ORDER->val_order);

		if($comment == '--null')
		{
			$comment = '';
		}

		// Check/Find if item is already in the basket
		foreach($VALIDATED_ORDER as $item)
		{
			// If YES, update its qty
			if($item->ref == $ref)
			{
				$item->comment = $comment;
				break;
			}
		}

		self::save_order_to_db($order_id, $VALIDATED_ORDER);
		return false;
	}

//----------------------------------------------------------------------------//
// UPDATE ITEM UNITARY PRICE
//----------------------------------------------------------------------------//
	public static function update_unit_price($order_id, $ref, $unit_price)
	{
		if(!is_numeric($unit_price))
		{
			$unit_price = 0.00;
		}

		$ORDER = DB::table('orders')->where('id', $order_id)->first();
		$VALIDATED_ORDER = json_decode($ORDER->val_order);

		// Check/Find if item is already in the basket
		foreach($VALIDATED_ORDER as $item)
		{
			// If YES, update its unit price
			if($item->ref == $ref)
			{
				$item->price = $unit_price;
				break;
			}
		}

		self::save_order_to_db($order_id, $VALIDATED_ORDER);
		return false;
	}

//----------------------------------------------------------------------------//
// UPDATE ORDER SHIPPING PRICE
//----------------------------------------------------------------------------//
	public static function update_shipping($order_id, $shipping)
	{
		if(!is_numeric($shipping))
		{
			$shipping = 0.00;
		}

		DB::table('orders')
			->where('id', $order_id)
			->update([
						'val_order_shipping' => $shipping
					]);

		self::save_order_to_db($order_id);
		return false;
	}

//----------------------------------------------------------------------------//
// UPDATE ORDER SHIPPING DETAILS
//----------------------------------------------------------------------------//
	public static function update_shipping_details($order_id, $shipping_details)
	{
		DB::table('orders')
			->where('id', $order_id)
			->update([
						'val_order_shipping_details' => $shipping_details
					]);

		return false;
	}

//----------------------------------------------------------------------------//
// ADD A NEW ITEM TO ORDER
//----------------------------------------------------------------------------//
	public static function add($order_id, $ref)
	{
		$ORDER = DB::table('orders')->where('id', $order_id)->first();
		$VALIDATED_ORDER = json_decode($ORDER->val_order);

		$item_to_add = new Item($ref);

		//Check if ref is already in the order...
		foreach($VALIDATED_ORDER as $item)
		{
			// ...if yes, make a duplicate
			if($item->ref == $ref)
			{
				$next_duplicate = 1;
				foreach($VALIDATED_ORDER as $order_item)
				{
					list($duplicate) = sscanf($order_item->ref, $ref."_%d");

					if($duplicate > $next_duplicate)
					{
						$next_duplicate = $duplicate;
					}
				}
				// dd($next_duplicate);

				$ref = $ref.'_'.($next_duplicate);
				break;
			}
		}

		// Add item
		$VALIDATED_ORDER[] = (object) [
				'ref'     => $ref,
				'qty'     => 1,
				'name'    => $item_to_add->get_name(),
				'descr'   => $item_to_add->get_descr(),
				'name'    => $item_to_add->get_name(),
				'price'   => $item_to_add->get_price(),
				'img'     => $item_to_add->get_img_count(),
				'categ'   => $item_to_add->get_categ(),
				'comment' => 'has been added'
			];

		self::save_order_to_db($order_id, $VALIDATED_ORDER);
		return false;
	}

//----------------------------------------------------------------------------//
// ADD A CUSTOM ITEM TO THE ORDER
//----------------------------------------------------------------------------//
	public static function add_custom($order_id, $value)
	{
		$ORDER = DB::table('orders')->where('id', $order_id)->first();
		$VALIDATED_ORDER = json_decode($ORDER->val_order);

		$new_item = explode("--", $value);
		if(!is_numeric($new_item[2]))
		{
			$new_item[2] = 0.00;
		}

		$max_custom_item = 0;

		foreach($VALIDATED_ORDER as $item)
		{
			list($custom_item_id) = sscanf($item->ref, "_%d");

			if($custom_item_id > $max_custom_item)
			{
				$max_custom_item = $custom_item_id;
			}
		}

		// Add custom item
		$VALIDATED_ORDER[] = (object) [
				'ref'     => '_'.($max_custom_item + 1),
				'qty'     => 1,
				'name'    => $new_item[0],
				'descr'   => $new_item[1],
				'price'   => $new_item[2],
				'img'     => 0,
				'categ'   => '',
				'comment' => 'custom item'
			];

		self::save_order_to_db($order_id, $VALIDATED_ORDER);
		return false;
	}

//----------------------------------------------------------------------------//
// REMOVE AN ITEM FROM THE ORDER
//----------------------------------------------------------------------------//
	public static function remove($order_id, $ref)
	{
		$ORDER = DB::table('orders')->where('id', $order_id)->first();
		$VALIDATED_ORDER = json_decode($ORDER->val_order);

		foreach($VALIDATED_ORDER as $key => $item)
		{

			// If YES, remove it
			if($item->ref == $ref)
			{
				unset($VALIDATED_ORDER[$key]);
				$VALIDATED_ORDER = array_values($VALIDATED_ORDER);
				break;
			}
		}

		self::save_order_to_db($order_id, $VALIDATED_ORDER);
		return false;
	}

//----------------------------------------------------------------------------//
// TOGGLE ORDER TO WHOLESALE OR NOT
//----------------------------------------------------------------------------//
	public static function toggle_wholesale($order_id)
	{
		$ORDER = DB::table('orders')->where('id', $order_id)->first();

		if($ORDER->is_wholesale == 1)
		{
			DB::table('orders')
				->where('id', $order_id)
				->update(['is_wholesale' => 0]);
		}
		elseif($ORDER->is_wholesale == 0)
		{
			DB::table('orders')
				->where('id', $order_id)
				->update(['is_wholesale' => 1]);
		}

		self::save_order_to_db($order_id);
		return false;
	}

//----------------------------------------------------------------------------//
// TOGGLE ORDER TO PAYED FOR AUD$ PAYMENTS
//----------------------------------------------------------------------------//
	public static function toggle_payed($order_id)
	{
		DB::table('orders')
			->where('id', $order_id)
			->update(['is_payed' => 1]);

		//update sales
		self::update_sales($order_id);

		// send emails
		EMailGenerator::send_papi_paid_order($order_id);
		EMailGenerator::send_cust_thank_you($order_id);

		return false;
	}

//----------------------------------------------------------------------------//
// UPDATE ORDER MESSAGE
//----------------------------------------------------------------------------//
	public static function update_message($order_id, $message)
	{
		DB::table('orders')
			->where('id', $order_id)
			->update(['val_order_message' => $message]);

		return false;
	}

//----------------------------------------------------------------------------//
// UPDATE ITEM NAME
//----------------------------------------------------------------------------//
	public static function update_name($order_id, $ref, $new_name)
	{
		if(strlen($new_name) > 1)
		{
			$ORDER = DB::table('orders')->where('id', $order_id)->first();
			$VALIDATED_ORDER = json_decode($ORDER->val_order);

			// Check/Find if item is already in the basket
			foreach($VALIDATED_ORDER as $item)
			{
				// If YES, update its name
				if($item->ref == $ref)
				{
					$item->name = $new_name;
					break;
				}
			}

			DB::table('orders')
				->where('id', $order_id)
				->update([
							'val_order' => json_encode($VALIDATED_ORDER)
						]);
			// self::save_order_to_db($order_id, $VALIDATED_ORDER);
		}

		return false;
	}

//----------------------------------------------------------------------------//
// UPDATE ITEM DESCR
//----------------------------------------------------------------------------//
	public static function update_descr($order_id, $ref, $new_descr)
	{
		if(strlen($new_descr) > 1)
		{
			$ORDER = DB::table('orders')->where('id', $order_id)->first();
			$VALIDATED_ORDER = json_decode($ORDER->val_order);

			// Check/Find if item is already in the basket
			foreach($VALIDATED_ORDER as $item)
			{
				// If YES, update its name
				if($item->ref == $ref)
				{
					$item->descr = $new_descr;
					break;
				}
			}

			DB::table('orders')
				->where('id', $order_id)
				->update([
							'val_order' => json_encode($VALIDATED_ORDER)
						]);
			// self::save_order_to_db($order_id, $VALIDATED_ORDER);
		}

		return false;
	}

//----------------------------------------------------------------------------//
// SEND BACK THE JSON ORDER
//----------------------------------------------------------------------------//
	public static function validation_table_html($order_id)
	{
		$ORDER = DB::table('orders')->where('id', $order_id)->first();

		echo json_encode($ORDER, JSON_PRETTY_PRINT);
		return false;
	}

//----------------------------------------------------------------------------//
// RECOMPUTE TOTALS
//----------------------------------------------------------------------------//
	private static function recompute_totals($order_id, $VALIDATED_ORDER)
	{
		$ORDER = DB::table('orders')->where('id', $order_id)->first();

		$subtotal = 0;
		$nb_items = 0;
		$total = 0;

		foreach($VALIDATED_ORDER as $item)
		{
			$subtotal += $item->qty * $item->price;
			$nb_items += $item->qty;
		}

		if($ORDER->is_wholesale)
		{
			$total = $ORDER->val_order_shipping + 0.7 * $subtotal;
		}
		elseif(!$ORDER->is_wholesale)
		{
			$total = $ORDER->val_order_shipping + $subtotal;
		}

		return [$nb_items, $subtotal, $total];
	}


//----------------------------------------------------------------------------//
// SAVE THE VALIDATED ORDER
//----------------------------------------------------------------------------//
	public static function save_order_to_db($order_id, $VALIDATED_ORDER = 0)
	{
		if($VALIDATED_ORDER == 0)
		{
			$VALIDATED_ORDER = json_decode(
				$VALIDATED_ORDER = DB::table('orders')
					->where('id', $order_id)
					->pluck('val_order')
			);
		}

		list($nb_items, $subtotal, $total) = self::recompute_totals($order_id, $VALIDATED_ORDER);


		DB::table('orders')
			->where('id', $order_id)
			->update([
						'val_order'          => json_encode($VALIDATED_ORDER),
						'val_order_nb_items' => $nb_items,
						'val_order_subtotal' => $subtotal,
						'val_order_total'    => $total
					]);
	}

//----------------------------------------------------------------------------//
// UPDATE NUMBER ITEMS SOLD
//----------------------------------------------------------------------------//
	public static function update_sales($order_id)
	{
		$section_ref_code = Config::get('fandc_arrays')['section_ref_code'];

		$VAL_ORDER = json_decode(DB::table('orders')
			->where('id', $order_id)
			->pluck('val_order'));

		foreach($VAL_ORDER as $sold_item)
		{
			if($sold_item->ref[0] == '_')
			{
				continue;
			}
			
			$nb_sold = DB::table($section_ref_code[ $sold_item->ref[0] ])
				->where('ref', $sold_item->ref)
				->pluck('nb_sold');

			// echo $sold_item->name .': '. $nb_sold .' -> '. ($nb_sold + $sold_item->qty) .'<br>';
			DB::table($section_ref_code[ $sold_item->ref[0] ])
				->where('ref', $sold_item->ref)
				->update([
							'nb_sold' => $nb_sold + $sold_item->qty
						]);
		}

		return false;
	}
}
