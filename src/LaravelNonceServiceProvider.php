<?php namespace Vjroby\LaravelNonce;

use Illuminate\Support\ServiceProvider;

class LaravelNonceServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('vjroby/laravel-nonce','vjroby-laravel-nonce');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// TODO change the database connection from the config

		$this->app->bind('vjroby-laravel-nonce', function($app){
			return new Nonce();
		});

		$this->registerCommands();
	}

	/**
	 * Registers some utility commands with artisan
	 * @return void
	 */
	public function registerCommands()
	{
		$this->app->bind('command.vjroby-laravel-nonce.migrations', 'Vjroby\LaravelNonce\Console\MigrationsCommand');
		$this->commands('command.vjroby-laravel-nonce.migrations');

	}
	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['vjroby-laravel-nonce'];
	}

}
