<?php

namespace Rougin\Windstorm\Doctrine;

use Rougin\Windstorm\Doctrine\Builder;
use Rougin\Windstorm\UpdateInterface;

/**
 * Update Query
 *
 * @method \Rougin\Windstorm\QueryInterface select(array $fields)
 * @method \Rougin\Windstorm\QueryInterface from($table, $alias = null)
 * @method \Rougin\Windstorm\QueryInterface innerJoin($table, $local, $foreign)
 * @method \Rougin\Windstorm\QueryInterface leftJoin($table, $local, $foreign)
 * @method \Rougin\Windstorm\QueryInterface rightJoin($table, $local, $foreign)
 * @method \Rougin\Windstorm\InsertInterface insertInto($table)
 * @method \Rougin\Windstorm\UpdateInterface update($table, $alias = null)
 * @method \Rougin\Windstorm\QueryInterface deleteFrom($table, $alias = null)
 * @method \Rougin\Windstorm\WhereInterface where($key)
 * @method \Rougin\Windstorm\WhereInterface andWhere($key)
 * @method \Rougin\Windstorm\WhereInterface orWhere($key)
 * @method \Rougin\Windstorm\QueryInterface groupBy(array $fields)
 * @method \Rougin\Windstorm\HavingInterface having($key)
 * @method \Rougin\Windstorm\HavingInterface andHaving($key)
 * @method \Rougin\Windstorm\HavingInterface orHaving($key)
 * @method \Rougin\Windstorm\OrderInterface orderBy($key)
 * @method \Rougin\Windstorm\OrderInterface andOrderBy($key)
 * @method \Rougin\Windstorm\QueryInterface limit($limit, $offset = null)
 * @method \Rougin\Windstorm\QueryInterface sql()
 * @method \Rougin\Windstorm\QueryInterface bindings()
 * @method \Rougin\Windstorm\QueryInterface types()
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

    /**
     * Sets a new value for a column.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return self
     */
    public function set($key, $value)
    {
        $placeholder = $key[0] === ':' ? $key : ':' . $key;

        $this->builder->setParameter($placeholder, $value);

        $key = (string) $key . ' = ' . $placeholder;

        $this->builder->add('set', (string) $key, true);

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
        $this->query = $this->query->builder($this->builder);

        $instance = array($this->query, (string) $method);

        return call_user_func_array($instance, $parameters);
    }
}
