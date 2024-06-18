<?php
 namespace CodeZone\PluginSupport\Assets;

interface AssetQueueInterface {
	public function filter( array $scripts_whitelist, array $styles_whitelist );
	public function filter_scripts( array $whitelist );
	public function filter_styles( array $whitelist );
}
