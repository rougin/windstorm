<?php

namespace Rougin\Windstorm;

/**
 * Mixed Interface
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
interface MixedInterface extends QueryInterface
{
    /**
     * Creates a new child instance and adds it to children.
     *
     * @param  string                           $column
     * @param  \Rougin\Windstorm\QueryInterface $query
     * @param  string                           $local
     * @param  string                           $foreign
     * @return self
     */
    public function add($column, QueryInterface $query, $local, $foreign);

    /**
     * Returns all added child instances.
     *
     * @return \Rougin\Windstorm\ChildInterface[]
     */
    public function children();

    /**
     * Adds a new child instance directly to children.
     *
     * @param  \Rougin\Windstorm\ChildInterface $child
     * @return self
     */
    public function child(ChildInterface $child);
}
