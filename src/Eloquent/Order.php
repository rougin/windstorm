<?php

namespace Rougin\Windstorm\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Rougin\Windstorm\OrderInterface;

/**
 * Order Query
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Order implements OrderInterface
{
    protected $key;

    protected $builder;

    protected $order = 'asc';

    protected $query;

    public function __construct(Query $query, Builder $builder, $key)
    {
        $this->query = $query;

        $this->builder = $builder;

        $this->key = $key;
    }

    /**
     * Sets the order in ascending.
     *
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function ascending()
    {
        $this->order = 'asc';

        return $this;
    }

    /**
     * Sets the order in descending.
     *
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function descending()
    {
        $this->order = 'desc';

        return $this;
    }

    /**
     * Calls a method from a QueryInterface instance.
     *
     * @param  string $method
     * @param  array  $parameters
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array(array($this->set(), $method), $parameters);
    }

    /**
     * Calls a __toString() from a QueryInterface instance.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->set()->__toString();
    }

    /**
     * Sets the query builder instance.
     *
     * @return \Rougin\Windstorm\QueryInterface
     */
    protected function set()
    {
        $this->builder = $this->builder->orderBy($this->key, $this->order);

        return $this->query->builder($this->builder);
    }
}
