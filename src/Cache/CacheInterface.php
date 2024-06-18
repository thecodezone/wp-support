<?php
namespace CodeZone\WPSupport\Cache;

interface CacheInterface {
	public function get( string $key );
	public function set( string $key, $value, int $expiration = 60 * 60 );
	public function delete( string $key );
	public function flush();
}
