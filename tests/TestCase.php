<?php

namespace Tests;

use Brain\Monkey;
use CodeZone\PluginSupport\Assets\AssetQueue;
use CodeZone\PluginSupport\Assets\AssetQueueInterface;
use CodeZone\PluginSupport\Cache\Cache;
use CodeZone\PluginSupport\Cache\CacheInterface;
use CodeZone\PluginSupport\Container\ContainerFactory;
use CodeZone\PluginSupport\Options\Options;
use CodeZone\PluginSupport\Options\OptionsInterface;
use CodeZone\PluginSupport\Router\ResponseResolver;
use CodeZone\PluginSupport\Router\ResponseResolverInterface;
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
