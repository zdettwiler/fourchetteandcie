<?php namespace FandC\Http\Controllers;

use FandC\Http\Requests;
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
				ItemQuickEditing::updated_item_html($ref);
				break;

			case 'TOGGLE_BEST_SELLER':
				ItemQuickEditing::toggle_best_seller($ref);
				ItemQuickEditing::updated_item_html($ref);
				break;

			case 'TOGGLE_SOLD_OUT':
				ItemQuickEditing::toggle_sold_out($ref);
				ItemQuickEditing::updated_item_html($ref);
				break;

			case 'EDIT_STAMPED':
				ItemQuickEditing::edit_stamped($ref, $value);
				ItemQuickEditing::updated_item_html($ref);
				break;

			case 'EDIT_DESCR':
				ItemQuickEditing::edit_descr($ref, $value);
				ItemQuickEditing::updated_item_html($ref);
				break;

			// case 'EDIT_CATEG':
			// 	ItemQuickEditing::edit_stamped($ref, $value);
			// 	ItemQuickEditing::updated_item_html($ref);
			// 	break;

			case 'EDIT_PRICE':
				ItemQuickEditing::edit_price($ref, $value);
				ItemQuickEditing::updated_item_html($ref);
				break;
		}
	}

	public function edit_item($ref)
	{
		$item = new Item($ref);
		$section = $item->get_sectionfullname();

		return view('admin.edit_item.edit_'.$section)->with('item', $item);
	}

	public function post_edit_item(Request $request, $ref)
	{
		$item = new Item($ref);

		// MAKE RIGHT VALIDATOR FOR RIGHT SECTION
		$validator = $this->_make_validator_section($request, $item->get_sectionfullname());

		$imgs_count = count($request->imgs);

		// VALIDATE FORM
		if ($validator->fails())
		{
			echo 'Failed Validator<br>';
			$messages = $validator->messages();

			return redirect()->back()->with('notification', ['type' => 'negative', 'message' => $messages->all()]);
		}
		// dd($request->file('imgs'));
		if(!is_null($request->file('imgs')[0]))
		{
			foreach ($request->file('imgs') as $img)
			{
				$validator_img = Validator::make(
					[
						'img' => $img
					],
					[
						'img' => 'image|mimes:jpeg,bmp,png|max:5000'
					]
				);

				if ($validator_img->fails() OR !$img->isValid())
				{
					$messages = $validator->messages();
					return redirect()->back()->with('notification', ['type' => 'negative', 'message' => $img->getClientOriginalName().' has a problem.']);
				}
			}
			$this->_img_upload($request->file('imgs'), $ref);
		}


		// FORM IS OK - SAVE IMGS AND ADD NEW ITEM IN DB
		if ($validator->passes())
		{


			// make category string
			$categ = $item->im_ex_plode_categs($request->categs);

			// ADD ITEM TO DATABASE

			$item->set_descr($request->descr);
			$item->set_stamped($request->stamped);
			$item->set_price($request->price);
			// $item->set_img_count($request->img_count);
			$item->set_categ($request->categs);

			$item->update_db_item();

			// END SWITCH ADD TO DB

			return redirect()->back()->with('notification', ['type' => 'positive', 'message' => 'Item '.$new_ref.' has been successfully added to the database!']);
		}
		// END IF FORM OK
	}
	// END METHOD post_edit_item()

	public function add_item()
	{
		return view('admin.add_item_2');
	}

	public function post_add_item(Request $request)
	{
		// dd($request);
		$section = $request->section;
		$imgs = Input::file('img_'.$section);

		// GET REF OF NEW ITEM
		$section_ref_code = Config::get('fandc_arrays')['section_ref_code'];
		$refs = DB::table( $section )->lists('ref');

		// for($i=1 ; in_array( $section_ref_code[ $section ].$i , $refs ) ; $i++)
		// {
		// }

		$i = 1;

		while( in_array( $section_ref_code[ $section ].$i , $refs ) )
		{
			$i++;
		}

		$new_ref = $section_ref_code[ $section ].$i;

		// MAKE RIGHT VALIDATOR FOR RIGHT SECTION
		$validator = $this->_make_validator_section($request, $section);

		$imgs_count = count($imgs);

		// VALIDATE FORM
		if ($validator->fails())
		{
			echo 'Failed Validator<br>';
			$messages = $validator->messages();

			return redirect()->back()->with('notification', ['type' => 'negative', 'message' => $messages->all()]);
		}
		foreach ($imgs as $img)
		{
			$validator_img = Validator::make(
				[
					'img' => $img
				],
				[
					'img' => 'required|image|mimes:jpg,jpeg,bmp,png|max:5000'
				]
			);

			if ($validator_img->fails() OR !$img->isValid())
			{
				$messages = $validator->messages();
				return redirect()->back()->with('notification', ['type' => 'negative', 'message' => $img->getClientOriginalName().' has a problem.<br>'. $messages->all()]);
			}
		}

		// FORM IS OK - SAVE IMGS AND ADD NEW ITEM IN DB
		if ($validator->passes())
		{
			$this->_img_upload($imgs, $new_ref);

			// make category string
			$categ = Item::im_ex_plode_categs($request->categs_cutlery);

			// ADD ITEM TO DATABASE
			switch ($section)
			{
				case 'cutlery':
					DB::table('cutlery')->insert([
						'ref'       => $new_ref,
						'descr'     => $request->descr_cutlery,
						'stamped'   => $request->stamped_cutlery,
						'price'     => $request->price_cutlery,
						'img_count' => $imgs_count,
						'categ'     => $categ
					]);

					break;

				case 'cake-stand':
					DB::table('cake-stand')->insert([
						'ref'       => $new_ref,
						'name'      => $name,
						'price'     => $price,
						'img_count' => $imgs_count,
						'categ'     => $categ
					]);

					break;

				case 'key-holder':
					DB::table('cake-stand')->insert([
						'ref'       => $new_ref,
						'name'      => $name,
						'price'     => $price,
						'img_count' => $imgs_count,
						'categ'     => $categ
					]);

				// default:
				// 	# code...
				// 	break;
			}
			// END SWITCH ADD TO DB

			return redirect()->back()->with('notification', ['type' => 'positive', 'message' => 'Item '.$new_ref.' has been successfully added to the database!']);
		}
		// END IF FORM OK
	}
	// END METHOD post_add_item()

	private function _img_upload($imgs, $ref)
	{
		$imgs_count = count($imgs);
		list($section, $id, $sectionfullname) = Item::get_id($ref);

		// paths
		$img_path_original = 'pictures/'.$ref[0].'/originals';
		$img_path_500px = 'pictures/'.$ref[0].'/500px';
		$img_path_100px = 'pictures/'.$ref[0].'/100px';

		for($i=0 ; $i<=$imgs_count-1 ; $i++)
		{
			// filenames
			$img_extension = $imgs[$i]->getClientOriginalExtension();

			if ($i == 0)
			{
				$img_name_original = $ref.'_original.'.$img_extension;
				$img_name_500px =    $ref.         '.'.$img_extension;
				$img_name_100px =    $ref.   '_thumb.'.$img_extension;
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

		return true;
	}

	private function _make_validator_section(Request $request, $section)
	{
		switch($section)
		{

		//----- CUTLERY ------------------------------
			case 'cutlery':
				// vars for cutlery
				$categs = $request->categs_cutlery;
				$stamped = $request->stamped_cutlery;
				$descr = $request->descr_cutlery;
				$price = $request->price_cutlery;
				// $imgs = $request->file('img');
				// dd($request);

				// validator for cutlery
				$validator = Validator::make(
					[
						'section' => $section,
						'categs'   => $categs,
						'stamped' => $stamped,
						'descr'   => $descr,
						'price'   => $price
					],
					[
						'section' => 'required|in:cutlery,cake-stand', // include more
						'categs'   => 'required',
						'stamped' => 'required',
						'descr'   => 'required',
						'price'   => 'required|numeric'
					]
				);
			break;

		//----- CAKE STAND ---------------------------
			case 'cake-stand':
				$categs = $request->categs;
				$name = $request->name;
				$price = $request->price;
				$imgs = $request->file('img');

				// validator for cake-stand
				$validator = Validator::make(
					[
						'section' => $section,
						'categs' => $categs,
						'name' => $name,
						'price' => $price
					],
					[
						'section' => 'required|in:cutlery,cake-stand', // include more also silly since switch of this
						'categs' => 'required',
						'name' => 'required',
						'price' => 'required|numeric'
					]
				);
			break;

			default:
				return $request->section;
				break;

		//----- BRIC-A-BRAC --------------------------
		//----- FURNITURE ----------------------------
		//----- LUMINAIRE ----------------------------

		}

		return $validator;
	}
}
