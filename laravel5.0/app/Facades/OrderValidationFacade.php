<?php namespace FandC\Facades;

use Illuminate\Support\Facades\Facade;

class OrderValidation extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'order_validation';
	}
}