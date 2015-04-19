<?php namespace Ixudra\Translation;


use Illuminate\Support\Facades\Lang;

class LanguageHelper {

    public function get($message, $attributes = array(), $package = '')
    {
        if( Lang::has( $message ) ) {
            return Lang::get($message, $attributes);
        }

        if( $package != '' && Lang::has( $package .'::'. $message ) ) {
            return Lang::get($package .'::'. $message, $attributes);
        }

        if( Lang::has( 'translation::'. $message ) ) {
            return Lang::get( 'translation::'. $message, $attributes );
        }

        return $message;
    }

    public function has($message, $package = '')
    {
        $found = Lang::has( $message );

        if( $package != '' ) {
            $found = $found || Lang::has( $package .'::'. $message );
        }

        return  $found || Lang::has( 'translation::'. $message );
    }

}