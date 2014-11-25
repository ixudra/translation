<?php namespace Ixudra\Translation;


use Illuminate\Support\Facades\Lang;

class LanguageHelper {

    public function get($message, $attributes = array())
    {
        if( Lang::has( $message ) ) {
            return Lang::get($message, $attributes);
        }

        if( Lang::has( 'translation::'. $message ) ) {
            return Lang::get( 'translation::'. $message, $attributes );
        }

        return $message;
    }

    public function has($message)
    {
        return Lang::has( $message ) || Lang::has( 'translation::'. $message );
    }

}