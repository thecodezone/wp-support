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

    // @phpcs:ignore
    public function dispatch(ServerRequestInterface $request): ResponseInterface
    {
        if ( false === $this->routesPrepared ) {
            $this->prepareRoutes($request);
        }

        /** @var Dispatcher $dispatcher */
        $dispatcher = (new Dispatcher($this->routesData))->setStrategy($this->getStrategy());

        foreach ($this->getMiddlewareStack() as $middleware) {
            if (is_string($middleware)) {
                $dispatcher->lazyMiddleware($middleware);
                continue;
            }

            $dispatcher->middleware($middleware);
        }

        return $dispatcher->dispatchRequest( $request );
    }
}
