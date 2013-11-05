<?php namespace Lukaswhite\Jst;

use Illuminate\Support\ServiceProvider;

class JstServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{		
		$this->registerGenerate();
		$this->registerWatch();

		$this->registerCommands();
	}

	/**
	 * Register jst.generate
	 *
	 * @return Lukaswhite\Jst\JstGenerateCommand
	 */
	protected function registerGenerate()
	{
		$this->app['jst.generate'] = $this->app->share(function($app)
		{	
			return new JstGenerateCommand();
		});
	}

	/**
	 * Register jst.watch
	 *
	 * @return Lukaswhite\Jst\JstWatchCommand
	 */
	protected function registerWatch()
	{
		$this->app['jst.watch'] = $this->app->share(function($app)
		{	
			return new JstWatchCommand();
		});
	}

	/**
	 * Make commands visible to Artisan
	 *
	 * @return void
	 */
	protected function registerCommands()
	{
		$this->commands(
			'jst.generate',
			'jst.watch'
		);
	}

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('lukaswhite/jst');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}