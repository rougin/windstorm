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
     * @param  \Rougin\Windstorm\ChildInterface $child
     * @param  string                           $field
     * @return self
     */
    public function add(ChildInterface $child, $field);

    /**
     * Returns all added child instances.
     *
     * @return \Rougin\Windstorm\ChildInterface[]
     */
    public function all();

    /**
     * Returns the primary key of the parent table.
     *
     * @return string
     */
    public function primary();
}
