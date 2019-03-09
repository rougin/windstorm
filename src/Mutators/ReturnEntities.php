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
     * @var string[]
     */
    protected $fields = array('*');

    /**
     * @var integer
     */
    protected $limit = 10;

    /**
     * @var integer
     */
    protected $offset = 0;

    /**
     * @var string
     */
    protected $table = '';

    /**
     * @var array
     */
    protected $wheres = array();

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
        $query->select($this->fields)->from($this->table);

        foreach ($this->wheres as $key => $value)
        {
            $query->where($key)->like("%$value%");
        }

        if ($this->limit === null)
        {
            return $query;
        }

        return $query->limit($this->limit, $this->offset);
    }

    /**
     * Sets a where like instance to the query.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return self
     */
    public function where($key, $value)
    {
        $this->wheres[$key] = $value;

        return $this;
    }
}
