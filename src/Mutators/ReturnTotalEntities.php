<?php

namespace Rougin\Windstorm\Mutators;

use Rougin\Windstorm\QueryInterface;
use Rougin\Windstorm\MutatorInterface;

/**
 * Return Total Entities Mutator
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class ReturnTotalEntities implements MutatorInterface
{
    /**
     * @var callable|null
     */
    protected $callback = null;

    /**
     * @var string
     */
    protected $keyword = 'total';

    /**
     * @var string
     */
    protected $table = '';

    /**
     * Sets a where callback to the query instance.
     *
     * @param  callable $callback
     * @return self
     */
    public function callback($callback)
    {
        $this->callback = $callback;

        return $this;
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
     * Mutates the specified query instance.
     *
     * @param \Rougin\Windstorm\QueryInterface $query
     */
    public function set(QueryInterface $query)
    {
        $field = (string) 'COUNT(*) as ' . $this->keyword;

        $query = $query->select($field)->from($this->table);

        if ($this->callback !== null)
        {
            $callback = $this->callback;

            $query = $callback($query);
        }

        return $query;
    }
}
