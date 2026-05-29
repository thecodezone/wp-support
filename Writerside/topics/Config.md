# Config

A dot.notation configuration implementation.

## Basic Usage

```php
use CodeZone\WPSupport\Config\Config;

$config = new Config( [
  'plugin' => [
    'name' => 'calculator',
    'handle' => 'my-calculator',
    'domain' => 'my_calculator'
  ]] );

$config->get('plugin.handle'); // 'my-calculator'
$config->set('plugin.url', site_url() );

$config->merge( [
  'plugin' => [
    'translations' => [
      'greeting' => 'Hello World'
    ] ] ] );

$array = $config->to_array();
```

## Config Loader

The `Loader` class allows you to load configuration from PHP files or directories.

```php
use CodeZone\WPSupport\Config\Config;
use CodeZone\WPSupport\Config\Loader;

$config = new Config();
$loader = new Loader( $config );

// Load a single file (uses filename as top-level key)
$loader->load( 'path/to/my-config.php' );

// Load all PHP files in a directory
$loader->load_dir( 'path/to/config/dir' );
```

Files should return an associative array:

```php
// path/to/my-config.php
return [
    'key' => 'value',
];
```