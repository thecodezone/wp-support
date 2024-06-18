<?php
 namespace CodeZone\PluginSupport\Router;

interface RouteInterface {
	public function as_uri( $uri ): \CodeZone\PluginSupport\Router\Route;
	public function with_middleware( $middleware ): \CodeZone\PluginSupport\Router\Route;
	public function with_request( $request ): \CodeZone\PluginSupport\Router\Route;
	public function with_routes( callable $register_routes ): \CodeZone\PluginSupport\Router\Route;
	public function from_file( $file ): \CodeZone\PluginSupport\Router\Route;
	public function dispatch(): \CodeZone\PluginSupport\Router\Route;
    public function render(): \CodeZone\PluginSupport\Router\Route;
}
