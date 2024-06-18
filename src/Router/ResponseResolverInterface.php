<?php
 namespace CodeZone\WPSupport\Router;

use Psr\Http\Message\ResponseInterface;

interface ResponseResolverInterface {
	public function resolve( ResponseInterface $response );
}
