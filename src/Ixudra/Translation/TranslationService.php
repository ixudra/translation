<?php namespace Ixudra\Translation;


class TranslationService {

    protected $languageHelper;


    public function __construct(LanguageHelper $languageHelper)
    {
        $this->languageHelper = $languageHelper;
    }


    public function message($message)
    {
        $components = $this->detectPackage( $message );

        return $this->translateMessage( $components[ 'message' ], $components[ 'package' ] );
    }

    public function model($message)
    {
        $components = $this->detectPackage( $message );

        return $this->translateModel( $components[ 'message' ], $components[ 'package' ] );
    }

    public function recursive($message, $attributes = array(), $ucFirst = true)
    {
        $components = $this->detectPackage( $message );

        return $this->translateRecursive($components[ 'message' ], $components[ 'package' ], $attributes, $ucFirst);
    }

    protected function detectPackage($message)
    {
        $package = '';
        if( strpos($message, '::') ) {
            $components = explode('::', $message);
            $message = $components[ 1 ];
            $package = $components[ 0 ];
        }

        return array(
            'message'           => $message,
            'package'           => $package
        );
    }

    protected function translateMessage($message, $package = '')
    {
        $pos = strpos( $message, '.' );
        $model = substr( $message, 0, $pos );

        if( $this->languageHelper->has( 'models.'. $model .'.singular', $package ) ) {
            return $this->model( $message, $package );
        }

        return $this->languageHelper->get($message, $package);
    }

    public function translateModel($message, $package = '')
    {
        $pos = strpos( $message, '.' );
        $model = substr( $message, 0, $pos );
        $key = substr( $message, $pos+1 );

        return $this->languageHelper->get( 'model.'. $key, $package, array(
                'model'         => $this->languageHelper->get( 'models.'. $model .'.singular', $package, array() ),
                'article'       => ucfirst( $this->languageHelper->get( 'models.'. $model .'.article', $package, array() ) ),
            )
        );
    }

    public function translateRecursive($message, $package = '', $attributes = array(), $ucFirst = true)
    {
        if( !$this->languageHelper->has( $message, $package ) ) {
            return $message;
        }

        $translation = $this->languageHelper->get( $message, $package );
        foreach( $attributes as $key => $value ) {
            $translation = str_replace( ':'. $key, $value, $translation );
        }

        $matches = array();
        preg_match_all('/##([a-zA-Z\.]*)##/', $translation, $matches);

        $results = array();
        foreach( $matches[1] as $match ) {
            $results[ $match ] = $this->languageHelper->get( $match, $package );
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