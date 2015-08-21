<?php namespace FandC\Facades;

use Illuminate\Support\Facades\Facade;

class EMailGenerator extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'email_generator';
	}
}
