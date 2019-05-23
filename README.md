# Google Translate 💬 I'ts FREE 💞
Simple documentation on how to use the application to run translations using the Google Translate API.

##### Text Example:
```php
<?php
    
    require "GoogleTranslate.php";
    // If you do not set default language, it will be English (en)
    $google = new GoogleTranslate("pt");
    echo $google->translate("Hello World!"); // Olá Mundo!
?>
```

##### HTML Example:
```php
<?php
    
    require "GoogleTranslate.php";
    // If you do not set default language, it will be English (en)
    $google = new GoogleTranslate("pt");
    echo $google->translate("<p>How are you ?</p>"); // <p>Como você está?</p>
?>
```

## Contributing

1. Fork it
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Added some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create new Pull Request

## Report bugs and suggestions
* [Issue Tracker](https://github.com/douglashsilva/Symfony-Ecommerce/issues)

## Author
 * [Douglas Henrique](https://github.com/douglashsilva)