<?php

namespace Tests;

use CodeZone\DT\Factories\ResponseFactory;
use Psr\Http\Message\ResponseInterface;

class ResponseTest extends TestCase {
    /**
     * @test
     */
    public function it_resolves() {
        $response = ResponseFactory::make();
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function it_redirects()
    {
        $response = ResponseFactory::redirect('https://example.com');
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('https://example.com', $response->getHeaderLine('Location'));
    }
}
