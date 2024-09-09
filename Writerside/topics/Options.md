# Options

Simplifies working with the WordPress options API. Eliminates the need to check if options are created before using update option. Scopes option keys by a prefix.  

```php
$options = new Options( $defaults, $prefix );
$options->set( "background_color", "red" );
$color = $options->get( "background_color" );
```
