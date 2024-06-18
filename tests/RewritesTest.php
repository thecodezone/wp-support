<?php

use CodeZone\WPSupport\Options\Options;
use CodeZone\WPSupport\Rewrites\Rewrites;
use Tests\TestCase;

class RewritesTest extends TestCase {
    /**
     * @test
     */
    public function it_can_check_if_rewrite_exists()
    {
        global $wp_rewrite;
        $wp_rewrite = $this->getMockBuilder('StdClass')
            ->addMethods( [ 'wp_rewrite_rules' ] )
            ->getMock();

        $rules = [
            '^dt/plugin/api/?$' => 'index.php?dt-plugin-api=/',
            '^dt/plugin/api/(.+)/?' => 'index.php?dt-plugin-api=$matches[1]',
            '^dt/plugin/?$' => 'index.php?dt-plugin=/',
            '^dt/plugin/(.+)/?' => 'index.php?dt-plugin=$matches[1]',
        ];

        $wp_rewrite->expects( $this->any() )
            ->method( 'wp_rewrite_rules' )
            ->willReturn( $rules );

        $rewrites = new Rewrites( $rules );

        $this->assertTrue( $rewrites->exists( '^dt/plugin/api/(.+)/?' ) );
        $this->assertTrue( $rewrites->exists(  '^dt/plugin/api/(.+)/?', 'index.php?dt-plugin-api=$matches[1]' ) );
        $this->assertFalse( $rewrites->exists( '^dt/plugin/api/(.+)/?', 'index.php?dt-plugin=/' ) );
        $this->assertFalse($rewrites->exists( '^dt/wrong/api/(.+)/?' ) );

    }
}
