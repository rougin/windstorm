<?php

namespace Rougin\Windstorm\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;
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
     * @var string
     */
    protected $initial;

    /**
     * @var \Doctrine\DBAL\Query\QueryBuilder
     */
    protected $builder;

    /**
     * @var \Rougin\Windstorm\Doctrine\Query
     */
    protected $query;

    /**
     * Initializes the query instance.
     *
     * @param \Rougin\Windstorm\Doctrine\Query  $query
     * @param \Doctrine\DBAL\Query\QueryBuilder $builder
     * @param string                            $table
     * @param string|null                       $initial
     */
    public function __construct(Query $query, QueryBuilder $builder, $table, $initial)
    {
        $this->builder = $builder->update($table, $initial);

        $this->query = $query;

        $this->initial = $initial;
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
        if ($this->initial && strpos($key, '.') === false)
        {
            $key = $this->initial . '.' . $key;
        }

        $placeholder = $key[0] === ':' ? $key : ':' . $key;

        $placeholder = str_replace('.', '_', $placeholder);

        $this->builder->setParameter($placeholder, $value);

        $key = (string) $key . ' = ' . $placeholder;

        $this->builder->add('set', (string) $key, true);

        return $this;
    }

    /**
     * Generates a WHERE query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\WhereInterface
     */
    public function where($key)
    {
        $this->query->builder($this->builder);

        return $this->query->where($key);
    }
}
