<?php namespace FandC\Providers;

use Illuminate\Support\ServiceProvider;
use App;

class EMailGeneratorServiceProvider extends ServiceProvider {

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
		App::bind('email_generator', function()
		{
			return new FandC\Facades\EMailGenerator;
		});
	}

}
