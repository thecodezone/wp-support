<?php

namespace CodeZone\WPSupport\Config;

class Loader
{
    protected $config;

    public function __construct( Config &$config ) {
        $this->config = $config;
    }

    public function load_dir( $dir ) {
        if ( ! is_dir( $dir ) ) {
            return;
        }

        $config_files = glob( $dir . '/*.php' );

        $this->load_many( $config_files );
    }

    public function load( $from ) {
        if ( empty( $from ) ) {
            return;
        }

        if ( is_array( $from ) ) {
            return $this->load_many( $from );
        }

        if ( is_dir( $from ) ) {
            return $this->load_dir( $from );
        }

        $file = $from;

        $name = basename( $file, '.php' );
        $data = require $file;

        if ( ! is_array( $data ) ) {
            return;
        }

        $this->config->merge( [ $name => $data ] );
    }

    public function load_many( array $config_files ) {
        foreach ( $config_files as $file ) {
           $this->load( $file );
        }
    }
}
