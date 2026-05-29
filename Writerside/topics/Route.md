# Route

A fluent factory for [league/route](https://route.thephpleague.com/).

it is recommended to use router along with a dependency injection container, like [league/container](https://container.thephpleague.com/).

```PHP
$container = $this->getContainer();
$route = $container->add( RouteInterface::class, function () {
    return new Route(
        $container->get( Router::class ),
        $container->get( ServerRequestInterface::class ),
        $container->get( ResponseResolverInterface::class )
    );
} );

$route
    ->middleware([
         new MyGlobalMiddleware(),
         new SomeGlobalMiddleware()
    ])
    ->file('/absolute/path/to/some/routes/file.php')
    ->rewrite('wp-rewrite-query-var')
    ->dispatch()
    ->resolve();
```

## Middleware

Pass an array of global middleware to be applied to all routes.

```PHP
$route
    ->middleware([
         new MyGlobalMiddleware(),
         new SomeGlobalMiddleware()
    ])
```

## File

Allows you to include routes from a separate routes file. 

```PHP
$route->file('/absolute/path/to/some/routes/file.php')
```

## Query-based Routing

The `rewrite()` method allows you to route requests based on a WordPress query variable. This is useful when you want to handle requests that have already been processed by WordPress's rewrite engine.

```PHP
$route
    ->rewrite('wp-rewrite-query-var')
```

This sets the `ROUTE_PARAM` attribute on the request, which the dispatcher uses to match the route.

## Dispatch

Dispatch the router to connect the route with a controller method. 

<warning>
    Dispatch may return a `League\Route\Http\Exception\NotFoundException`. You may want to handle or catch and ignore the exception depending on your implementation. 
</warning>

```PHP
$route
    ->dispatch();
```

## Resolve

Fires the response renderer. You may choose to use `CodeZone\WPSupport\Router\ResponseResolver`, which renders the PSR7 responses to basic WordPress style or JSON responses. 

```PHP
$route->resolve();
```
