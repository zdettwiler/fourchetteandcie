<?php namespace FandC\Http\Controllers;

use Basket;
use Config;
use DB;
use EMailGenerator;
use Item;
use Mail;
use FandC\Models\Order;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| All the main pages are defined here.
	|
	*/

	public function index()
	{
		// $section_list = Config::get('fandc_arrays')['section_list'];
		// $novelties = [];
		//
		// foreach($section_list as $section)
		// {
		// 	$novelties[$section] = DB::table($section)
		// 		->where('is_new', '1')
		// 		->lists('ref');
		// }

		// dd($novelties);
		// return view('home.home', compact('novelties'));
		return view('home.home');
	}

	public function about_us()
	{
		return view('home.about-us');
	}

	public function furniture()
	{
		return view('home.furniture');
	}

	public function lighting()
	{
		return view('home.lighting');
	}

	public function bric_a_brac()
	{
		return view('home.bric-a-brac');
	}

	public function emails()
	{
		echo EMailGenerator::send_papi_new_order(3);
		echo EMailGenerator::send_cust_placed_order(3);
		echo EMailGenerator::send_cust_validated_order(3);
		echo EMailGenerator::send_papi_payed_order(3);
		echo EMailGenerator::send_cust_thank_you(3);

	}

	public function search()
	{
		return view('admin.search');
	}

	public function search_query($query, $nb_results=10)
	{
		$section_ref_code = Config::get('fandc_arrays')['section_ref_code'];
		$tag_keys = ['#', '@', '$'];
		$query = urldecode($query);
		$query = explode('|', $query);

		$ref = '%%';
		$categ = '';
		$section = 'cutlery';
		$keywords = '';

		foreach($query as $tag)
		{
			if(isset($tag[0]) AND in_array($tag[0], $tag_keys))
			{
				switch($tag[0])
				{
					case '#':
						$ref = substr($tag, 1);
						if(isset($section_ref_code[ $tag[1] ]))
						{
							$section = $section_ref_code[ $tag[1] ];
						}
						break;

					case '@':
						$categ = substr($tag, 1);
						break;

					case '$':
						$section = substr($tag, 1);
						break;
				}
			}
			else
			{
				$keywords = $tag;
			}
		}

		$results = DB::table($section)
						->where('name', 'LIKE', '%'.$keywords.'%')
						->where('categ', 'LIKE', '%'.$categ.'%')
						->where('ref', 'LIKE', $ref)
						->take($nb_results)
						->get();

		echo json_encode($results);
	}


}
