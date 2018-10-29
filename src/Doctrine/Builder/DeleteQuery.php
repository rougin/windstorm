<?php

namespace Rougin\Windstorm\Doctrine\Builder;

/**
 * Delete Query
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class DeleteQuery extends AbstractQuery
{
    /**
     * Returns the compiled SQL.
     *
     * @return string
     */
    public function get()
    {
        return 'DELETE FROM ' . $this->table() . $this->where();
    }
}
