<?php

namespace Tests\Config;

use CodeZone\WPSupport\Config\Config;
use CodeZone\WPSupport\Config\Loader;
use Tests\TestCase;

class LoaderTest extends TestCase
{
    public function test_load_single_file()
    {
        $config = new Config();
        $loader = new Loader( $config );
        $file = dirname( __DIR__ ) . '/fixtures/config/app.php';

        $loader->load( $file );

        $this->assertEquals( 'value', $config->get( 'app.key' ) );
        $this->assertEquals( 'bar', $config->get( 'app.nested.foo' ) );
    }

    public function test_load_many_files()
    {
        $config = new Config();
        $loader = new Loader( $config );
        $files = [
            dirname( __DIR__ ) . '/fixtures/config/app.php',
            dirname( __DIR__ ) . '/fixtures/config/database.php'
        ];

        $loader->load( $files );

        $this->assertEquals( 'value', $config->get( 'app.key' ) );
        $this->assertEquals( 'test_db', $config->get( 'database.db_name' ) );
    }

    public function test_load_non_array_file()
    {
        $config = new Config();
        $loader = new Loader( $config );
        $temp_file = tempnam( sys_get_temp_dir(), 'conf' ) . '.php';
        file_put_contents( $temp_file, '<?php return "not an array";' );

        $loader->load( $temp_file );

        $this->assertEmpty( $config->to_array() );
        unlink( $temp_file );
    }

    public function test_load_dir()
    {
        $config = new Config();
        $loader = new Loader( $config );
        $dir = dirname( __DIR__ ) . '/fixtures/config';

        $loader->load( $dir );

        $this->assertEquals( 'value', $config->get( 'app.key' ) );
        $this->assertEquals( 'test_db', $config->get( 'database.db_name' ) );
    }
}
