<?php namespace Ixudra\Translation;


use Illuminate\Support\Facades\Lang;

class LanguageHelper {

    public function get($message, $package = '', $attributes = array(), $locale = null)
    {
        if( Lang::has( $message, $locale ) ) {
            return Lang::get($message, $attributes, $locale);
        }

        if( $package != '' && Lang::has( $package .'::'. $message, $locale ) ) {
            return Lang::get($package .'::'. $message, $attributes, $locale);
        }

        if( Lang::has( 'translation::'. $message, $locale ) ) {
            return Lang::get( 'translation::'. $message, $attributes, $locale );
        }

        return $message;
    }

    public function has($message, $package = '', $locale = null)
    {
        $found = Lang::has( $message, $locale );

        if( $package != '' ) {
            $found = $found || Lang::has( $package .'::'. $message, $locale );
        }

        return $found || Lang::has( 'translation::'. $message, $locale );
    }

}
