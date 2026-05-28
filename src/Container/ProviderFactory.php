<?php

namespace CodeZone\WPSupport\Container;

use League\Container\Container;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Factory class responsible for managing the loading and initialization
 * of service providers within a dependency injection container.
 */
class ProviderFactory
{
    protected $container;

    public function __construct(Container &$container)
    {
        $this->container = $container;
    }

    /**
     * Loads one or multiple service providers into the container.
     *
     * @param mixed $from The service provider(s) to load. Can be a single provider identifier
     *                    or an array of identifiers.
     * @return array An empty array after loading the service provider(s).
     */
    public function load($from)
    {
        if (is_array($from)) {
            return $this->load_many($from);
        }

        if (!is_string($from)) {
            $provider = $from;
        } else {
            $provider = $this->container->get($from);
        }

        $this->container->addServiceProvider( $provider );
        $this->boot($provider);

        return [];
    }

    /**
     * Boots the provided service provider instance if it implements the bootable interface.
     *
     * @param object $provider_instance The service provider instance to boot. Must implement
     *                                   BootableServiceProviderInterface to be booted.
     * @return void
     */
    public function boot(AbstractServiceProvider $provider_instance)
    {
        if ( $provider_instance instanceof BootableServiceProviderInterface ) {
            $provider_instance->boot();
        }
    }

    /**
     * Loads multiple service providers into the container.
     *
     * @param array $from An array of service provider identifiers to load.
     * @return void
     */
    public function load_many(array $from)
    {
        foreach ( $from as $provider ) {
            $this->load($provider);
        }
    }
}
