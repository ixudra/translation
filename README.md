ixudra/translation
=====================

Custom PHP translation library for the Laravel 5 framework - developed by [Ixudra](http://ixudra.be).

This package can be used by anyone at any given time, but keep in mind that it is optimized for my personal custom workflow. It may not suit your project perfectly and modifications may be in order.




## Why use this package?

The Laravel internationalization system is an amazing feature that makes translating messages in different languages incredibly easy. Unfortunately, I found that it has one big downside: since a lot of error messages (particularly with regards to model validation) are very similar, it encourages duplication in language files. This is particularly frustrating when adding a new language to your application. This package attempts to address that issue by applying a well-known programming construct: recursion.

This package provides functionality to include placeholder values in your translation messages that will be identified, translated and replaced at runtime. This makes the Laravel translation system more dynamic and reduces overall duplication in language files.




## Installation

Pull this package in through Composer.

```js

    {
        "require": {
            "ixudra/translation": "5.*"
        }
    }

```

> If you want to use this package with Laravel 4, change the above line to `"ixudra/translation": "1.*"` instead.

Add the service provider to your app.php file

```php

    'providers'       => array(

        //...
        Ixudra\Translation\TranslationServiceProvider::class,

    ),

```

Add the facade to your app.php file

```php

    'facades'       => array(

        //...
        'Translate'       => Ixudra\Translation\Facades\Translation::class,

    ),

```




## Usage

Once included, the package can easily be used in any Laravel application. In order to translate a message, simply use the facade and pass in the key to the translation value which is stored in your language files:

```php

    Translate::message('your.key.goes.here');

```

The package will automatically scan language files both your application and the package itself to find a match for this key. It is important to know that the package will give priority to application keys to allow the user to specify custom message instead of those provided by the package. If no value can be found for the provided key, the package will simply return the key itself, just as the Laravel `Lang` facade would.

The package also supports parameters that can be passed on to the translator, as you would using the Laravel `Lang` facade:

```php

    Translate::message('your.key.goes.here', array('foo' => 'bar'));

```



### Translating models

Since translation messages are commonly used for models, this package provides a specific method to make this even more easier:

```php

    Translate::model('user.create.success');

```

When this method gets called, the package will:

- look for the translation for the `user` model in the `lang/models.php` file
- look for the translation for the `create.success` key in the `lang/model.php` file
- translate the `create.success` message with the translated `user` model value as parameter.

The result of this interaction is (by default): `The user has been created successfully.`



### Recursive translations

Recursive translations work similar to the other methods mentioned above. Upon finding the translation key, the package will then scan the value for recursion identifiers that need to be translated. These are highlighted by adding `##` to the front and back of the translation key (e.g. `##common.submit##`).

For example, see the following values in the `lang/admin.php` file that you can find in the package:

```php

    <?php

        return array(

            'menu.title.index'                  => '##models.:model.plural##',
            'menu.title.new'                    => 'New ##models.:model.singular##',
            'menu.title.edit'                   => 'Edit ##models.:model.singular##',

        );
     
```

These values can be translated using the `recursive` method, passing the in `model` parameter as you would using the Laravel `Lang` facade:

```php

    Translate::recursive('admin.menu.title.new', array('model' => 'user'));

```

When this method gets called, the package will:

- look for the translation for the `menu.title.new` key in the `lang/admin.php` file
- replace all parameters in the translation value
- scan the message for recursion keys and find `##models.user.singular##`
- look for the translation for the `user.singular` key in the `lang/models.php` file
- replace the recursion key with the correct translation
- return the translated result to the application

The result of this interaction will be (by default): `New user`.

You can include as many recursion identifiers as you want in one translation value. It is important to note however that the recursion is currently limited to one level. This feature will be added in the near future.




## Publishing the language files

The package has several language files that contain translations that can be used in your code. These translations can be used out of the box, but can also be modified if they don't match your needs. In order to modify these, you will have to publish the config file using artisan:

```php

    // Publish all resources from all packages
    php artisan vendor:publish

    // Publish only the resources of the package
    php artisan vendor:publish --provider="Ixudra\\Translation\\TranslationServiceProvider"

```

That's all there is to it! Have fun!
