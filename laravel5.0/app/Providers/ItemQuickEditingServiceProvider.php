<?php namespace FandC\Providers;

use Illuminate\Support\ServiceProvider;
use App;

class ItemQuickEditingServiceProvider extends ServiceProvider {

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
		App::bind('item_quick_editing', function()
		{
			return new \FandC\Facades\ItemQuickEditing;
		});
	}

}
