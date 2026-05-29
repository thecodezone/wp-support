# ProviderFactory

The `ProviderFactory` helps manage the loading and initialization of service providers within your container.

## Usage

```php
use CodeZone\WPSupport\Container\ContainerFactory;
use CodeZone\WPSupport\Container\ProviderFactory;

$container = ContainerFactory::singleton();
$factory = new ProviderFactory( $container );

// Load a single provider
$factory->load( MyServiceProvider::class );

// Load multiple providers
$factory->load_many( [
    MyServiceProvider::class,
    AnotherServiceProvider::class,
] );
```

## Bootable Service Providers

If your service provider implements `League\Container\ServiceProvider\BootableServiceProviderInterface`, the `ProviderFactory` will automatically call the `boot()` method when loading it.
