<?php
 namespace CodeZone\WPSupport\Router;

interface RouteInterface {
    public function rewrite( $route_query ) : self;
	public function middleware($middleware ): \CodeZone\WPSupport\Router\Route;
	public function request($request ): \CodeZone\WPSupport\Router\Route;
	public function routes(callable $register_routes ): \CodeZone\WPSupport\Router\Route;
	public function file($file ): \CodeZone\WPSupport\Router\Route;
	public function dispatch(): \CodeZone\WPSupport\Router\Route;
    public function resolve(): \CodeZone\WPSupport\Router\Route;
}
