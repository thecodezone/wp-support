<?php

namespace CodeZone\WPSupport\Config;

/**
 * Class DotArray
 *
 * The DotArray class provides a way to access and manipulate nested arrays using dot notation.
 */
class DotArray
{
    protected $array;

    /**
     * Constructs a new object.
     *
     * @param array $array The array to be assigned to the object.
     *
     * @return void
     */
    public function __construct( array $array )
    {
        $this->array = $array;
    }

    /**
     * Retrieves the value of a given key from the array.
     *
     * @param string $key The key to retrieve the value for.
     * @param mixed $default (optional) The default value to return if the key is not found. Defaults to null.
     * @return mixed The value of the key if found, otherwise the default value.
     */
    public function get( $key, $default = null )
    {
        $path = explode( '.', $key );

        $temp = &$this->array;
        foreach ( $path as $dir ) {
            if ( !isset( $temp[$dir] ) ) {
                return $default;
            }
            $temp = &$temp[$dir];
        }

        return $temp;
    }

    /**
     * Sets the value of a given key in the array.
     *
     * @param string $key The key to set the value for.
     * @param mixed $value The value to set for the key.
     * @return $this
     */
    public function set( $key, $value )
    {
        $path = explode( '.', $key );

        $temp = &$this->array;
        foreach ( $path as $dir ) {
            if ( !isset( $temp[$dir] ) ) {
                $temp[$dir] = [];
            }
            $temp = &$temp[$dir];
        }

        $temp = $value;

        return $this;
    }

    /**
     * Converts the object into an array.
     *
     * @return array The array representation of the object.
     */
    public function to_array()
    {
        return $this->array;
    }
}
