<?php namespace FandC\Facades;

use Config;
use Item;
use Session;

class Basket
{
	// var basket


	public function __construct()
	{
		Session::put('basket', array());
	}

	public static function show_basket()
	{
		return Session::get('basket', []);
	}

	public static function empty_basket()
	{
		Session::forget('basket');
	}

	public static function add($ref, $qty)
	{
		$item_to_add = new Item($ref);
		$BASKET = Session::get('basket', []);

		$found = false;

		// Check if item is already in the basket
		foreach($BASKET as $item)
		{
			// If YES, add a other one
			if( $item['ref'] == $ref)
			{
				$item['qty']++;
				$found = true;
				break;
			}
		}

		// If NO, add the item in the basket
		if(!$found)
		{
			array_push($BASKET, array(
				'ref'     => $ref,
				'qty'     => $qty,
				'name'    => $item_to_add->get_name(),
				'descr'   => $item_to_add->get_descr(),
				'stamped' => $item_to_add->get_stamped(),
				'price'   => $item_to_add->get_price(),
				'img'     => $item_to_add->get_img_count(),
				'categ'   => $item_to_add->get_categ()
			));
		}

		Session::set('basket', $BASKET);

		return false;
	}

	public static function update($ref, $new_qty)
	{
		if($new_qty == 0)
		{
			self::remove($ref);
			return;
		}

		$BASKET = Session::get('basket', []);

		// Check/Find if item is already in the basket
		for($i=0 ; $i<=count($BASKET)-1 ; $i++)
		{
			// If YES, update its qty
			if($BASKET[$i]['ref'] == $ref)
			{
				$BASKET[$i]['qty'] = $new_qty;
				break;
			}
		}


		Session::set('basket', $BASKET);

		return false;
	}

	public static function remove($ref)
	{
		$BASKET = Session::get('basket', []);

		// Check/Find if item is already in the basket
		for($i=0 ; $i<=count($BASKET)-1 ; $i++)
		{
			// If YES, add a other one
			if( $BASKET[$i]['ref'] == $ref)
			{
				unset($BASKET[$i]);
				break;
			}
		}

		$BASKET = array_values($BASKET);

		Session::set('basket', $BASKET);

		return false;
	}

	public static function make_html_basket()
	{
		$BASKET = Session::get('basket', []);
		$section_ref_code = Config::get('fandc_arrays')['section_ref_code'];


		if(count($BASKET) == 0)
		{
			echo "0<p>Your basket is empty...</p>";

			return;
		}

		else
		{
			// Count number of items in basket and subtotal
			list($nb_items_in_basket, $subtotal) = self::get_nb_items_subtotal();
			$plural = '';

			if($nb_items_in_basket > 1)
				$plural = 's';

			echo $nb_items_in_basket."\n";



			// Make basket
			foreach ($BASKET as $item)
			{
				$ref = $item['ref'];

				// echo $item['qty'].'<br>';
				// echo $item['ref'].'<br>';
				// echo $item['name'].'<br>';
				// echo $item['stamped'].'<br>';
				// echo $item['descr'].'<br>';
				// echo $item['price'].'<br>';

				if($item['qty'] > 1)
					$minus_button = '-';
				else
					$minus_button = "<img src='http://www.fourchetteandcie.com/pictures/bin.png' height='20'>";

				echo "<tr item-ref='".$item['ref']."'>\n";
				echo "	<td><img class='item-img' src='http://www.fourchetteandcie.com/pictures/". $ref[0] ."/100px/".$item['ref']."_thumb.jpg' height='50'></td>\n";
				echo "	<td style='width: 100%;'>".$item['name'].$item['stamped']."<br>";
				if (isset($item['descr']))
					{echo "<span>".$item['descr']."</span></td>\n";}

				echo "	<td><div class='item-qty'><div class='item-qty-plus-button'>+</div> <div class='item-qty-value'>".$item['qty']."</div> <div class='item-qty-minus-button'>".$minus_button."</div></div></td>\n";
				echo "	<td>&euro; ". number_format((float)$item['qty'] * $item['price'], 2, '.', '') ."</td>\n";
				echo "</tr>\n";
			}

			// Make Total Row
			echo "<tr id='subtotal-row'>\n";
			echo "	<td colspan='3'>SUBTOTAL (".$nb_items_in_basket." item". $plural .")</td>\n";
			echo "	<td>&euro; ". number_format((float)$subtotal, 2, '.', '') ."</td>\n";
			echo "</tr>\n";


		}


		return false;
	}

	public static function get_array()
	{
		return Session::get('basket');
	}

	public static function json_encode_decode($json_basket = false)
	{
		if($json_basket == false)
		{
			return json_encode(Basket::get_array());
		}
		else
		{
			return json_decode($json_basket, true);
		}
	}

	public static function shipping_price()
	{
		$shipping_price = 0;

		// Prices set by La Poste
		$shipping_categ = array(
			'class1' => 10
			);

		$cutlery_category_mass = Config::get('fandc_arrays')['cutlery_category_mass'];

		$BASKET = Session::get('basket', []);

		foreach($BASKET as $item)
		{
			$nb_categ = count($item['categ']);

			// if only 1 categ...
			if($nb_categ == 1)
			{
				// ...it's the mass category
				$shipping_price += $item['qty'] * $cutlery_category_mass[ $item['categ'][0] ] * 1;
			}

			// if 2 categs and one is pair...
			elseif($nb_categ == 2 AND in_array('pair', $item['categ']))
			{
				$pair_pos = array_search('pair', $item['categ']);

				for($i=0 ; $i<=$nb_categ-1 ; $i++)
				{
					if($i==$pair_pos)
					{
						continue;
					}

					$shipping_price += $item['qty'] * $cutlery_category_mass[ $item['categ'][$i] ] * 2;
				}
			}

			// if 3 categs and one is pair...
			elseif($nb_categ == 3 AND in_array('pair', $item['categ']))
			{
				$pair_pos = array_search('pair', $item['categ']);

				for($i=0 ; $i<=$nb_categ-1 ; $i++)
				{
					if($i==$pair_pos)
					{
						continue;
					}

					$shipping_price += $item['qty'] * $cutlery_category_mass[ $item['categ'][$i] ] * 1;
				}

			}

			// if 3+ categs and one is pair...
			elseif($nb_categ > 3 AND !in_array('pair', $item['categ']))
			{
				for($i=0 ; $i<=$nb_categ-1 ; $i++)
				{
					$mass = max($mass, $cutlery_category_mass[ $item['categ'][$i] ]);
				}

				$shipping_price += $item['qty'] * $cutlery_category_mass[$mass_categ] * 1;
			}
		}

		return $shipping_price;
	}

	public static function get_nb_items_subtotal()
	{
		$BASKET = Session::get('basket', []);
		$nb_items = 0;
		$subtotal = 0;

		foreach ($BASKET as $item)
		{
			$nb_items += $item['qty'];
			$subtotal += $item['qty'] * $item['price'];
		}

		return [$nb_items, $subtotal];
	}

	public static function get_total()
	{}
}
