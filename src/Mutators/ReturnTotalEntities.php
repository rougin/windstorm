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
     * @var integer|null
     */
    protected $limit = null;

    /**
     * @var integer|null
     */
    protected $offset = null;

    /**
     * Initializes the mutator instance.
     *
     * @param string|null $table
     */
    public function __construct($table = null)
    {
        if ($table)
        {
            $this->table = $table;
        }
    }

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
        $query->select('COUNT(*) as ' . $this->keyword);

        if (! $this->alias && $this->table)
        {
            $this->alias = $this->table[0];
        }

        return $query->from($this->table, $this->alias);
    }
}
