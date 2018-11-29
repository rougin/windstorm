<?php

namespace Rougin\Windstorm;

use Rougin\Windstorm\QueryInterface;

/**
 * Mutator Interface
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
interface MutatorInterface
{
    /**
     * Mutates the specified query instance.
     *
     * @param \Rougin\Windstorm\QueryInterface $query
     */
    public function set(QueryInterface $query);
}
