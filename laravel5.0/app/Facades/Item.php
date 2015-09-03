<?php namespace FandC\Facades;


use Illuminate\Http\Request;

use Config;
use DB;

class Item
{
	private $_ref;
	private $_id;
	private $_section; // here cutlery, lighting, etc...
	private $_sectionfullname;
	private $_descr;
	private $_stamped;
	private $_name;
	private $_price;
	private $_categ; // always is an array
	private $_img_count;
	private $_is_new;
	private $_is_best_seller;
	private $_is_sold_out;

	public function __construct($ref)
	{
		$this->_ref = $ref;
		list($this->_section, $this->_id, $this->_sectionfullname) = $this->get_id($ref);

		$item_details = DB::table($this->_sectionfullname)->where('ref', $this->_ref)->first();

		switch($this->_sectionfullname)
		{
			case 'cutlery':
				$this->_descr = $item_details->descr;
				$this->_name = $item_details->name;
				$this->_price = $item_details->price;
				$this->_img_count = $item_details->img_count;
				$this->_categ = explode(', ', $item_details->categ); // here teaspoon, big-spoon, etc...
				$this->_is_new = $item_details->is_new;
				$this->_is_best_seller = $item_details->is_best_seller;
				$this->_is_sold_out = $item_details->is_sold_out;
				break;

			case 'cake-stand':
				$this->_name = $item_details->name;
				$this->_price = $item_details->price;
				$this->_img_count = $item_details->img_count;
				$this->_categ = explode(', ', $item_details->categ); // here teaspoon, big-spoon, etc...
				$this->_is_new = $item_details->is_new;
				$this->_is_best_seller = $item_details->is_best_seller;
				$this->_is_sold_out = $item_details->is_sold_out;
				break;

			// other sections here


		}


	}

	public static function get_id($ref)
	{
		$section = $ref[0];
		$id = (int) substr($ref, 1);

		$section_ref_code = Config::get('fandc_arrays')['section_ref_code'];

		$sectionfullname = $section_ref_code[$section];

		// list($item_section, $item_id, $item_sectionfullname) = array($section, $id, $sectionfullname);
		// echo $section.' '.$id.' '.$sectionfullname;

		return array($section, $id, $sectionfullname);
	}

	public static function im_ex_plode_categs($categ)
	{
		if(is_array($categ))
		{
			// return a string of categs
			return implode(', ', $categ);
		}
		if(!is_array($categ))
		{
			// return an array of categs
			return explode(', ', $categ);
		}
	}

	public function update_db_item()
	{
		switch ($this->get_sectionfullname())
		{
			case 'cutlery':
				/*echo $this->_ref.'<br>';
				echo $request->descr.'<br>';
				echo $request->stamped.'<br>';
				echo $request->price.'<br>';
				echo $request->imgs_count.'<br>';
				echo $request->categ.'<br>';*/
				// dd($request);

				DB::table('cutlery')->where('ref', $this->_ref)->update([
					'descr'          => $this->_descr,
					'stamped'        => $this->_stamped,
					'price'          => $this->_price,
					'img_count'      => 1, //$this->_img_count,
					'categ'          => $this->im_ex_plode_categs($this->_categ), // linearising into string
					'is_new'         => $this->_is_new,
					'is_best_seller' => $this->_is_best_seller,
					'is_sold_out'    => $this->_is_sold_out
				]);

				break;

			case 'cake-stand':
				DB::table('cake-stand')->where('ref', $this->_ref)->update([
					'descr'          => $request->descr,
					'name'           => $request->name,
					'price'          => $request->price,
					'img_count'      => $request->imgs_count,
					'categ'          => $request->categ,
					'is_new'         => $this->_is_new,
					'is_best_seller' => $this->_is_best_seller,
					'is_sold_out'    => $this->_is_sold_out
				]);

				break;

			// default:
			// 	# code...
			// 	break;
		}
	}

	// GETTERS & SETTERS
	public function get_ref()
	{
		return $this->_ref;
	}
	public function get_sectionfullname()
	{
		return $this->_sectionfullname;
	}

	public function get_name()
	{
		return $this->_name;
	}
	public function set_name($name)
	{
		$this->_name = $name;
	}

	public function get_descr()
	{
		return $this->_descr;
	}
	public function set_descr($descr)
	{
		$this->_descr = $descr;
	}

	public function get_stamped()
	{
		return $this->_stamped;
	}
	public function set_stamped($stamped)
	{
		$this->_stamped = $stamped;
	}

	public function get_categ()
	{
		return $this->_categ;
	}
	public function set_categ($categ)
	{
		// make sure it's an array
		if(!is_array($categ))
		{
			$this->im_ex_plode_categs($categ);
		}
		$this->_categ = $categ;
	}

	public function get_price()
	{
		return $this->_price;
	}
	public function set_price($price)
	{
		$this->_price = $price;
	}

	public function get_img_count()
	{
		return $this->_img_count;
	}
	public function set_img_count($img_count)
	{
		$this->_img_count = $img_count;
	}

	public function get_is_new()
	{
		return $this->_is_new;
	}
	public function set_is_new($is_new)
	{
		$this->_is_new = $is_new;
	}

	public function get_is_best_seller()
	{
		return $this->_is_best_seller;
	}
	public function set_is_best_seller($is_best_seller)
	{
		$this->_is_best_seller = $is_best_seller;
	}

	public function get_is_sold_out()
	{
		return $this->_is_sold_out;
	}
	public function set_is_sold_out($is_sold_out)
	{
		$this->_is_sold_out = $is_sold_out;
	}

}
