<?php namespace Ixudra\Translation;


class TranslationService {

    protected $languageHelper;


    public function __construct(LanguageHelper $languageHelper)
    {
        $this->languageHelper = $languageHelper;
    }


    public function message($message, $package = '')
    {
        $pos = strpos( $message, '.' );
        $model = substr( $message, 0, $pos );

        if( $this->languageHelper->has( 'models.'. $model .'.singular', $package ) ) {
            return $this->model( $message, $package );
        }

        return $this->languageHelper->get( $message, $package );
    }

    public function model($message, $package = '')
    {
        $pos = strpos( $message, '.' );
        $model = substr( $message, 0, $pos );
        $key = substr( $message, $pos+1 );

        return $this->languageHelper->get( 'model.'. $key, array(
                'model'         => $this->languageHelper->get('models.'. $model .'.singular', $package),
                'article'       => ucfirst( $this->languageHelper->get('models.'. $model .'.article', $package) ),
            ), $package
        );
    }

    public function recursive($message, $attributes = array(), $package = '', $ucFirst = true)
    {
        if( !$this->languageHelper->has( $message, $package ) ) {
            return $message;
        }

        $translation = $this->languageHelper->get( $message, array(), $package );
        foreach( $attributes as $key => $value ) {
            $translation = str_replace( ':'. $key, $value, $translation );
        }

        $matches = array();
        preg_match_all('/##([a-zA-Z\.]*)##/', $translation, $matches);

        $results = array();
        foreach( $matches[1] as $match ) {
            $results[ $match ] = $this->languageHelper->get( $match, array(), $package );
        }

        foreach( $results as $key => $value ) {
            $translation = str_replace( '##'. $key .'##', $value, $translation );
        }

        if( $ucFirst ) {
            $translation = ucfirst( $translation );
        }

        return $translation;
    }

}