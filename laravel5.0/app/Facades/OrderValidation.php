<?php namespace FandC\Facades;

use DB;
use Config;
use Item;
use Session;

class OrderValidation
{
	public function __construct($order_id)
	{
		// Session::forget('validation_order');

		// If is exists and we want to create a new oneMake validation_order in Session for easy manips.
		if(!Session::has('validation_order') OR (Session::has('validation_order') AND Session::get('validation_order')['order_id'] != $order_id))
			//isset(Session::get('validation_order')['order_id']) AND Session::get('validation_order')['order_id'] != $order_id))
		{

			$order = DB::table('orders')->where('id', $order_id)->first();

			$order_details = Basket::json_encode_decode($order->order);
			$VALIDATION_ORDER = [];

			// Add Subtotal, Nb Items, Shipping and Total rows
			$VALIDATION_ORDER['order_id']         = $order->id;
			$VALIDATION_ORDER['order_token']      = $order->order_token;
			$VALIDATION_ORDER['is_wholesale']     = $order->is_wholesale;
			$VALIDATION_ORDER['subtotal']         = $order->order_subtotal;
			$VALIDATION_ORDER['nb_items']         = $order->order_nb_items;
			$VALIDATION_ORDER['shipping']         = $order->order_shipping;
			$VALIDATION_ORDER['shipping_details'] = $order->val_order_shipping_details;
			$VALIDATION_ORDER['currency']         = $order->order_currency;
			$VALIDATION_ORDER['total']            = $order->order_total;
			$VALIDATION_ORDER['message']          = $order->val_order_message;

			$VALIDATION_ORDER = array_merge($VALIDATION_ORDER, $order_details);

			// dd($VALIDATION_ORDER);
			// Add the 'comment' for each item
			for($i=0 ; $i<=count($VALIDATION_ORDER)-11 ; $i++)
			{
				$VALIDATION_ORDER[$i]['comment'] = '';
			}

			Session::set('validation_order', $VALIDATION_ORDER);
		}

	}

//----------------------------------------------------------------------------//
// RECOMPUTE TOTALS
//----------------------------------------------------------------------------//
	private static function recompute_totals()
	{
		$VALIDATION_ORDER = Session::get('validation_order', []);

		$subtotal = 0;
		$nb_items = 0;
		$total = 0;

		for($i=0 ; $i<=count($VALIDATION_ORDER)-11 ; $i++)
		{
			$subtotal += $VALIDATION_ORDER[$i]['qty'] * $VALIDATION_ORDER[$i]['price'];
			$nb_items += $VALIDATION_ORDER[$i]['qty'];
		}

		$VALIDATION_ORDER['subtotal'] = $subtotal;
		$VALIDATION_ORDER['nb_items'] = $nb_items;

		if($VALIDATION_ORDER['is_wholesale'])
		{
			$VALIDATION_ORDER['total'] = $VALIDATION_ORDER['shipping'] + 0.7 * $subtotal;
		}
		elseif(!($VALIDATION_ORDER['is_wholesale']))
		{
			// dd($VALIDATION_ORDER);
			$VALIDATION_ORDER['total'] = $VALIDATION_ORDER['shipping'] + $subtotal;
		}


		Session::set('validation_order', $VALIDATION_ORDER);
	}

//----------------------------------------------------------------------------//
// TOGGLE ORDER CURRENCY EUR OR AUD
//----------------------------------------------------------------------------//
	public static function toggle_currency()
	{
		$VALIDATION_ORDER = Session::get('validation_order', []);

		if($VALIDATION_ORDER['currency'] == 'eur')
		{
			$VALIDATION_ORDER['currency'] = 'aud';
		}
		elseif($VALIDATION_ORDER['currency'] == 'aud')
		{
			$VALIDATION_ORDER['currency'] = 'eur';
		}

		Session::set('validation_order', $VALIDATION_ORDER);

		return false;
	}

//----------------------------------------------------------------------------//
// UPDATE ITEM QUANTITY
//----------------------------------------------------------------------------//
	public static function update_qty($ref, $new_qty)
	{
		if($new_qty == 0)
		{
			self::remove($ref);
			return;
		}

		$VALIDATION_ORDER = Session::get('validation_order', []);

		// Check/Find if item is already in the basket
		for($i=0 ; $i<=count($VALIDATION_ORDER)-11 ; $i++)
		{
			// If YES, update its qty
			if($VALIDATION_ORDER[$i]['ref'] == $ref)
			{
				$VALIDATION_ORDER[$i]['qty'] = $new_qty;
				break;
			}
		}

		Session::set('validation_order', $VALIDATION_ORDER);
		self::recompute_totals();


		return false;
	}

//----------------------------------------------------------------------------//
// UPDATE ITEM COMMENT
//----------------------------------------------------------------------------//
	public static function update_comment($ref, $comment)
	{
		if($comment == '--null')
		{
			$comment = '';
		}

		$VALIDATION_ORDER = Session::get('validation_order', []);

		// Check/Find if item is already in the basket
		for($i=0 ; $i<=count($VALIDATION_ORDER)-11 ; $i++)
		{
			// If YES, update its qty
			if($VALIDATION_ORDER[$i]['ref'] == $ref)
			{
				$VALIDATION_ORDER[$i]['comment'] = $comment;
				break;
			}
		}


		Session::set('validation_order', $VALIDATION_ORDER);
		return false;
	}

//----------------------------------------------------------------------------//
// UPDATE ITEM UNITARY PRICE
//----------------------------------------------------------------------------//
	public static function update_unit_price($ref, $unit_price)
	{
		$VALIDATION_ORDER = Session::get('validation_order', []);

		// Check/Find if item is already in the basket
		for($i=0 ; $i<=count($VALIDATION_ORDER)-11 ; $i++)
		{
			// If YES, update its qty
			if($VALIDATION_ORDER[$i]['ref'] == $ref)
			{
				$VALIDATION_ORDER[$i]['price'] = urldecode($unit_price);
				break;
			}
		}


		Session::set('validation_order', $VALIDATION_ORDER);
		self::recompute_totals();

		return false;
	}

//----------------------------------------------------------------------------//
// UPDATE ORDER SHIPPING PRICE
//----------------------------------------------------------------------------//
	public static function update_shipping($shipping)
	{
		$VALIDATION_ORDER = Session::get('validation_order', []);

		$VALIDATION_ORDER['shipping'] = urldecode($shipping);

		Session::set('validation_order', $VALIDATION_ORDER);
		self::recompute_totals();

		return false;
	}

//----------------------------------------------------------------------------//
// UPDATE ORDER SHIPPING DETAILS
//----------------------------------------------------------------------------//
	public static function update_shipping_details($shipping_details)
	{
		$VALIDATION_ORDER = Session::get('validation_order', []);

		$VALIDATION_ORDER['shipping_details'] = urldecode($shipping_details);

		Session::set('validation_order', $VALIDATION_ORDER);
		return false;
	}

//----------------------------------------------------------------------------//
// ADD A NEW ITEM TO ORDER
//----------------------------------------------------------------------------//
	public static function add($ref)
	{
		$VALIDATION_ORDER = Session::get('validation_order', []);
		$item_to_add = new Item($ref);

		// Check is already in basket

		// Add item
		$VALIDATION_ORDER[] = [
				'ref'     => $ref,
				'qty'     => 1,
				'name'    => $item_to_add->get_name(),
				'descr'   => $item_to_add->get_descr(),
				'stamped' => $item_to_add->get_stamped(),
				'price'   => $item_to_add->get_price(),
				'img'     => $item_to_add->get_img_count(),
				'categ'   => $item_to_add->get_categ(),
				'comment' => 'has been added'
			];



		Session::set('validation_order', $VALIDATION_ORDER);
		self::recompute_totals();

		return false;
	}

//----------------------------------------------------------------------------//
// ADD A CUSTOM ITEM TO THE ORDER
//----------------------------------------------------------------------------//
	public static function add_custom($value)
	{
		$VALIDATION_ORDER = Session::get('validation_order', []);
		$new_item = explode("--", $value);
		$max_custom_item = 0;

		for($i=0 ; $i<=count($VALIDATION_ORDER)-11 ; $i++)
		{
			list($custom_item_id) = sscanf($VALIDATION_ORDER[$i]['ref'], "custom%d");

			if($custom_item_id > $max_custom_item)
			{
				$max_custom_item = $custom_item_id;
			}
		}

		// Add custom item
		$VALIDATION_ORDER[] = [
				'ref'     => 'custom'.($max_custom_item + 1),
				'qty'     => 1,
				'name'    => $new_item[0],
				'descr'   => $new_item[1],
				'stamped' => '',
				'price'   => $new_item[2],
				'img'     => 0,
				'categ'   => '',
				'comment' => 'custom item'
			];

		Session::set('validation_order', $VALIDATION_ORDER);
		self::recompute_totals();

		return false;
	}

//----------------------------------------------------------------------------//
// REMOVE AN ITEM FROM THE ORDER
//----------------------------------------------------------------------------//
	public static function remove($ref)
	{
		$VALIDATION_ORDER = Session::get('validation_order', []);
		$VALIDATION_ORDER_DETAILS = array_slice($VALIDATION_ORDER, 0, 9);
		// dd($VALIDATION_ORDER);
		for($i=0 ; $i<=count($VALIDATION_ORDER)-11 ; $i++)
		{
			// If YES, remove it
			if($VALIDATION_ORDER[$i]['ref'] == $ref)
			{
				unset($VALIDATION_ORDER[$i]);
				break;
			}
		}

		$VALIDATION_ORDER = array_values(array_slice($VALIDATION_ORDER, 9));

		$VALIDATION_ORDER = array_merge($VALIDATION_ORDER_DETAILS, $VALIDATION_ORDER);

		Session::set('validation_order', $VALIDATION_ORDER);
		self::recompute_totals();

		return false;
	}

//----------------------------------------------------------------------------//
// TOGGLE ORDER TO WHOLESALE OR NOT
//----------------------------------------------------------------------------//
	public static function toggle_wholesale()
	{
		$VALIDATION_ORDER = Session::get('validation_order', []);

		if($VALIDATION_ORDER['is_wholesale'] == 1)
		{
			$VALIDATION_ORDER['is_wholesale'] = 0;
		}
		elseif($VALIDATION_ORDER['is_wholesale'] == 0)
		{
			$VALIDATION_ORDER['is_wholesale'] = 1;
		}

		Session::set('validation_order', $VALIDATION_ORDER);
		self::recompute_totals();

		return false;
	}

//----------------------------------------------------------------------------//
// UPDATE ORDER MESSAGE
//----------------------------------------------------------------------------//
	public static function update_message($message)
	{
		$VALIDATION_ORDER = Session::get('validation_order', []);

		$VALIDATION_ORDER['message'] = $message;

		Session::set('validation_order', $VALIDATION_ORDER);
		return false;
	}

//----------------------------------------------------------------------------//
// MAKE THE HTML TABLE CONTAINING THE ORDER AND DETAILS
//----------------------------------------------------------------------------//
	public static function validation_table_html()
	{
		$VALIDATION_ORDER = Session::get('validation_order', []);
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

				<td style='width: 50%;'><span class='ref-box'>{$VALIDATION_ORDER[$i]['ref']}</span> {$VALIDATION_ORDER[$i]['name']}{$VALIDATION_ORDER[$i]['stamped']} <i>{$VALIDATION_ORDER[$i]['descr']}</i><br><input class='edit-comment' type='text' name='comment-{$VALIDATION_ORDER[$i]['ref']}' placeholder='comment' value='{$VALIDATION_ORDER[$i]['comment']}'></td>\n

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

		echo $response;
	}

//----------------------------------------------------------------------------//
// SAVE THE VALIDATED ORDER
//----------------------------------------------------------------------------//
	public static function submit_validated_order($id)
	{
		$VALIDATION_ORDER = Session::get('validation_order', []);
		// echo json_encode(array_slice($VALIDATION_ORDER, 7));

		DB::table('orders')
			->where('id', $id)
			->update([
						'is_validated'               => 1,
						'is_wholesale'               => $VALIDATION_ORDER['is_wholesale'],
						'val_order'                  => json_encode(array_slice($VALIDATION_ORDER, 10)),
						'val_order_nb_items'         => $VALIDATION_ORDER['nb_items'],
						'val_order_subtotal'         => $VALIDATION_ORDER['subtotal'],
						'val_order_shipping'         => $VALIDATION_ORDER['shipping'],
						'val_order_shipping_details' => $VALIDATION_ORDER['shipping_details'],
						'val_order_currency'         => $VALIDATION_ORDER['currency'],
						'val_order_total'            => $VALIDATION_ORDER['total'],
						'val_order_message'          => $VALIDATION_ORDER['message']
					]);

	}
}
