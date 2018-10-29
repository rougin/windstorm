<?php

namespace Rougin\Windstorm\Doctrine\Builder;

/**
 * Insert Query
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class InsertQuery extends AbstractQuery
{
    /**
     * Returns the compiled SQL.
     *
     * @return string
     */
    public function get()
    {
        $values = (array) $this->parts['values'];

        $keys = ' (' . implode(', ', array_keys($values)) . ')';

        $values = ' VALUES (' . implode(', ', $values) . ')';

        return 'INSERT INTO ' . $this->table() . $keys . $values;
    }
}
