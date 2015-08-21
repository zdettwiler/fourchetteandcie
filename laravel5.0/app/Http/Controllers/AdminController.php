<?php namespace FandC\Http\Controllers;

use FandC\Http\Requests;
use FandC\Http\Controllers\Controller;
use FandC\Models\User;

use Illuminate\Http\Request;

use Auth;
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
		$nb_not_val_orders = DB::table('orders')
			->where('is_validated', '0')
			->count();
		$nb_orders = DB::table('orders')
			->count();

		$nb_new = DB::table('cutlery')
			->where('is_new', '1')
			->count();
		$nb_best_seller = DB::table('cutlery')
			->where('is_best_seller', '1')
			->count();
		$nb_sold_out = DB::table('cutlery')
			->where('is_sold_out', '1')
			->count();

		return view('admin.index', compact('nb_not_val_orders', 'nb_orders', 'nb_new', 'nb_best_seller', 'nb_sold_out'));
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
