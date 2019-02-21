<?php

namespace Rougin\Windstorm;

use Rougin\Windstorm\QueryInterface;
use Rougin\Windstorm\ResultInterface;

/**
 * Query Repository
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class QueryRepository
{
    /**
     * @var \Rougin\Windstorm\ResultInterface
     */
    protected $result;

    /**
     * @var \Rougin\Windstorm\MappingInterface
     */
    protected $mapping;

    /**
     * @var \Rougin\Windstorm\QueryInterface
     */
    protected $original;

    /**
     * @var \Rougin\Windstorm\QueryInterface
     */
    protected $query;

    /**
     * Initializes the repository instance.
     *
     * @param \Rougin\Windstorm\QueryInterface  $query
     * @param \Rougin\Windstorm\ResultInterface $result
     */
    public function __construct(QueryInterface $query, ResultInterface $result)
    {
        $this->result = $result;

        $this->query = $query;

        $this->original = $query;
    }

    /**
     * Returns a number of affected rows.
     *
     * @return integer
     */
    public function affected()
    {
        return $this->execute()->affected();
    }

    /**
     * Returns the first row from result.
     *
     * @return mixed
     */
    public function first()
    {
        $item = $this->execute()->first();

        if ($this->mapping)
        {
            return $this->mapping->map($item);
        }

        return $item;
    }

    /**
     * Returns all items from the result.
     *
     * @return mixed
     */
    public function items()
    {
        $result = $this->execute()->items();

        if ($this->mapping === null)
        {
            return $result;
        }

        foreach ($result as $key => $item)
        {
            $result[$key] = $this->mapping->map($item);
        }

        return $result;
    }

    /**
     * Sets the mapping instance.
     *
     * @param  \Rougin\Windstorm\MappingInterface $mapping
     * @return self
     */
    public function map(MappingInterface $mapping)
    {
        $this->mapping = $mapping;

        return $this;
    }

    /**
     * Returns the query instance.
     *
     * @return \Rougin\Windstorm\QueryRepository
     */
    public function query()
    {
        return clone $this->query;
    }

    /**
     * Mutates the specified query instance.
     *
     * @param  \Rougin\Windstorm\MutatorInterface $mutator
     * @return self
     */
    public function set(MutatorInterface $mutator)
    {
        $this->query = $mutator->set($this->query);

        return $this;
    }

    /**
     * Executes the result against query instance.
     *
     * @return \Rougin\Windstorm\ResultInterface
     */
    protected function execute()
    {
        return $this->result->execute($this->query);
    }
}
