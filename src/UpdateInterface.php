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
}
