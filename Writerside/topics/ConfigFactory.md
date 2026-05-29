# ConfigFactory

The `ConfigFactory` functionality is managed through the `Config` and `Loader` classes.

## Configuration Loading

To load configuration from files or directories, use the `Loader` class:

```php
use CodeZone\WPSupport\Config\Config;
use CodeZone\WPSupport\Config\Loader;

$config = new Config();
$loader = new Loader( $config );

// Load a single file
$loader->load( 'path/to/config.php' );
```

For more details, see the [Config](Config.md) documentation.

## Container Integration

If you were looking for the **Container Factory**, please see the [ContainerFactory](ContainerFactory.md) documentation.
