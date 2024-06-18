<?php

namespace Tests;

use Brain\Monkey;
use CodeZone\WPSupport\Assets\AssetQueue;
use CodeZone\WPSupport\Assets\AssetQueueInterface;
use CodeZone\WPSupport\Cache\Cache;
use CodeZone\WPSupport\Cache\CacheInterface;
use CodeZone\WPSupport\Container\ContainerFactory;
use CodeZone\WPSupport\Options\Options;
use CodeZone\WPSupport\Options\OptionsInterface;
use CodeZone\WPSupport\Router\ResponseResolver;
use CodeZone\WPSupport\Router\ResponseResolverInterface;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
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
        $this->container->add(AssetQueueInterface::class, function () {
            return new AssetQueue();
        });
        $this->container->add(CacheInterface::class, function () {
            return new Cache(
                'test',
            );
        });
        $this->container->add(OptionsInterface::class, function () {
            return new Options(
                [ 'option' => 'default' ],
                'test'
            );
        });
        $this->container->add(ResponseResolverInterface::class, function () {
            return new ResponseResolver();
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
