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
			$order = DB::table('orders')
						->where('id', $order_id)
						->pluck('order');

			DB::table('orders')
				->where('id', $order_id)
				->update(['val_order' => $order]);

			$VALIDATED_ORDER = json_decode(DB::table('orders')->where('id', $order_id)->pluck('val_order'));
			self::save_order_to_db($order_id, $VALIDATED_ORDER);
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
		$ORDER = DB::table('orders')->where('id', $order_id)->first();
		$VALIDATED_ORDER = json_decode($ORDER->val_order);

		if($new_qty == 0)
		{
			self::remove($ref);
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

		// Check is already in the order...
		foreach($VALIDATED_ORDER as $item)
		{
			// ...if yes, increment its qty
			if($item->ref == $ref)
			{
				self::update_qty($order_id, $ref, $item->qty+1);
				return false;
			}
		}

		// If not already in the order make the item
		$item_to_add = new Item($ref);

		// Add item
		$VALIDATED_ORDER[] = [
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
		$VALIDATION_ORDER[] = [
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

		foreach($VALIDATED_ORDER as $item)
		{
			// If YES, remove it
			if($item->ref == $ref)
			{
				unset($item);
				break;
			}
		}

		// $VALIDATION_ORDER = array_values(array_slice($VALIDATION_ORDER, 9));
		//
		// $VALIDATION_ORDER = array_merge($VALIDATION_ORDER_DETAILS, $VALIDATION_ORDER);

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
// MAKE THE HTML TABLE CONTAINING THE ORDER AND DETAILS
//----------------------------------------------------------------------------//
	public static function validation_table_html($order_id)
	{
		$ORDER = DB::table('orders')->where('id', $order_id)->first();

		echo json_encode($ORDER, JSON_PRETTY_PRINT);
		return false;
		/*$VALIDATION_ORDER = Session::get('validation_order', []);
		$section_ref_code = Config::get('fandc_arrays')['section_ref_code'];

		if($VALIDATION_ORDER['currency'] == 'eur')
			$currency = '&euro;';
		elseif($VALIDATION_ORDER['currency'] == 'aud')
			$currency = 'AU$';

		// is_wholesale AND TABLE HEADER
		$response = "{$VALIDATION_ORDER['is_wholesale']}{$VALIDATION_ORDER['currency']}<tr class='table-header'>
			<td></td>
			<td style='width:50%;'>Item Description</td>

			<td>Qty</td>
			<td>Unit. Price</td>
			<td>Total</td>
		</tr>\n";

		// ITEMS
		for($i=0 ; $i<=count($VALIDATION_ORDER)-11 ; $i++)
		{
			if($VALIDATION_ORDER[$i]['qty'] > 1)
			{
				$minus_button = '-';
			}
			else
			{
				$minus_button = "<img src='http://www.fourchetteandcie.com/pictures/bin.png' height='20'>";
			}

			$response .= "<tr item-ref='{$VALIDATION_ORDER[$i]['ref']}'>\n
				<td><img class='item-img' src='";

			if(substr($VALIDATION_ORDER[$i]['ref'], 0, 2) != "cu")
			{
				$response .= "http://www.fourchetteandcie.com/pictures/{$section_ref_code[ $VALIDATION_ORDER[$i]['ref'][0] ]}/100px/{$VALIDATION_ORDER[$i]['ref']}_thumb.jpg";
			}

			$response .= "' height='50'></td>\n

				<td style='width: 50%;'><span class='ref-box'>{$VALIDATION_ORDER[$i]['ref']}</span> {$VALIDATION_ORDER[$i]['name']} <i>{$VALIDATION_ORDER[$i]['descr']}</i><br><input class='edit-comment' type='text' name='comment-{$VALIDATION_ORDER[$i]['ref']}' placeholder='comment' value='{$VALIDATION_ORDER[$i]['comment']}'></td>\n

				<td><div class='item-qty'><div class='item-qty-plus-button'>+</div> <div class='item-qty-value'>{$VALIDATION_ORDER[$i]['qty']}</div> <div class='item-qty-minus-button'>{$minus_button}</div></div></td>\n

				<td class='edit-field'>". $currency ."<input class='edit-unit-price' type='text' name='unit-price-{$VALIDATION_ORDER[$i]['ref']}' value='".number_format($VALIDATION_ORDER[$i]['price'] , 2)."'></td>\n

				<td>". $currency ."".number_format($VALIDATION_ORDER[$i]['qty'] * $VALIDATION_ORDER[$i]['price'], 2)."</td>\n

			</tr>";
		}

		// SEARCH ENGINE
		$response .= "	<tr id='search-add-item'>\n
				<td colspan='5'>
					<p id='search-info'>try <i>+{space}</i>, <i>#ref</i>, <i>&#36;section</i> or <i>@category</i>.</p>
					<div id='search-container'>
						<div id='search-box'>
							<div id='search-tags'></div>
							<div style='overflow: hidden'>
								<input id='search-input' type='text' autocomplete='off' placeholder='search an item' >
							</div>
						</div>
						<div id='results-box'><table> </table></div>
					</div>
				</td>
			</tr>

			<tr id='subtotal-row'>\n
				<td colspan='4'>SUBTOTAL ({$VALIDATION_ORDER['nb_items']} item";
		// SUBTOTAL etc.
		if($VALIDATION_ORDER['nb_items'] > 1)
		{
			$response .= "s";
		}

		$response .= ")</td>\n
				<td>". $currency ."".number_format($VALIDATION_ORDER['subtotal'], 2)."</td>\n
			</tr>\n";

		if($VALIDATION_ORDER['is_wholesale'])
		{
			$response .= "	<tr id='subtotal-row'>\n
				<td colspan='4'>WHOLESALE (-30%)</td>\n
				<td>". $currency ."".number_format( 0.7 * $VALIDATION_ORDER['subtotal'], 2 )."</td>\n
			</tr>\n";
		}

		$response .= "	<tr id='shipping-row'>\n
				<td colspan='4'>SHIPPING <input class='edit-shipping-details' type='text' name='shipping-details' placeholder='shipping details' value='{$VALIDATION_ORDER['shipping_details']}'></td>\n
				<td class='edit-field'>". $currency ."<input class='edit-shipping' type='text' name='shipping' value='".number_format($VALIDATION_ORDER['shipping'], 2)."'></td>\n
			</tr>

			<tr id='total-row'>\n
				<td colspan='4'>TOTAL</td>\n
				<td>". $currency ."".number_format( $VALIDATION_ORDER['total'], 2 )."</td>\n
			</tr>

			<tr id='message-row'>\n
				<td colspan='5'>Add a message:<br><textarea>{$VALIDATION_ORDER['message']}</textarea></td>\n
			</tr>";

		echo $response;*/
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
}
