<?php

namespace CodeZone\WPSupport\Router;

use GuzzleHttp\Psr7\Response;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use League\Route\Http\Exception\NotFoundException;
use League\Route\Strategy\ApplicationStrategy;
use League\Route\Strategy\StrategyInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use League\Route\Router;

/**
 * Class RouteServiceProvider
 *
 * This class is responsible for providing routes and middleware for the application.
 *
 * @see https://route.thephpleague.com/4.x/usage/
 * @see https://php-fig.org/psr/psr-7/
 * @package Your\Namespace
 */
abstract class RouteServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface {

    /**
     * Retrieves the files configuration from the config object.
     *
     * @return array The array containing file configuration.
     */
    abstract protected function files(): array;

    /**
     * Retrieves the middleware configuration for the routes.
     *
     * @return array The array containing the middleware configuration.
     */
    abstract protected function middleware(): array;

    /**
     * Provide the services that this provider is responsible for.
     *
     * @param string $id The ID to check.
     * @return bool Returns true if the given ID is provided, false otherwise.
     */
    public function provides( string $id ): bool
    {
        $services = [
            ServerRequestInterface::class,
            ResponseInterface::class,
            StrategyInterface::class,
            RouteInterface::class,
            ResponseRendererInterface::class,
            Router::class
        ];

        return in_array( $id, $services );
    }

    /**
     * Eager load the router and load any routes
     */
    public function boot(): void
    {
        $this->getContainer()->add( StrategyInterface::class, function () {
            return new ApplicationStrategy();
        } )->addMethodCall( 'setContainer', [ $this->getContainer() ] );

        $this->getContainer()->add( Router::class, function () {
            return new Router();
        } )->addMethodCall( 'setStrategy', [ $this->getContainer()->get( StrategyInterface::class ) ] );

        $this->getContainer()->add( ServerRequestInterface::class, function () {
            return ServerRequestFactory::from_globals();
        } );

        $this->getContainer()->add( ResponseInterface::class, function () {
            return new Response();
        } );

        $this->getContainer()->add( Router::class, function () {
            return $this->getContainer()->get( Router::class );
        } );

        $this->getContainer()->add( ResponseResolverInterface::class, function () {
            return new ResponseResolver();
        } );

        $this->getContainer()->add( RouteInterface::class, function () {
            return new Route(
                $this->getContainer()->get( Router::class ),
                $this->getContainer()->get( ServerRequestInterface::class ),
                $this->getContainer()->get( ResponseResolverInterface::class )
            );
        } );

        foreach ( $this->get_files() as $file ) {
            $this->process_file( $file );
        }
    }

    /**
     * Lazy load any services
     */
    public function register(): void
    {
        // We're using the boot method to eager load the router and middleware
    }

    /**
     * Get the file configuration.
     *
     * This method retrieves the files configuration by applying the 'route_files'
     * filter to the class property $files.
     *
     * @return array The file configuration.
     */
    protected function get_files() {
        return $this->files();
    }

    /**
     * Extracts and processes file information.
     *
     * @param array $file The array containing file configuration.
     * @return void
     * @throws \Exception When the file does not exist or the file rewrite requires a query variable.
     */
    protected function process_file( $file ) {
        $defaults = [
            'file' => '',
            'rewrite' => '',
            'query' => '',
        ];
        $file = array_merge( $defaults, $file );
        $file_path = $file['file'];

        if ( ! file_exists( $file_path ) ) {
            if ( WP_DEBUG ) {
                throw new \Exception( esc_html( "The file $file_path does not exist." ) );
            } else {
                return;
            }
        }

        add_filter( 'query_vars', function ( $vars ) use ( $file ) {
            return $this->file_query_vars( $file, $vars );
        }, 9, 1 );

        add_action( 'template_redirect', function () use ( $file ) {
            $this->file_template_redirect( $file );
        }, 1, 0 );
    }

    /**
     * Add file query variable to the list of query variables.
     *
     * @param array $file The file configuration.
     * @param array $vars The list of query variables.
     * @return array The updated list of query variables.
     */
    protected function file_query_vars( $file, $vars )
    {
        $vars[] = $file['query'];

        return $vars;
    }


    /**
     * Performs the template redirect for the specified file.
     *
     * @param array $file The array containing file configuration.
     * @return void
     */
    protected function file_template_redirect( $file ): void {
        if ( ! get_query_var( $file['query'] ) ) {
            return;
        }

        $this->resolve_file( $file );
    }

    /**
     * Renders the specified file.
     *
     * @param array $file The array containing file configuration.
     * @return void
     */
    protected function resolve_file( $file ) {
        $route = $this->getContainer()->get( RouteInterface::class );
        $this->route_file( $route, $file );

        if ( WP_DEBUG ) {
            $route->dispatch();
        } else {
            try {
                $route->dispatch();
            } catch ( NotFoundException $e ) {
                return;
            }
        }

        $route->resolve();
    }

    /**
     * Retrieves the file URI based on the file configuration.
     *
     * @param array $file The array containing file configuration.
     * @return string The file URI.
     */
    protected function file_uri($file ) {
        $query = get_query_var( $file['query'] );
        return '/' . trim( $query, '/' );
    }

    /**
     * Routes a file with the given route and file configuration.
     *
     * @param RouteInterface $route The route to be used for routing the file.
     * @param array $file The array containing file configuration.
     * @return RouteInterface The updated route.
     */
    protected function route_file(RouteInterface $route, $file ) {

        $route->middleware( $this->middleware() )
            ->file( $file['file'] )
            ->uri( $this->file_uri( $file ) );

        return $route;
    }
}
