<?php namespace Ixudra\Translation;


use Illuminate\Support\Facades\Lang;

class TranslationService {

    protected $languageHelper;


    public function __construct(LanguageHelper $languageHelper)
    {
        $this->languageHelper = $languageHelper;
    }


    public function message($message)
    {
        $pos = strpos( $message, '.' );
        $model = substr( $message, 0, $pos );

        if( $this->languageHelper->has( 'models.'. $model .'.singular' ) ) {
            return $this->model( $message );
        }

        return $this->languageHelper->get( $message );
    }

    public function model($message)
    {
        $pos = strpos( $message, '.' );
        $model = substr( $message, 0, $pos );
        $key = substr( $message, $pos+1 );

        return $this->languageHelper->get( 'model.'. $key, array(
                'model'         => $this->languageHelper->get('models.'. $model .'.singular'),
                'article'       => ucfirst( $this->languageHelper->get('models.'. $model .'.article') ),
            )
        );
    }

    public function recursive($message, $attributes = array(), $ucFirst = true)
    {
        if( !$this->languageHelper->has( $message ) ) {
            return $message;
        }

        $translation = $this->languageHelper->get($message);
        foreach( $attributes as $key => $value ) {
            $translation = str_replace( ':'. $key, $value, $translation );
        }

        $matches = array();
        preg_match_all('/##([a-zA-Z\.]*)##/', $translation, $matches);

        $results = array();
        foreach( $matches[1] as $match ) {
            $results[ $match ] = $this->languageHelper->get( $match );
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