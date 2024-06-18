<?php

namespace Tests;

use CodeZone\PluginSupport\Factories\ResponseFactory;
use CodeZone\PluginSupport\Factories\ServerRequestFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ServerRequestTest extends TestCase {
    /**
     * @test
     */
    public function it_resolves() {
        $response = ServerRequestFactory::from_globals();
        $this->assertInstanceOf(ServerRequestInterface::class, $response);
    }

    /**
     * @test
     */
    public function it_takes_custom_uri() {
        $response = ServerRequestFactory::with_uri('/test');
        $this->assertInstanceOf(ServerRequestInterface::class, $response);
        $this->assertEquals('/test', $response->getUri()->getPath());
    }
}
