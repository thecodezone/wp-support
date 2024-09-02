<?php

namespace Tests;

use CodeZone\WPSupport\Config\Config;

class ConfigTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_get_value_from_config()
    {
        $config = new Config( [ 'database' => [ 'host' => '127.0.0.1' ] ] );
        $this->assertEquals( '127.0.0.1', $config->get( 'database.host' ) );
    }

    /**
     * @test
     */
    public function it_can_set_value_in_config()
    {
        $config = new Config( [] );
        $config->set( 'database.host', 'localhost' );
        $this->assertEquals( 'localhost', $config->get( 'database.host' ) );
    }

    /**
     * @test
     */
    public function it_can_return_default_value_when_key_is_not_found()
    {
        $config = new Config( [] );
        $this->assertEquals( 'default', $config->get( 'database.host', 'default' ) );
    }

    /**
     * @test
     */
    public function it_can_merge_configs()
    {
        $config = new Config( [ 'database' => [ 'host' => '127.0.0.1', 'port' => 3306 ] ] );
        $config->merge( [ 'database' => [ 'port' => 3307 ] ] );
        $this->assertEquals([
            'database' => [
                'host' => '127.0.0.1',
                'port' => 3307,
            ]
        ], $config->to_array());
    }
}
