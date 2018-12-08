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
     * @var \Rougin\Windstorm\MapperInterface
     */
    protected $mapper;

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
        return $this->map($this->execute()->first());
    }

    /**
     * Returns all items from the result.
     *
     * @return mixed
     */
    public function items()
    {
        $items = array();

        $result = $this->execute()->items();

        foreach ($result as $item)
        {
            $items[] = $this->map($item);
        }

        return $items;
    }

    /**
     * Sets the mapper instance.
     *
     * @param  \Rougin\Windstorm\MapperInterface $mapper
     * @return self
     */
    public function mapper(MapperInterface $mapper)
    {
        $this->mapper = $mapper;

        return $this;
    }

    /**
     * Mutates the specified query instance.
     *
     * @param  \Rougin\Windstorm\MutatorInterface $mutator
     * @return self
     */
    public function mutate(MutatorInterface $mutator)
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

    /**
     * Maps the result data into a mapper instance.
     *
     * @param  mixed $data
     * @return mixed
     */
    protected function map($data)
    {
        if ($this->mapper === null)
        {
            return (array) $data;
        }

        return $this->mapper->map($data);
    }
}
