<?php

namespace Tests;

use CodeZone\WPSupport\Container\ProviderFactory;
use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Mockery;

class ProviderFactoryTest extends TestCase
{
    public function test_load_single_provider_by_instance()
    {
        $container = Mockery::mock( Container::class );
        $provider = Mockery::mock( AbstractServiceProvider::class );

        $container->shouldReceive( 'addServiceProvider' )
            ->once()
            ->with( $provider );

        $factory = new ProviderFactory( $container );
        $factory->load( $provider );
    }

    public function test_load_single_provider_by_string()
    {
        $container = Mockery::mock( Container::class );
        $provider = Mockery::mock( AbstractServiceProvider::class );

        $container->shouldReceive( 'get' )
            ->once()
            ->with( 'my-provider' )
            ->andReturn( $provider );

        $container->shouldReceive( 'addServiceProvider' )
            ->once()
            ->with( $provider );

        $factory = new ProviderFactory( $container );
        $factory->load( 'my-provider' );
    }

    public function test_load_many_providers()
    {
        $container = Mockery::mock( Container::class );
        $provider1 = Mockery::mock( AbstractServiceProvider::class );
        $provider2 = Mockery::mock( AbstractServiceProvider::class );

        $container->shouldReceive( 'addServiceProvider' )
            ->once()
            ->with( $provider1 );

        $container->shouldReceive( 'addServiceProvider' )
            ->once()
            ->with( $provider2 );

        $factory = new ProviderFactory( $container );
        $factory->load( [ $provider1, $provider2 ] );
    }

    public function test_boot_bootable_provider()
    {
        $container = Mockery::mock( Container::class );
        $provider = Mockery::mock( AbstractServiceProvider::class . ', ' . BootableServiceProviderInterface::class );

        $provider->shouldReceive( 'boot' )
            ->once();

        $factory = new ProviderFactory( $container );
        $factory->boot( $provider );
    }

    public function test_boot_non_bootable_provider()
    {
        $container = Mockery::mock( Container::class );
        $provider = Mockery::mock( AbstractServiceProvider::class );

        // Should not call boot()

        $factory = new ProviderFactory( $container );
        $factory->boot( $provider );

        $this->assertTrue( true ); // Just to have an assertion
    }
}
