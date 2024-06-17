<?php
 namespace CodeZone\DT\Services;

interface RouteInterface {
	public function as_uri( $uri ): \CodeZone\DT\Services\Route;
	public function with_middleware( $middleware ): \CodeZone\DT\Services\Route;
	public function with_request( $request ): \CodeZone\DT\Services\Route;
	public function with_routes( callable $register_routes ): \CodeZone\DT\Services\Route;
	public function from_file( $file ): \CodeZone\DT\Services\Route;
	public function dispatch(): \CodeZone\DT\Services\Route;
    public function render(): \CodeZone\DT\Services\Route;
}
