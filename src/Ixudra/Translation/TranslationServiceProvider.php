<?php namespace Ixudra\Translation;


use Illuminate\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider {

    protected $defer = false;


    public function boot()
    {
        $this->package('ixudra/translation');
    }

    public function register()
    {
        $this->app['IxdTranslation'] = $this->app->share(
            function($app)
            {
                return new TranslationService();
            }
        );
    }

    public function provides()
    {
        return array('IxdTranslation');
    }

}
