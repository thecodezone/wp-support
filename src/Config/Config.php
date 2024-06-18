<?php

namespace CodeZone\WPSupport\Config;

/**
 * Represents a configuration class that allows access, modification, and merging of configuration settings.
 */
class Config implements ConfigInterface
{
    protected $config;

    /**
     * Class constructor.
     *
     * Initializes an instance of the class with the given configuration array.
     *
     * @param array $config An optional configuration array (default: []).
     *
     * @return void
     */
    public function __construct(array $config = [])
    {
        $this->config = new DotArray($config);
    }

    /**
     * Retrieves the value associated with the given key from the configuration.
     *
     * @param string $key The key to retrieve the value for.
     * @param mixed $default (optional) The default value to return if the key is not found. Defaults to null.
     *
     * @return mixed The value associated with the key, or the default value if the key is not found.
     */
    public function get($key, $default = null)
    {
        return $this->config->get($key, $default);
    }

    /**
     * Sets the value for the given key in the configuration.
     *
     * @param string $key The key to set the value for.
     * @param mixed $value The value to set for the specified key.
     *
     * @return void
     */
    public function set($key, $value)
    {
        $this->config->set($key, $value);
    }

    /**
     * Merges the given configuration array into the current configuration.
     *
     * @param array $config The configuration array to merge.
     *
     * @return void
     */
    public function merge(array $config)
    {
        $this->config = new DotArray(array_replace_recursive($this->config->to_array(), $config));
    }

    /**
     * Retrieves the configuration as an array.
     *
     * @return array The configuration as an array.
     */
    public function to_array(): array {
        return $this->config->to_array();
    }
}
