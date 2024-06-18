<?php

namespace Tests;

use CodeZone\WPSupport\Assets\AssetQueueInterface;

class AssetTest extends TestCase
{
    /**
     * @test
     */
    public function it_filters() {
        global $wp_styles, $wp_scripts;
        $wp_styles = new \stdClass();
        $wp_styles->queue = ['style1', 'style2'];
        $style1 = new \stdClass();
        $style1->handle = 'style1';
        $style2 = new \stdClass();
        $style2->handle = 'style2';
        $wp_styles->registered = ['style1' => $style1, 'style2' => $style2];
        $wp_scripts = new \stdClass();
        $wp_scripts->queue = ['script1', 'script2'];
        $script1 = new \stdClass();
        $script1->handle = 'script1';
        $script2 = new \stdClass();
        $script2->handle = 'script2';
        $wp_scripts->registered = ['script1' => $script1, 'script2' => $script2];

        $assetQueue = $this->getContainer()->get( AssetQueueInterface::class);
        $assetQueue->filter(['script1'], ['style1']);

        $this->assertEquals(['script1'], array_values($wp_scripts->queue));
        $this->assertEquals(['style1'], array_values($wp_styles->queue));
    }

    /**
     * @test
     */
    public function it_allows_vite() {
        global $wp_styles, $wp_scripts;
        $wp_styles = new \stdClass();
        $wp_styles->queue = ['style1', 'style2', 'vite-client-1'];
        $style1 = new \stdClass();
        $style1->handle = 'style1';
        $style2 = new \stdClass();
        $style2->handle = 'style2';
        $viteClient1 = new \stdClass();
        $viteClient1->handle = 'vite-client-1';
        $wp_styles->registered = ['style1' => $style1, 'style2' => $style2, 'vite-client-1' => $viteClient1];
        $wp_scripts = new \stdClass();
        $wp_scripts->queue = ['script1', 'script2', 'vite-client-1'];
        $script1 = new \stdClass();
        $script1->handle = 'script1';
        $script2 = new \stdClass();
        $script2->handle = 'script2';
        $viteClient1 = new \stdClass();
        $viteClient1->handle = 'vite-client-1';
        $wp_scripts->registered = ['script1' => $script1, 'script2' => $script2, 'vite-client-1' => $viteClient1];

        $assetQueue = $this->getContainer()->get( AssetQueueInterface::class);
        $assetQueue->filter(['script1'], ['style1']);

        $this->assertEquals(['script1', 'vite-client-1'], array_values($wp_scripts->queue));
        $this->assertEquals(['style1', 'vite-client-1'], array_values($wp_styles->queue));
    }
}
