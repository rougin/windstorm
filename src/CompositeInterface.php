<?php

namespace Rougin\Windstorm;

/**
 * Composite Interface
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
interface CompositeInterface extends QueryInterface
{
    /**
     * Creates a new youngster instance and adds it to children.
     *
     * @param  string                           $column
     * @param  \Rougin\Windstorm\QueryInterface $query
     * @param  string                           $local
     * @param  string                           $foreign
     * @return self
     */
    public function add($column, QueryInterface $query, $local, $foreign);

    /**
     * Adds a new youngster instance directly to children.
     *
     * @param  \Rougin\Windstorm\ChildQueryInterface $youngster
     * @return self
     */
    public function youngster(YoungsterInterface $youngster);

    /**
     * Returns all added youngster instances.
     *
     * @return \Rougin\Windstorm\ChildQueryInterface[]
     */
    public function children();
}
