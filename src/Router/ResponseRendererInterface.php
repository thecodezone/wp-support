<?php

namespace CodeZone\WPSupport\Router;

use Psr\Http\Message\ResponseInterface;

interface ResponseRendererInterface {
    public function render( ResponseInterface $request );
}
