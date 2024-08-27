<?php

namespace CodeZone\WPSupport\Router;

use League\Route\Dispatcher as LeagueDispatcher;
use Psr\Http\Message\ResponseInterface;
use FastRoute\Dispatcher as FastRoute;
use Psr\Http\Message\ServerRequestInterface;


class Dispatcher extends LeagueDispatcher
{

    /**
     * The difference between this and the stock dispatcher is that
     * we're checking for a "route_query" param to find a rewrite-based route.
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function dispatchRequest( ServerRequestInterface $request ): ResponseInterface
    {
        $method = $request->getMethod();
        $uri = $request->getUri()->getPath();

        //If we're using a query var to determine the route
        $route_query_var = $request->getAttribute('ROUTE_PARAM');

        if ($route_query_var) {
            $path = get_query_var($route_query_var);
            $uri = '/' . \trim($path, '/');
        }
        $match = $this->dispatch($method, $uri);

        switch ($match[0]) {
            case FastRoute::NOT_FOUND:
                $this->setNotFoundDecoratorMiddleware();
                break;
            case FastRoute::METHOD_NOT_ALLOWED:
                $allowed = (array) $match[1];
                $this->setMethodNotAllowedDecoratorMiddleware($allowed);
                break;
            case FastRoute::FOUND:
                $route = $this->ensureHandlerIsRoute($match[1], $method, $uri)->setVars( $match[2] );

                if ($this->isExtraConditionMatch( $route, $request )) {
                    $this->setFoundMiddleware( $route );
                    $request = $this->requestWithRouteAttributes( $request, $route );
                    break;
                }

                $this->setNotFoundDecoratorMiddleware();
                break;
        }

        return $this->handle($request);
    }
}
