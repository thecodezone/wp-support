<?php

namespace Tests;

use CodeZone\DT\Factories\ContainerFactory;
use CodeZone\DT\Factories\ResponseFactory;
use CodeZone\DT\Factories\ServerRequestFactory;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use League\Container\Container;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Brain\Monkey;
use PHPUnit\Framework\TestCase as TestBase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TestCase extends TestBase {
    use MockeryPHPUnitIntegration;

    private $container;

    protected function setUp(): void
    {
        ContainerFactory::forget();
        $this->container = ContainerFactory::singleton();
        $this->container->add(ResponseInterface::class, function () {
            return new Response();
        });
        $this->container->add(ServerRequestInterface::class, function () {
            return ServerRequest::fromGlobals();
        });
    }

    protected function tearDown(): void
    {
        Monkey\tearDown();
        parent::tearDown();
    }

    protected function getContainer()
    {
        return $this->container;
    }
}
