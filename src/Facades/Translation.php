<?php namespace Ixudra\Translation\Facades;


use Illuminate\Support\Facades\Facade;

class Translation extends Facade {

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'IxdTranslation';
    }

}