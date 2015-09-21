<?php namespace FandC\Http\Controllers;

use FandC\Http\Requests;
use FandC\Http\Requests\StoreItemRequest;
use FandC\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Config;
use DB;
use Image;
use Input;
use Item;
use ItemQuickEditing;
use PDF;
use Redirect;
use Session;
use Validator;

class AdminItemsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		echo 'index AdminItemsController';
		// return view('admin.index');
	}

	public function all_items()
	{
		$section_list = Config::get('fandc_arrays')['section_list'];
		$cutlery_categ_list = Config::get('fandc_arrays')['cutlery_categ_list'];

		/*if(in_array($section, $section_list))
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
		}*/
		foreach($section_list as $section)
		{
			$items[$section] = DB::table($section)->get();
		}

		return view('admin.all_items', compact('items', 'section_list', 'cutlery_categ_list'));
	}

	public function all_items_pdf()
	{
		$section_list = Config::get('fandc_arrays')['section_list'];
		$cutlery_categ_list = Config::get('fandc_arrays')['cutlery_categ_list'];
		foreach($section_list as $section)
		{
			$items[$section] = DB::table($section)->get();
		}

		$pdf = PDF::loadView('admin.all_items', compact('items', 'section_list', 'cutlery_categ_list'));
		//$pdf->loadHTML('<h1>Test</h1>');
		return $pdf->stream();
	}

	public function quick_item_edit_command($command, $ref, $value=0)
	{
		$command = urldecode($command);
		$ref = urldecode($ref);
		$value = urldecode($value);

		switch ($command)
		{
			case 'TOGGLE_NEW':
				ItemQuickEditing::toggle_new($ref);
				break;

			case 'TOGGLE_BEST_SELLER':
				ItemQuickEditing::toggle_best_seller($ref);
				break;

			case 'TOGGLE_SOLD_OUT':
				ItemQuickEditing::toggle_sold_out($ref);
				break;

			case 'EDIT_NAME':
				ItemQuickEditing::edit_name($ref, $value);
				break;

			case 'EDIT_DESCR':
				ItemQuickEditing::edit_descr($ref, $value);
				break;

			case 'EDIT_CATEG':
				ItemQuickEditing::edit_categ($ref, $value);
				break;

			case 'EDIT_PRICE':
				ItemQuickEditing::edit_price($ref, $value);
				break;

			case 'DELETE_IMG':
				ItemQuickEditing::delete_img($ref, $value);
				break;
		}
	}

	public function add_item()
	{
		return view('admin.add_item');
	}

	public function post_add_item(StoreItemRequest $request)
	{
		// find new reference
		$section_ref_code = Config::get('fandc_arrays')['section_ref_code'];
		$refs = DB::table( $request->new_item_section )->lists('ref');

		for($i=1 ; in_array( $section_ref_code[ $request->new_item_section ].$i , $refs ) ; $i++)
		{
		}

		$new_ref = $section_ref_code[ $request->new_item_section ].$i;

		// upload and make images
		$imgs[] = Input::file('new_item_imgs');
		$this->_img_upload($imgs, $new_ref);

		// make new item in DB
		DB::table( $request->new_item_section )->insert([
			'ref'       => $new_ref,
			'name'      => $request->new_item_name,
			'descr'     => $request->new_item_descr,
			'price'     => $request->new_item_price,
			'img_count' => 1,
			'categ'     => Item::im_ex_plode_categs($request->new_item_categ),
			'is_new'	=> 1
		]);

		$new_item = [
			'ref'       => $new_ref,
			'name'      => $request->new_item_name,
			'descr'     => $request->new_item_descr,
			'price'     => $request->new_item_price,
			'categ'     => Item::im_ex_plode_categs($request->new_item_categ)
		];

		echo json_encode($new_item);

	}

	public function post_new_img(Request $request)
	{
		$section_ref_code = Config::get('fandc_arrays')['section_ref_code'];

		$imgs[] = Input::file('new_img');
		$this->_img_upload($imgs, $request->ref.'_'.$request->img_nb);

		DB::table( $section_ref_code[ $request->ref[0] ] )
			->where('ref', $request->ref)
			->update([
				'img_count' => $request->img_nb
			]);

		echo json_encode([
			'ref' => $request->ref,
			'img_nb' => $request->img_nb
		]);

	}

	private function _img_upload($imgs, $ref)
	{
		$imgs_count = count($imgs);

		// paths
		$img_path_original = 'pictures/'.$ref[0].'/originals';
		$img_path_500px = 'pictures/'.$ref[0].'/500px';
		$img_path_100px = 'pictures/'.$ref[0].'/100px';

		if(strpos($ref, '_') != false)
		{
			list($ref, $img_nb) = explode('_', $ref);
			$img_extension = $imgs[0]->getClientOriginalExtension();

			$img_name_original = $ref .'_original_'. $img_nb .'.'. $img_extension;
			$img_name_500px    = $ref .         '_'. $img_nb .'.'. $img_extension;
			$img_name_100px    = $ref .   '_thumb_'. $img_nb .'.'. $img_extension;

			// save original image in /originals
			$imgs[0]->move($img_path_original, $img_name_original);

			// make 500px and 100px versions
			$img = Image::make($img_path_original.'/'.$img_name_original)->resize(500, 500)->save($img_path_500px.'/'.$img_name_500px);
			$img = Image::make($img_path_original.'/'.$img_name_original)->resize(100, 100)->save($img_path_100px.'/'.$img_name_100px);
		}
		else
		{
			for($i=0 ; $i<=$imgs_count-1 ; $i++)
			{
				// filenames
				$img_extension = $imgs[$i]->getClientOriginalExtension();

				if ($i == 0)
				{
					$img_name_original = $ref.'_original.'.$img_extension;
					$img_name_500px    = $ref.         '.'.$img_extension;
					$img_name_100px    = $ref.   '_thumb.'.$img_extension;
				}
				else
				{
					$img_name_original = $ref.'_original_'.($i+1).'.'.$img_extension;
					$img_name_500px =    $ref.         '_'.($i+1).'.'.$img_extension;
					$img_name_100px =    $ref.   '_thumb_'.($i+1).'.'.$img_extension;
				}


				// save original image in /originals
				$imgs[$i]->move($img_path_original, $img_name_original);

				// make 500px and 100px versions
				$img = Image::make($img_path_original.'/'.$img_name_original)->resize(500, 500)->save($img_path_500px.'/'.$img_name_500px);
				$img = Image::make($img_path_original.'/'.$img_name_original)->resize(100, 100)->save($img_path_100px.'/'.$img_name_100px);
			}
		}

		return true;
	}

	public function recalculate_cutlery_sales()
	{
		$section_ref_code = Config::get('fandc_arrays')['section_ref_code'];

		// reinitialise nb_sold
		DB::table('cutlery')
			->update([
						'nb_sold' => 0
			]);

		// get every paid order
		$orders = DB::table('orders')
			->where('is_payed', 1)
			->lists('val_order');

		foreach($orders as $order)
		{
			$order = json_decode($order);

			// go trough all items
			foreach($order as $sold_item)
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
		}

		$sales = DB::table('cutlery')
			->select('ref', 'name', 'nb_sold')
			->orderBy('nb_sold', 'desc')
			->take(5)
			->get();

		// dd($sales);
		echo json_encode($sales);
	}

}
