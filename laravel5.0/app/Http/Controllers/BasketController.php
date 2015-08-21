<?php namespace FandC\Http\Controllers;

use FandC\Http\Requests;
use FandC\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Basket;

class BasketController extends Controller {

	public function index()
	{
		$shipping_price = Basket::shipping_price();
		return view('basket.index')->with('shipping_price', $shipping_price);
	}

	public function checkout()
	{
		
		return false;
	}

	public function basket_command($command, $ref=0, $qty=1)
	{
		switch ($command)
		{
			case 'SHOW':
				Basket::show_basket();
				break;

			case 'EMPTY':
				Basket::empty_basket();
				Basket::make_html_basket();
				break;

			case 'ADD':
				Basket::add($ref, $qty);
				Basket::make_html_basket();
				break;

			case 'UPDATE':
				Basket::update($ref, $qty);
				Basket::make_html_basket();
				break;

			case 'REMOVE':
				Basket::remove($ref);
				Basket::make_html_basket();
				break;

			// case 'ID':
			// 	Basket::get_id($ref);
			// 	break;

			case 'HTML':
				// echo '<table>';
				Basket::make_html_basket();
				// echo '</table>';
				break;
		}
	}

}
