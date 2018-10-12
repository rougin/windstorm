<?php

namespace Rougin\Windstorm\Query;

class InsertQuery extends AbstractQuery
{
    public function get()
    {
        $values = (array) $this->parts['values'];

        $keys = ' (' . implode(', ', array_keys($values)) . ')';

        $values = ' VALUES(' . implode(', ', $values) . ')';

        return 'INSERT INTO ' . $this->table() . $keys . $values;
    }
}
