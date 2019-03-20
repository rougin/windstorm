<?php

namespace Rougin\Windstorm\Mutators;

use Rougin\Windstorm\QueryInterface;

/**
 * Return Total Entities Mutator
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class ReturnTotalEntities extends ReturnEntities
{
    /**
     * @var string
     */
    protected $keyword = 'total';

    /**
     * Returns the keyword used in getting the field from the result.
     *
     * @return string
     */
    public function keyword()
    {
        return $this->keyword;
    }

    /**
     * Mutates the specified query instance.
     *
     * @param \Rougin\Windstorm\QueryInterface $query
     */
    public function set(QueryInterface $query)
    {
        $field = 'COUNT(*) as ' . $this->keyword;

        $query->select($field)->from($this->table);

        foreach ($this->wheres as $key => $value)
        {
            $query->where($key)->like("%$value%");
        }

        return $query;
    }
}
