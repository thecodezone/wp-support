<?php
 namespace CodeZone\WPSupport\Config;

/**
 * Represents a configuration class that allows access, modification, and merging of configuration settings.
 */
interface ConfigInterface {
	public function get( $key, $default = null );
	public function set( $key, $value );
	public function merge( array $config );
	public function to_array(): array;
}
