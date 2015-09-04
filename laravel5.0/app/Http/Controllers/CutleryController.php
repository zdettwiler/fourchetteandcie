<?php namespace FandC\Http\Controllers;

use FandC\Http\Requests;
use FandC\Http\Controllers\Controller;


use DB;
use Form;
use Item;
use Request;
use Session;

class CutleryController extends Controller
{

	public function index()
	{
		$items = DB::table('cutlery')
					->orderBy('is_new', 'desc')
					// ->take(10)
					->get();

		return view('cutlery.index', compact('items'));
	}

	public function look_after_cutlery()
	{
		return view('cutlery.look_after_cutlery');
	}

	public function personalised_cutlery()
	{
		return view('cutlery.personalised_cutlery');
	}
	public function post_personalised_cutlery()
	{
		$item_category_price = array(
				// Spoons
				'teaspoon' => 15,
				'big-spoon' => 15,
				'dessert-spoon' => 18,
				'baby-spoon' => 25,

				// Forks
				'big-fork' => 15,
				'dessert-fork' => 15,

				// Knives
				'knife' => 20,

				// Servers
				'serving-spoon' => 20,
				'serving-fork' => 20,
				'cake-server' => 32,
				'ladle' => 34
			);

		$BASKET = Session::get('basket', []);

		array_push($BASKET, array(
				'ref'     => 'perso',
				'qty'     => 1,
				'descr'   => 'Personalised Cutlery - <i>' . Request::input('perso-item') . '</i>',
				'stamped' => Request::input('perso-stamped'),
				'price'   => $item_category_price[Request::input('perso-item')],
				'img'     => '',
				'categ'   => Request::input('perso-item')
			));

		Session::set('basket', $BASKET);


		return view('cutlery.personalised_cutlery');
	}

	public function show_item($ref)
	{
		$item = new Item($ref);
		return view('cutlery.show_item')->with('item', $item);
	}

	public function show_categ($categ)
	{
		$all_items = DB::table('cutlery')->get();
		$in_categ_items = array();
		$big_categories = array(
				'spoons' => 'teaspoon big-spoon dessert-spoon baby-spoon',
				'forks' => 'big-fork dessert-fork',
				'servers' => 'server serving-fork serving-spoon cake-server ladle'
			);


		if( isset($big_categories[$categ]) )
		{
			for($i=0 ; $i<=count($all_items)-1 ; $i++)
			{
				$item_categs = explode(', ', $all_items[$i]->categ);

				foreach($item_categs as $item_categ)
				{
					if( strpos($big_categories[$categ], $item_categ) !== false)
					{
						$in_categ_items[] = $all_items[$i];
					}
				}
			}
		}
		else
		{
			for($i=0 ; $i<=count($all_items)-1 ; $i++)
			{
				$item_categs = explode(', ', $all_items[$i]->categ);

				if(in_array($categ, $item_categs))
				{
					$in_categ_items[] = $all_items[$i];
				}
			}
		}



		return view('cutlery.show_categ', compact('in_categ_items'));
	}


	public function edit_item($ref)
	{
		$item = DB::table('cutlery')->where('id', $ref)->first();
		// echo make_slug($item->stamped);
		return view('cutlery.edit_item', compact('item'));
	}

	public function post_edit_item($ref)
	{
		DB::table('cutlery')
			->where('id', $ref)
			->update([
						'ref' => Request::input('ref'),
						'stamped' => Request::input('stamped'),
						'descr' => Request::input('descr'),
						'categ' => Request::input('categ'),
						'price' => Request::input('price'),
					]);

		$item = DB::table('cutlery')->where('id', $ref)->first();
		return view('cutlery.edit_item', compact('item'));
	}

	public function test($categ)
	{
		$all_items = DB::table('cutlery')->get();

		for($i=0 ; $i<=count($all_items)-1 ; $i++)
		{
			// $item_categs = explode(', ', $all_items[$i]->categ);
			echo strpos($all_items[$i]->categ, '<br>');

			if( strpos($all_items[$i]->categ, 'baby spoon') !== false)
			{
				echo $string = $all_items[$i]->categ;
				echo $string = str_replace('baby spoon', 'baby-spoon', $string);

				DB::table('cutlery')->where('id', $all_items[$i]->id)->update(['categ' => $string]);
			}
		}

		// return view('cutlery.show_categ', compact('in_categ_items'));
	}
}
