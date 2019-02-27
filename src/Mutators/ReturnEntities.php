<?php

namespace Rougin\Windstorm\Mutators;

use Rougin\Windstorm\QueryInterface;
use Rougin\Windstorm\MutatorInterface;

/**
 * Return Entities Mutator
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class ReturnEntities implements MutatorInterface
{
    /**
     * @var callable|null
     */
    protected $callback = null;

    /**
     * @var string[]
     */
    protected $fields = array('*');

    /**
     * @var integer
     */
    protected $offset = 0;

    /**
     * @var integer
     */
    protected $limit = 10;

    /**
     * @var string
     */
    protected $table = '';

    /**
     * Initializes the mutator instance.
     *
     * @param integer|null $limit
     * @param integer      $offset
     */
    public function __construct($limit = 10, $offset = 0)
    {
        $this->limit = $limit;

        $this->offset = $offset;
    }

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
     * Returns the limit per result.
     *
     * @return integer
     */
    public function limit()
    {
        return $this->limit;
    }

    /**
     * Returns the offset of the current result.
     *
     * @return integer
     */
    public function offset()
    {
        return $this->offset;
    }

    /**
     * Mutates the specified query instance.
     *
     * @param \Rougin\Windstorm\QueryInterface $query
     */
    public function set(QueryInterface $query)
    {
        $query = $query->select($this->fields)->from($this->table);

        if ($this->callback !== null)
        {
            $callback = $this->callback;

            $query = $callback($query);
        }

        if ($this->limit === null)
        {
            return $query;
        }

        return $query->limit($this->limit, (integer) $this->offset);
    }
}
