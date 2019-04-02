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
     * Sets a predefined query instance.
     *
     * @param \Rougin\Windstorm\QueryInterface $query
     */
    protected function query(QueryInterface $query)
    {
        $field = 'COUNT(*) as ' . $this->keyword;

        return $query->select($field)->from($this->table);
    }
}
