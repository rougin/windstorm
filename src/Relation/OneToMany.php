<?php

namespace Rougin\Windstorm\Relation;

use Rougin\Windstorm\CompositeInterface;
use Rougin\Windstorm\RelationInterface;

/**
 * One-To-Many Relation
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class OneToMany extends Relation implements RelationInterface
{
    protected $column;

    public function column($column)
    {
        $this->column = $column;

        return $this;
    }

    public function make($local, $foreign)
    {
        $this->field(1, (string) $foreign);

        $query = clone $this->query;

        $query = $query->select((array) $this->columns(0));

        $query->from($this->local, (string) $this->alias[0]);

        $composite = new Composite($query);

        return $this->child($composite, $local, $foreign);
    }

    protected function child(CompositeInterface $composite, $local, $foreign)
    {
        $child = clone $this->query;

        $child = $child->select($this->columns(1, false));

        $child->from($this->foreign, $this->alias[1]);

        $composite->add($this->column, $child, $local, $foreign);

        return $composite;
    }
}
