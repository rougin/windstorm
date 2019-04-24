<?php

namespace Rougin\Windstorm;

use Rougin\Windstorm\MixedInterface;
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
     * @var \Rougin\Windstorm\MappingInterface|null
     */
    protected $mapping = null;

    /**
     * @var \Rougin\Windstorm\MixedInterface
     */
    protected $mixed = null;

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
    }

    /**
     * Returns a number of affected rows.
     *
     * @return integer
     */
    public function affected()
    {
        return $this->execute($this->query)->affected();
    }

    /**
     * Executes the result against query instance.
     *
     * @param  \Rougin\Windstorm\QueryInterface $query
     * @return \Rougin\Windstorm\ResultInterface
     */
    public function execute(QueryInterface $query)
    {
        return $this->result->execute($query);
    }

    /**
     * Returns the first row from result.
     *
     * @return mixed
     */
    public function first()
    {
        if ($this->mixed !== null)
        {
            return current($this->items());
        }

        $item = $this->execute($this->query)->first();

        if ($this->mapping && $item)
        {
            return $this->mapping->map($item);
        }

        return $item;
    }

    /**
     * Returns the last inserted ID.
     *
     * @return integer
     */
    public function inserted()
    {
        return $this->execute($this->query)->inserted();
    }

    /**
     * Returns all items from the result.
     *
     * @return mixed
     */
    public function items()
    {
        if ($this->mixed !== null)
        {
            $result = $this->combine();
        }
        else
        {
            $result = $this->execute($this->query)->items();
        }

        if ($this->mapping === null || ! $result)
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
     * @param  \Rougin\Windstorm\MappingInterface|null $mapping
     * @return self
     */
    public function map(MappingInterface $mapping = null)
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
        $query = $mutator->set($this->query);

        if ($query instanceof MixedInterface)
        {
            $this->mixed = $query;

            return $this;
        }

        $this->query = $query;

        return $this;
    }

    public function combine()
    {
        $parent = $this->execute($this->mixed)->items();

        $ids = array();

        foreach ($parent as $item)
        {
            $ids[] = (integer) $item[$this->mixed->primary()];
        }

        if (count($ids) === 0)
        {
            return $parent;
        }

        foreach ($this->mixed->all() as $field => $child)
        {
            $children = $child->andWhere($child->column())->in($ids);

            $children = $this->execute($children)->items();

            foreach ($parent as $index => $item)
            {
                $parent[$index][$field] = array();

                foreach ($children as $key => $value)
                {
                    if ($item[$this->mixed->primary()] === $value[$child->foreign()])
                    {
                        $parent[$index][$field][] = $value;

                        // unset($children[$key]);
                    }
                }
            }
        }

        return $parent;
    }
}
