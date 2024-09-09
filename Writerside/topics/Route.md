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

## Rewrite

Connect the routes to the WordPress rewrite engine. Takes a WP query var name.

<tip>
See <a href="https://developer.wordpress.org/reference/functions/get_query_var/">get_query_var</a>.
</tip>

<tip>
See <a href="https://developer.wordpress.org/reference/functions/add_rewrite_rule/">add_rewrite_rule</a>.
</tip>

```PHP
$route
    ->rewrite('wp-rewrite-query-var')
```

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
