<?php

namespace CodeZone\WPSupport\Router;

use CodeZone\WPSupport\Services\NoRendererException;
use Psr\Http\Message\ResponseInterface;
use function CodeZone\WPSupport\Services\wp_die;
use function CodeZone\WPSupport\Services\wp_redirect;
use function CodeZone\WPSupport\Services\wp_send_json;
use function CodeZone\WPSupport\Services\wp_send_json_error;

/**
 * Class ResponseResolver
 *
 * This class is responsible for rendering the response based on the provided ResponseInterface object.
 * @see https://www.php-fig.org/psr/psr-7/
 */
class ResponseResolver implements ResponseResolverInterface
{
    protected $renderer;

    /**
     * Constructor for the class.
     *
     * @param ResponseRendererInterface|null $renderer (optional) The response renderer object.
     */
    public function __construct( ResponseRendererInterface $renderer = null )
    {
        if ( $renderer ) {
            $this->set_renderer( $renderer );
        }
    }

    /**
     * Sets the response renderer.
     *
     * @param ResponseRendererInterface $renderer The response renderer object.
     */
    public function set_renderer(ResponseRendererInterface $renderer ) {
        $this->renderer = $renderer;
    }

    /**
     * Render method
     *
     * @param ResponseInterface $response The response object containing the headers and body to be rendered
     *
     * @return void
     * @see https://www.php-fig.org/psr/psr-7/
     */
    public function resolve( ResponseInterface $response ) {
        $headers = $response->getHeaders();

        foreach ( $headers as $key => $value ) {
            header( $key . ': ' . $value[0] );
        }

        $code_type = $this->guess_code_type( $response );

        switch ( $code_type ) {
            case 'redirect':
                $this->resolve_redirect( $response );
                break;
            case 'error':
                $this->resolve_error( $response );
                break;
            default:
                $this->resolve_success( $response );
                break;
        }
    }

    /**
     * Redirects the user to the specified location.
     *
     * @param ResponseInterface $response The response object.
     * @return void
     */
    protected function resolve_redirect( ResponseInterface $response ) {
        \wp_redirect( $response->getHeader( 'Location' )[0] );
        die();
    }

    protected function set_template_path( $template_path ) {
        $this->template_path = $template_path;
    }

    /**
     * Renders a successful response.
     *
     * @param ResponseInterface $response The response object.
     * @return void
     */
    protected function resolve_success( ResponseInterface $response ) {
        $is_json = $this->is_json( $response );

        if ( $is_json ) {
           $this->resolve_json( $response );
        } else {
            $this->render_html( $response );
        }
    }

    /**
     * Sends a JSON response based on the content of the provided response object.
     *
     * @param ResponseInterface $response The response object.
     * @return void
     */
    protected function resolve_json( ResponseInterface $response ) {
        \wp_send_json( \json_decode( $response->getBody() ) );
    }

    /**
     * Renders the HTML response.
     *
     * @param ResponseInterface $response The response object.
     *
     * @return void
     *
     * @throws NoRendererException If the renderer is not set.
     */
    protected function render_html( ResponseInterface $response ) {
        if ( $this->renderer ) {
            $this->renderer->render( $response );
        } else {
            echo $response->getBody(); //phpcs:ignore
            die();
        }
    }

    /**
     * Renders an error response based on the provided HTTP response.
     *
     * @param ResponseInterface $response The response object.
     * @return void
     */
    protected function resolve_error( ResponseInterface $response ) {
        $is_json = $this->is_json( $response );

        if ( $is_json ) {
            \wp_send_json_error( \json_decode( $response->getBody() ), $response->getStatusCode() );
            die();
        } else {
            \wp_die( \esc_html( $response->getBody() ), \esc_attr( $response->getStatusCode() ) );
        }
    }

    /**
     * Determines the type of code based on the HTTP response code.
     *
     * @param ResponseInterface $response The response object.
     * @return string The code type. Possible values are:
     *     - success: If the response code is between 200 and 299 (inclusive).
     *     - redirect: If the response code is between 300 and 399 (inclusive).
     *     - error: If the response code is between 400 and 499 (inclusive), or is 500 or greater.
     */
    protected function guess_code_type( ResponseInterface $response ) {
        $code = $response->getStatusCode();
        if ( $code >= 200 && $code < 300 ) {
            return 'success';
        }
        if ( $code >= 300 && $code < 400 ) {
            return 'redirect';
        }
        if ( $code >= 400 && $code < 500 ) {
            return 'error';
        }
        if ( $code >= 500 ) {
            return 'error';
        }
    }

    /**
     * Checks if the given response is in JSON format.
     *
     * @param ResponseInterface $response The response object to check.
     *
     * @return bool Returns true if the response is in JSON format, false otherwise.
     */
    protected function is_json( ResponseInterface $response ) {
        return $response->hasHeader( 'Content-Type' ) && $response->getHeader( 'Content-Type' )[0] ?? false === 'application/json';
    }
}
