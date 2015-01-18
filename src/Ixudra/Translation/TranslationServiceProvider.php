<?php namespace Ixudra\Translation;


use Illuminate\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider {

    protected $defer = false;


    public function boot()
    {
        $this->loadTranslationsFrom('translation', $this->app->basePath(). '/vendor/ixudra/translation/src/resources/lang');
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
