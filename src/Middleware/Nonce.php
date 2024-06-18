<?php

namespace CodeZone\WPSupport\Middleware;

use CodeZone\WPSupport\Router\ResponseFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function config;
use function Middleware\get_query_var;
use function Middleware\wp_verify_nonce;
use function response;

class Nonce implements MiddlewareInterface {
	protected $nonce_name;

	public function __construct( $nonce_name = "_wpnonce" ) {
		$this->nonce_name = $nonce_name;
	}

    public function process( ServerRequestInterface $request, RequestHandlerInterface $handler ): ResponseInterface
    {
        $nonce = $request->getHeader( 'X-WP-Nonce' ) ?? get_query_var( '_wpnonce' );

        if ( empty( $nonce ) ) {
            return ResponseFactory::make('Nonce is required.', 403 );
        }

        if ( ! wp_verify_nonce( $nonce, $this->nonce_name ) ) {
            return ResponseFactory::make( 'Invalid nonce.', 403 );
        }

        return $handler->handle( $request );
    }
}
