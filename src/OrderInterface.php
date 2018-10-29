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
}
