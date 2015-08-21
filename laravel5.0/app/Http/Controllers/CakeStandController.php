<?php namespace FandC\Http\Controllers;

use FandC\Http\Requests;
use FandC\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DB;

class CakeStandController extends Controller
{

	public function index()
	{
		$items = DB::table('cake-stand')->get();
		
		return view('cake-stand.index', compact('items'));
	}

}
