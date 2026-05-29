# Cache

The `Cache` class provides a transient-based cache implementation for WordPress, allowing you to scope your transients by a prefix.

## Usage

```php
use CodeZone\WPSupport\Cache\Cache;

$cache = new Cache( 'my_plugin' );

// Set a value for 1 hour (default)
$cache->set( 'my_key', 'some_value' );

// Set a value with custom expiration (e.g., 2 hours)
$cache->set( 'my_key', 'some_value', 2 * HOUR_IN_SECONDS );

// Get a value
$value = $cache->get( 'my_key' );

// Delete a value
$cache->delete( 'my_key' );

// Flush all transients with the 'my_plugin' prefix
$cache->flush();
```

## Scoping

All keys are automatically prefixed with `_transient_{prefix}_`. For example, with a prefix of `my_plugin` and a key of `my_key`, the actual transient name in WordPress will be `my_plugin_my_key` (WordPress adds its own `_transient_` prefix).