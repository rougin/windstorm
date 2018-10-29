<?php

namespace Rougin\Windstorm\Doctrine;

use Rougin\Windstorm\Doctrine\Builder;
use Rougin\Windstorm\UpdateInterface;

/**
 * Update Query
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Update implements UpdateInterface
{
    /**
     * @var \Rougin\Windstorm\Doctrine\Builder
     */
    protected $builder;

    /**
     * @var \Rougin\Windstorm\Doctrine\Query
     */
    protected $query;

    /**
     * Initializes the query instance.
     *
     * @param \Rougin\Windstorm\Doctrine\Query   $query
     * @param \Rougin\Windstorm\Doctrine\Builder $builder
     * @param string                             $table
     * @param string                             $initial
     */
    public function __construct(Query $query, Builder $builder, $table, $initial)
    {
        $this->builder = $builder->update($table, $initial);

        $this->query = $query;
    }

    public function set($key, $value)
    {
        $this->builder->set($key, $value);

        return $this;
    }

    public function __call($method, $parameters)
    {
        $this->query = $this->query->builder($this->builder);

        $instance = array($this->query, (string) $method);

        return call_user_func_array($instance, $parameters);
    }
}
