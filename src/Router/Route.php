<?php

namespace CodeZone\WPSupport\Router;

use League\Route\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Route
 *
 * The Route class is responsible for handling routes and dispatching requests to the router.
 *
 * @package YourPackageName
 */
class Route implements RouteInterface
{
    /**
     * @var Router $router
     * The Router Instance.
     * @see https://route.thephpleague.com/4.x/usage/
     */
    protected $router;

    /**
     * The $request variable holds the HTTP request data.
     * @see https://www.php-fig.org/psr/psr-7/
     *
     * @var ServerRequestInterface | null
     */
    protected $request;

    /**
     * The $response variable holds the HTTP response data.
     * @see https://www.php-fig.org/psr/psr-7/
     *
     * @var ResponseInterface | null
     */
    protected $response;

    /**
     * The $renderer variable is used to generate HTML or JSON output from a Response.
     *
     * @var ResponseResolver
     */
    protected $resolver;

    /**
     * Class constructor.
     *
     * @param Router $router The router instance.
     * @param ServerRequestInterface $request The server request instance.
     * @param ResponseResolver $resolver The response renderer instance.
     */
    public function __construct( Router $router, ServerRequestInterface $request, ResponseResolver $resolver ) {
        $this->router = $router;
        $this->request = $request;
        $this->resolver = $resolver;
    }

    /**
     * Rewrites the query parameter in the request URI and returns an instance of the current class.
     *
     * @param string|array $route_query The new query parameter value or an associative array of query parameters.
     * @return self Returns an instance of the current class.
     */
    public function rewrite( $route_query ): self
    {
        $this->request = $this->request->withAttribute( 'ROUTE_PARAM', $route_query );
        return $this;
    }

    /**
     * Adds middleware to the router.
     *
     * @param mixed $middleware The middleware to add. Can be a string or an array of strings.
     *
     * @return self The instance of the class.
     */
    public function middleware( $middleware ): self {

        if ( is_array( $middleware ) ) {
            foreach ( $middleware as $m ) {
                $this->router->middleware( $m );
            }
            return $this;
        } else {
            $this->router->middleware( $middleware );
        }

        return $this;
    }


    /**
     * Sets the request for the route.
     *
     * @param mixed $request The request for the route.
     * @return self The instance of the class.
     */
    public function request( $request ): self {
        $this->request = $request;
        return $this;
    }

    /**
     * Adds routes to the router.
     *
     * @param callable $register_routes The callback function that registers routes to the router.
     * @return self The instance of the class.
     */
    public function routes( callable $register_routes ): self {
        $register_routes( $this->router );
        return $this;
    }

    /**
     * Loads routes from a file and adds them to the route collector.
     *
     * @param string $file The path to the file containing the routes.
     * @return self Returns an instance of the current class.
     */
    public function file( $file ): self {
        return $this->routes( function ( $r ) use ( $file ) {
            require_once $file;
        });
    }

    /**
     * Dispatches the request to the router and sets the response.
     *
     * @return self Returns an instance of the current class.
     */
    public function dispatch(): self {
        $this->response = $this->router->dispatch( $this->request );
        return $this;
    }

    /**
     * Sets the response renderer to be used for rendering the response.
     *
     * @param ResponseRendererInterface $renderer The response renderer to be set.
     *
     * @return self Returns an instance of the current class.
     */
    public function render_with( ResponseRendererInterface $renderer ): self {
        $this->resolver->set_renderer( $renderer );
        return $this;
    }

    /**
     * Renders the response using the renderer if it exists.
     * If the response is not set, it dispatches the request to the router first.
     *
     * @return self Returns an instance of the current class.
     */
    public function resolve(): self {
        if ( !$this->response ) {
          $this->dispatch();
        }

        if ( $this->response ) {
            $this->resolver->resolve( $this->response );
        }

        return $this;
    }
}
