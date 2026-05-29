# ResponseFactory

The `ResponseFactory` class is responsible for creating and redirecting PSR-7 HTTP responses. It utilizes the DI container to instantiate the response object.

## Basic Usage

To create a new response:

```php
use CodeZone\WPSupport\Router\ResponseFactory;

// Default 200 OK response
$response = ResponseFactory::make( 'Hello World' );

// JSON response (automatically sets Content-Type header)
$response = ResponseFactory::make( [ 'status' => 'success' ] );

// Custom status and headers
$response = ResponseFactory::make( 'Not Found', 404, [ 'X-Custom-Header' => 'Value' ] );
```

## Redirects

```php
$response = ResponseFactory::redirect( 'https://example.com' );
```

## Dependency Injection Requirement

The `ResponseFactory` retrieves the `Psr\Http\Message\ResponseInterface` from the `ContainerFactory::singleton()`. Ensure that a response implementation is registered in your container:

```php
use CodeZone\WPSupport\Container\ContainerFactory;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Response;

ContainerFactory::singleton()->add( ResponseInterface::class, function() {
    return new Response();
} );
```
