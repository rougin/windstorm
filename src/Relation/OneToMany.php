<?php

namespace Rougin\Windstorm\Relation;

use Rougin\Windstorm\MixedInterface;
use Rougin\Windstorm\RelationInterface;

/**
 * One-To-Many Relation
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class OneToMany extends Relation implements RelationInterface
{
    /**
     * @var string
     */
    protected $column;

    /**
     * Sets the column name.
     *
     * @param  string $column
     * @return self
     */
    public function column($column)
    {
        $this->column = $column;

        return $this;
    }

    /**
     * Generates the query instance from relation.
     *
     * @param  string $primary
     * @param  string $foreign
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function make($primary, $foreign)
    {
        $this->field(1, (string) $foreign);

        $query = clone $this->query;

        $query = $query->select((array) $this->columns(0));

        $query->from($this->primary, (string) $this->alias[0]);

        $mixed = new Mixed($query);

        return $this->child($mixed, $primary, $foreign);
    }

    /**
     * Generates a child instance from the foreign table.
     *
     * @param  \Rougin\Windstorm\MixedInterface $mixed
     * @param  string                           $primary
     * @param  string                           $foreign
     * @return \Rougin\Windstorm\MixedInterface
     */
    protected function child(MixedInterface $mixed, $primary, $foreign)
    {
        $child = clone $this->query;

        $child = $child->select($this->columns(1, false));

        $child->from($this->foreign, $this->alias[1]);

        $mixed->add($this->column, $child, $primary, $foreign);

        return $mixed;
    }
}
