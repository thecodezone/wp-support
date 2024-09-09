<?php

namespace CodeZone\WPSupport\Middleware;

use CodeZone\WPSupport\Router\ResponseFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function config;
use function response;

/**
 * Class Nonce
 *
 * This class implements the MiddlewareInterface and is responsible for processing server requests with nonce authentication.
 */
class Nonce implements MiddlewareInterface {
	protected $nonce_name;
	protected $nonce_action;
	protected $nonce_header;

    /**
     * Constructor method for the class.
     *
     * Initializes a new instance of the class, setting the nonce action,
     * nonce name, and nonce header.
     *
     * @param string $nonce_action The action name used to generate the nonce.
     * @param string $nonce_name Optional. The name of the nonce field. Default is "_wpnonce".
     * @param string $nonce_header Optional. The name of the nonce header. Default is "X-WP-Nonce".
     * @return void
     */
    public function __construct($nonce_action, $nonce_name = "_wpnonce", $nonce_header = "X-WP-Nonce" ) {
		$this->nonce_action = $nonce_action;
		$this->nonce_name = $nonce_name;
		$this->nonce_header = $nonce_header;
	}

    /**
     * Process the server request.
     *
     * @param ServerRequestInterface $request The server request object.
     * @param RequestHandlerInterface $handler The request handler object.
     *
     * @return ResponseInterface The response object.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler ): ResponseInterface
    {
        $nonce = $request->getHeader( $this->nonce_header )[0] ?? null;

        if ( !$nonce ) {
            $nonce = $this->extract_request_input( $request )[ $this->nonce_name ] ?? null;
        }

        if ( !$nonce ) {
            return ResponseFactory::make( 'Nonce is required.', 403 );
        }

        if ( ! wp_verify_nonce( $nonce, $this->nonce_action ) ) {
            return ResponseFactory::make( 'Invalid nonce.', 403 );
        }

        return $handler->handle( $request );
    }

    /**
     * Extracts the input data from the given request object.
     *
     * This method extracts the input data from the provided request object based on the request's content type and method.
     *
     * @param RequestInterface $request The request object from which to extract the input data.
     * @return array The extracted input data as an associative array.
     */
    private function extract_request_input(RequestInterface $request ): array {
        $content_type = $request->getHeaderLine( 'Content-Type' );

        if ( strpos( $content_type, 'application/json' ) !== false ) {
            // Handle JSON content type.
            $body = (string) $request->getBody();

            return json_decode( $body, true );
        } elseif ( 'GET' === $request->getMethod() ) {
            // Handle GET queries.
            return $request->getQueryParams();
        }

        // Handle other content types.
        if ( strpos( $content_type, 'application/x-www-form-urlencoded' ) !== false ) {
            $body = (string) $request->getBody();
            $data = [];
            parse_str( $body, $data );

            return $data;
        } else {
            return $request->getParsedBody();
        }
    }
}
