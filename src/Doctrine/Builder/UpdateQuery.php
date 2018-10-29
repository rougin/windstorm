<?php

namespace Rougin\Windstorm\Doctrine\Builder;

/**
 * Update Query
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class UpdateQuery extends AbstractQuery
{
    /**
     * Returns the compiled SQL.
     *
     * @return string
     */
    public function get()
    {
        $set = (string) ' SET ' . implode(', ', $this->parts['set']);

        return 'UPDATE ' . $this->table() . $set . $this->where();
    }
}
