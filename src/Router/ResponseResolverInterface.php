<?php
 namespace CodeZone\PluginSupport\Router;

use Psr\Http\Message\ResponseInterface;

interface ResponseResolverInterface {
	public function resolve( ResponseInterface $response );
}
