<?php

namespace Rougin\Windstorm;

/**
 * Update Interface
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
interface UpdateInterface
{
    /**
     * Sets a new value for a column.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return self
     */
    public function set($key, $value);

    /**
     * Calls a method from a QueryInterface instance.
     *
     * @param  string $method
     * @param  array  $parameters
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function __call($method, $parameters);
}
