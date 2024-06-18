<?php

namespace Tests;

use CodeZone\WPSupport\Router\ResponseFactory;
use CodeZone\WPSupport\Router\ResponseRendererInterface;
use CodeZone\WPSupport\Router\ResponseResolverInterface;
use Psr\Http\Message\ResponseInterface;

class ResponseTest extends TestCase {
    /**
     * @test
     */
    public function it_makes() {
        $response = ResponseFactory::make();
        $this->assertInstanceOf( ResponseInterface::class, $response );
        $this->assertEquals( 200, $response->getStatusCode() );
    }

    /**
     * @test
     */
    public function it_redirects()
    {
        $response = ResponseFactory::redirect( 'https://example.com' );
        $this->assertInstanceOf( ResponseInterface::class, $response );
        $this->assertEquals( 302, $response->getStatusCode() );
        $this->assertEquals( 'https://example.com', $response->getHeaderLine( 'Location' ) );
    }

    /**
     * @test
     */
    public function it_resolves()
    {
        $response = ResponseFactory::make();
        $renderer = $this->getMockBuilder( ResponseRendererInterface::class )
            ->getMock();
        $renderer->expects( $this->once() )
            ->method( 'render' )
            ->with( $response );
        $resolver = $this->getContainer()->get( ResponseResolverInterface::class );
        $resolver->set_renderer( $renderer );
        $output = $resolver->resolve( $response );
    }
}
