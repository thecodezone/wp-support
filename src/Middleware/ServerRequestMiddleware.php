<?php

namespace CodeZone\WPSupport\Middleware;

use CodeZone\WPSupport\Router\ServerRequestFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Loads a fresh server request from globals.
 */
class ServerRequestMiddleware implements MiddlewareInterface
{
	public function process( ServerRequestInterface $request, RequestHandlerInterface $handler ): ResponseInterface
	{

		return $handler->handle( ServerRequestFactory::from_globals() );
	}
}
