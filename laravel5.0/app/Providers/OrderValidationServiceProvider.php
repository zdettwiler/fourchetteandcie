<?php namespace FandC\Providers;

use Illuminate\Support\ServiceProvider;
use App;

class OrderValidationServiceProvider extends ServiceProvider {

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
		App::bind('order_validation', function()
		{
			return new FandC\Facades\OrderValidation;
		});
	}

}
