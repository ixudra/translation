<?php namespace Ixudra\Translation;


class TranslationService {

    protected $languageHelper;


    public function __construct(LanguageHelper $languageHelper)
    {
        $this->languageHelper = $languageHelper;
    }


    public function message($message, $locale = null)
    {
        $components = $this->detectPackage( $message );

        return $this->translateMessage( $components[ 'message' ], $components[ 'package' ], $locale );
    }

    public function model($message, $locale = null)
    {
        $components = $this->detectPackage( $message );

        return $this->translateModel( $components[ 'message' ], $components[ 'package' ], $locale );
    }

    public function recursive($message, $attributes = array(), $ucFirst = true, $locale = null)
    {
        $components = $this->detectPackage( $message );

        return $this->translateRecursive($components[ 'message' ], $components[ 'package' ], $attributes, $ucFirst, $locale);
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

    protected function translateMessage($message, $package = '', $locale = null)
    {
        $pos = strpos( $message, '.' );
        $model = substr( $message, 0, $pos );

        if( $this->languageHelper->has( 'models.'. $model .'.singular', $package, $locale ) ) {
            return $this->model( $message, $locale );
        }

        return $this->languageHelper->get($message, $package, array(), $locale);
    }

    public function translateModel($message, $package = '', $locale = null)
    {
        $pos = strpos( $message, '.' );
        $model = substr( $message, 0, $pos );
        $key = substr( $message, $pos+1 );

        return $this->languageHelper->get( 'model.'. $key, $package, array(
                'model'         => $this->languageHelper->get( 'models.'. $model .'.singular', $package, array(), $locale ),
                'article'       => ucfirst( $this->languageHelper->get( 'models.'. $model .'.article', $package, array(), $locale ) ),
            ), $locale
        );
    }

    public function translateRecursive($message, $package = '', $attributes = array(), $ucFirst = true, $locale = '')
    {
        if( !$this->languageHelper->has( $message, $package, $locale ) ) {
            return $message;
        }

        $translation = $this->languageHelper->get( $message, $package, array(), $locale );
        foreach( $attributes as $key => $value ) {
            $translation = str_replace( ':'. $key, $value, $translation );
        }

        $matches = array();
        preg_match_all('/##([a-zA-Z\_\.]*)##/', $translation, $matches);

        $results = array();
        foreach( $matches[1] as $match ) {
            $results[ $match ] = $this->languageHelper->get( $match, $package, array(), $locale );
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
