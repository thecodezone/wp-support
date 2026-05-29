<?php

namespace CodeZone\WPSupport\Router;

use League\Route\Router as LeagueRouter;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * This class only exists to override the dispatch method to use the custom Dispatcher class.
 */
class Router extends LeagueRouter
{

    // phpcs:ignore
    protected $routes_prepared = false;

    // phpcs:ignore
    protected $routes_data = [];

    public function dispatch( ServerRequestInterface $request ): ResponseInterface
    {
        if ( false === $this->routes_prepared ) {
            $this->prepareRoutes( $request );
        }

        /** @var Dispatcher $dispatcher */
        $dispatcher = ( new Dispatcher( $this->routes_data ) )->setStrategy( $this->getStrategy() );

        foreach ( $this->getMiddlewareStack() as $middleware ) {
            if ( is_string( $middleware ) ) {
                $dispatcher->lazyMiddleware( $middleware );
                continue;
            }

            $dispatcher->middleware( $middleware );
        }

        return $dispatcher->dispatchRequest( $request );
    }
}
