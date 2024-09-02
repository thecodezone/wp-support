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
	protected $nonce_action;
	protected $nonce_header;

	public function __construct( $nonce_action, $nonce_name = "_wpnonce", $nonce_header = "X-WP-Nonce" ) {
		$this->nonce_action = $nonce_action;
		$this->nonce_name = $nonce_name;
		$this->nonce_header = $nonce_header;
	}

    public function process( ServerRequestInterface $request, RequestHandlerInterface $handler ): ResponseInterface
    {
        $nonce = $request->getHeader( $this->nonce_header );

		if ( empty( $nonce ) ) {
			$nonce = $request->getParsedBody()[ $this->nonce_name ];
		}

		if ( empty( $nonce ) ) {
			$nonce = $request->getQueryParams()[ $this->nonce_name ];
		}

        if ( empty( $nonce ) ) {
            return ResponseFactory::make('Nonce is required.', 403 );
        }

        if ( ! wp_verify_nonce( $nonce, $this->nonce_action ) ) {
            return ResponseFactory::make( 'Invalid nonce.', 403 );
        }

        return $handler->handle( $request );
    }
}
