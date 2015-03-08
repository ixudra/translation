<?php namespace Ixudra\Translation;


use Illuminate\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider {

    protected $defer = false;


    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ .'/../../resources/lang', 'translation');
    }

    public function register()
    {
        $this->app['IxdTranslation'] = $this->app->share(
            function($app)
            {
                return new TranslationService( new LanguageHelper() );
            }
        );
    }

    public function provides()
    {
        return array('IxdTranslation');
    }

}
