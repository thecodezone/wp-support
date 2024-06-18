<?php

namespace Tests;

use Brain\Monkey;
use CodeZone\WPSupport\Options\Options;

class OptionsTest extends TestCase {
    /**
     * @test
     */
    public function it_can_get_options()
    {
        Monkey\Functions\expect( 'get_option' )
            ->once()
            ->with( 'test_option', 'default' )
            ->andReturn( 'test_value' );

        $options = new Options(
            [ 'option' => 'default' ],
            'test'
        );

        $result = $options->get( 'option' );
    }

    /**
     * @test
     */
    public function it_can_set_new_options()
    {
        Monkey\Functions\expect( 'get_option' )
            ->once()
            ->with( 'test_option' )
            ->andReturn( false );

        Monkey\Functions\expect( 'add_option' )
            ->once()
            ->with( 'test_option', 'value' )
            ->andReturn( 1 );

        $options = new Options(
            [ 'option' => 'default' ],
            'test'
        );

        $result = $options->set( 'option', 'value' );

        $this->assertTrue( $result );
    }

    /**
     * @test
     */
    public function it_can_set_existing_options()
    {
        Monkey\Functions\expect( 'get_option' )
            ->once()
            ->with( 'test_option' )
            ->andReturn( 'some_value' );

        Monkey\Functions\expect( 'update_option' )
            ->once()
            ->with( 'test_option', 'value' )
            ->andReturn( 1 );

        $options = new Options(
            [ 'option' => 'default' ],
            'test'
        );

        $result = $options->set( 'option', 'value' );

        $this->assertTrue( $result );
    }
}
