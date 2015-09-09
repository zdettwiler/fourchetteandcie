<?php namespace FandC\Http\Controllers;

use FandC\Http\Requests;
use FandC\Http\Controllers\Controller;
use FandC\Models\User;

use Illuminate\Http\Request;

use Auth;
use Config;
use DB;
use Input;
use Redirect;
use Hash;

class AdminController extends Controller
{
	// public function __construct()
	// {
	// 	$this->middleware('auth');
	// }

	public function index()
	{
		$section_list = Config::get('fandc_arrays')['section_list'];
		$nb_new_items = 0;
		$nb_best_seller_items = 0;
		$nb_sold_out_items = 0;
		$nb_items = 0;

		// Orders widget
		$nb_not_val_orders = DB::table('orders')
			->where('is_validated', '0')
			->count();
		$nb_val_orders = DB::table('orders')
			->where('is_validated', '1')
			->where('is_payed', '0')
			->count();
		$nb_payed_orders = DB::table('orders')
			->where('is_payed', '1')
			->count();
		$nb_orders = DB::table('orders')
			->count();

		// Items widget
		foreach($section_list as $section)
		{
			$nb_new_items += DB::table($section)
				->where('is_new', '1')
				->count();
			$nb_best_seller_items += DB::table($section)
				->where('is_best_seller', '1')
				->count();
			$nb_sold_out_items += DB::table($section)
				->where('is_sold_out', '1')
				->count();
			$nb_items += DB::table($section)
				->count();
		}

		// Sales widget
		$sales = DB::table('cutlery')
			->select('ref', 'name', 'nb_sold')
			->orderBy('nb_sold', 'desc')
			->take(5)
			->get();

		// dd($sales);

		return view('admin.index', compact('nb_not_val_orders', 'nb_val_orders', 'nb_payed_orders', 'nb_orders', 'nb_new', 'nb_best_seller', 'nb_sold_out', 'nb_new_items', 'nb_best_seller_items', 'nb_sold_out_items', 'nb_items', 'sales'));
	}

	public function login()
	{
		// $user = User::find(1);
		//
	    // echo ' Before Save: ' . $user->getAuthPassword();
		//
	    // $user->password = Hash::make('1234');
	    // $user->save();
		//
	    // echo ' After Save: ' . $user->getAuthPassword();
	    // dd($user);

		return view('admin.login');
	}

	public function post_login()
	{
		$username = Input::get('username');
		$password = Input::get('password');

		if (Auth::attempt(['username' => $username, 'password' => $password]))
		{
			return Redirect::intended('/admin');
		}

		return Redirect::back()
			->withInput()
			->withErrors('That username/password combo does not exist.');
	}

}
