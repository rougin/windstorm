<?php

namespace Rougin\Windstorm\Eloquent;

use Illuminate\Database\Eloquent\Builder;
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
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var \Rougin\Windstorm\Eloquent\Query
     */
    protected $query;

    /**
     * Initializes the query instance.
     *
     * @param \Rougin\Windstorm\Eloquent\Query      $query
     * @param \Illuminate\Database\Eloquent\Builder $builder
     */
    public function __construct(Query $query, Builder $builder)
    {
        $this->query = $query;

        $this->builder = $builder;
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
        $this->data[$key] = $value;

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
        $this->query->data($this->data);

        return $this->query->where($key);
    }
}
