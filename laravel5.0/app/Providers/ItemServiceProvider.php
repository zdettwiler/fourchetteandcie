<?php namespace FandC\Providers;

use Illuminate\Support\ServiceProvider;
use App;

class ItemServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		App::bind('item', function()
		{
			return new FandC\Facades\Item;
		});
	}

}
