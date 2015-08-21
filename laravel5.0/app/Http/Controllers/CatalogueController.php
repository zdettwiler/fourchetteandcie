<?php namespace FandC\Http\Controllers;

use FandC\Http\Requests;
use FandC\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Config;
use DB;
use Item;
use Redirect;

class CatalogueController extends Controller {

	public function index($section='all', $ref='')
	{
		$section_list = Config::get('fandc_arrays')['section_list'];
		
		if(in_array($section, $section_list))
		{
			$items = DB::table($section)->get();
		}
		if($section == '-' AND $ref != '')
		{
			$item = new Item($ref);

			return Redirect::to('http://localhost/fourchetteandcie/public/product/'.$item->sectionfullname().'/'.$ref);
		}
		else
		{
			foreach($section_list as $section)
			{
				$items[$section] = DB::table($section)->get();
			}		
		}
		
		return view('catalogue.index', compact('items'), compact('section_list'));
	}

	public function show($ref)
	{
		$item = new Item($ref);

		echo $item->section;
		echo $item->categ;
		echo $item->ref;

		// return view('catalogue.show', compact('item') );
	}

	// public function add()
	// {
	// 	return view('catalogue.add_item');
	// }

}
