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
     * @var string
     */
    protected $primary;

    /**
     * Initializes the mixed instance.
     *
     * @param \Rougin\Windstorm\QueryInterface $query
     * @param string                           $primary
     */
    public function __construct(QueryInterface $query, $primary)
    {
        parent::__construct($query);

        $this->primary = $primary;
    }

    /**
     * Creates a new child instance and adds it to its children.
     *
     * @param  \Rougin\Windstorm\ChildInterface $child
     * @param  string                           $field
     * @return self
     */
    public function add(ChildInterface $child, $field)
    {
        $this->children[$field] = $child;

        return $this;
    }

    /**
     * Returns all added child instances.
     *
     * @return \Rougin\Windstorm\ChildInterface[]
     */
    public function all()
    {
        return $this->children;
    }

    /**
     * Returns the primary key of the parent table.
     *
     * @return string
     */
    public function primary()
    {
        return $this->primary;
    }
}
