<?php

namespace Tests;

use Brain\Monkey;
use CodeZone\PluginSupport\Cache\CacheInterface;

class CacheTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_cache()
    {
        $key = 'foo';
        $value = 'bar';

        Monkey\Functions\when( 'get_transient' )->justReturn( $value );
        Monkey\Functions\when( 'set_transient' )->returnArg();

        $cache = $this->getContainer()->get( CacheInterface::class );
        $scoped_key = $cache->set( $key, $value );
        $result = $cache->get( $key );

        $this->assertEquals( $value, $result );
        $this->assertEquals( 'test_' . $key, $scoped_key );
    }

    /**
     * @test
     */
    public function it_can_delete()
    {
        $key = 'foo';

        Monkey\Functions\when( 'delete_transient' )->returnArg();

        $cache = $this->getContainer()->get( CacheInterface::class );
        $scoped_key = $cache->delete( $key );

        $this->assertEquals( 'test_' . $key, $scoped_key );
    }
}
