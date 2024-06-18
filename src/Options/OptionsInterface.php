<?php
namespace CodeZone\PluginSupport\Options;

interface OptionsInterface {
	public function get( string $key, $default = null, $required = false );
	public function set( string $key, $value ): bool;
}
