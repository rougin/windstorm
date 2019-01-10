<?php

namespace Rougin\Windstorm\Relation;

use Rougin\Windstorm\YoungsterInterface;
use Rougin\Windstorm\CompositeInterface;
use Rougin\Windstorm\QueryInterface;

/**
 * Composite
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Composite extends Wrappable implements CompositeInterface
{
    protected $children = array();

    public function __construct(QueryInterface $query, array $children = array())
    {
        parent::__construct($query);

        $this->children = $children;
    }

    public function add($column, QueryInterface $query, $local, $foreign)
    {
        $youngster = new Youngster($column, $query, $local, $foreign);

        return $this->youngster($youngster);
    }

    public function youngster(YoungsterInterface $youngster)
    {
        $this->children[] = $youngster;

        return $this;
    }

    public function children()
    {
        return $this->children;
    }
}
