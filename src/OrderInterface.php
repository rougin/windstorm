<?php

namespace Rougin\Windstorm;

/**
 * Order Interface
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
interface OrderInterface
{
    /**
     * Sets the order in ascending.
     *
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function ascending();

    /**
     * Sets the order in descending.
     *
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function descending();

    /**
     * Calls a method from a QueryInterface instance.
     *
     * @param  string $method
     * @param  array  $parameters
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function __call($method, $parameters);

    /**
     * Calls a __toString() from a QueryInterface instance.
     *
     * @return string
     */
    public function __toString();
}
