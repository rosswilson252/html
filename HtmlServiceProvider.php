<?php namespace Rosswilson252\Html;

use Illuminate\Support\ServiceProvider;

class HtmlServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerHtmlBuilder();

		$this->registerFormBuilder();
        
        $this->registerTableBuilder();

		$this->app->alias('html', 'Rosswilson252\Html\HtmlBuilder');
		$this->app->alias('form', 'Rosswilson252\Html\FormBuilder');
        $this->app->alias('table', 'Rosswilson252\Html\TableBuilder');
	}

	/**
	 * Register the HTML builder instance.
	 *
	 * @return void
	 */
	protected function registerHtmlBuilder()
	{
		$this->app->bindShared('html', function($app)
		{
			return new HtmlBuilder($app['url']);
		});
	}

	/**
	 * Register the form builder instance.
	 *
	 * @return void
	 */
	protected function registerFormBuilder()
	{
		$this->app->bindShared('form', function($app)
		{
			$form = new FormBuilder($app['html'], $app['url'], $app['session.store']->getToken());

			return $form->setSessionStore($app['session.store']);
		});
	}
    
	/**
	 * Register the table builder instance.
	 *
	 * @return void
	 */
    protected function registerTableBuilder()
    {
        $this->app->bindShared('table', function($app)
		{
			return new TableBuilder($app['html']);
		});
    }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('html', 'form', 'table');
	}

}
