# Options

The `Options` class simplifies working with the WordPress options API by providing scoping and default values.

## Usage

```php
use CodeZone\WPSupport\Options\Options;

$defaults = [
    'background_color' => 'blue',
    'font_size'        => '16px',
];
$prefix = 'my_plugin';

$options = new Options( $defaults, $prefix );

// Get an option (returns 'blue' if not set in DB)
$color = $options->get( 'background_color' );

// Set an option (will be stored as 'my_plugin_background_color')
$options->set( 'background_color', 'red' );
```

## Scoping

By default, all keys are prefixed with the `$prefix` provided in the constructor. You can bypass scoping by passing `false` to the `$scoped` parameter:

```php
$options->get( 'some_global_option', null, false, false );
$options->set( 'some_global_option', 'value', false );
```

## Required Options

You can mark an option as required. If it's not found in the database, it will be initialized with the default value:

```php
$options->get( 'background_color', null, true );
```
