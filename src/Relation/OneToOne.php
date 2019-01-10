<?php

namespace Rougin\Windstorm\Relation;

use Rougin\Windstorm\RelationInterface;

/**
 * One-To-One Relation
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class OneToOne extends Relation implements RelationInterface
{
    /**
     * Generates the query instance from relation.
     *
     * @param  string $primary
     * @param  string $foreign
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function make($primary, $foreign)
    {
        $fields = array_merge($this->columns(0), $this->columns(1));

        $query = $this->query;

        return $query->select($fields)->from($this->primary, $this->alias[0])
            ->innerJoin($this->foreign, $primary, $foreign);
    }
}
