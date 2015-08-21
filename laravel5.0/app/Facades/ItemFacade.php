<?php namespace FandC\Facades;

use Illuminate\Support\Facades\Facade;

class Item extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'item';
	}
}