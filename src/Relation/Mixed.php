<?php

namespace Rougin\Windstorm\Relation;

use Rougin\Windstorm\ChildInterface;
use Rougin\Windstorm\MixedInterface;
use Rougin\Windstorm\QueryInterface;

/**
 * Mixed
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Mixed extends Wrappable implements MixedInterface
{
    /**
     * @var \Rougin\Windstorm\ChildInterface[]
     */
    protected $children = array();

    /**
     * Initializes the mixed instance.
     *
     * @param \Rougin\Windstorm\QueryInterface   $query
     * @param \Rougin\Windstorm\ChildInterface[] $children
     */
    public function __construct(QueryInterface $query, array $children = array())
    {
        parent::__construct($query);

        $this->children = $children;
    }

    /**
     * Creates a new child instance and adds it to children.
     *
     * @param  string                           $column
     * @param  \Rougin\Windstorm\QueryInterface $query
     * @param  string                           $primary
     * @param  string                           $foreign
     * @return self
     */
    public function add($column, QueryInterface $query, $primary, $foreign)
    {
        $child = new Child($column, $query, $primary, $foreign);

        return $this->child($child);
    }

    /**
     * Returns all added child instances.
     *
     * @return \Rougin\Windstorm\ChildInterface[]
     */
    public function children()
    {
        return $this->children;
    }

    /**
     * Adds a new child instance directly to children.
     *
     * @param  \Rougin\Windstorm\ChildInterface $child
     * @return self
     */
    public function child(ChildInterface $child)
    {
        $this->children[] = $child;

        return $this;
    }
}
