<?php

namespace Tests;

use CodeZone\WPSupport\Config\DotArray;

class DotArrayTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_get_array_value_with_dot_notation()
    {
        $dot = new DotArray( [] );
        $dot->set( 'post.title', 'Hello World!' );
        $this->assertEquals( 'Hello World!', $dot->get( 'post.title' ) );
    }

    /**
     * @test
     */
    public function it_can_set_array_value_with_dot_notation()
    {
        $dot = new DotArray( [] );
        $dot->set( 'post.title', 'Hello World!' );
        $this->assertEquals( [ 'post' => [ 'title' => 'Hello World!' ] ], $dot->to_array() );
    }

    /**
     * @test
     */
    public function it_can_return_default_value_when_key_is_not_found()
    {
        $dot = new DotArray( [] );
        $this->assertEquals( 'default', $dot->get( 'post.title', 'default' ) );
    }
}
