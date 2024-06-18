<?php

namespace CodeZone\PluginSupport\Router;

use Psr\Http\Message\ResponseInterface;

interface ResponseRendererInterface {
    public function render( ResponseInterface $request );
}
