<?php namespace FandC\Facades;

use Illuminate\Support\Facades\Facade;

class ItemQuickEditing extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'item_quick_editing';
	}
}
