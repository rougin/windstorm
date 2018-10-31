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
