<?php

namespace Rougin\Windstorm\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Rougin\Windstorm\InsertInterface;

class Insert implements InsertInterface
{
    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

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
     * Sets the values to be inserted.
     *
     * @param  array  $data
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function values(array $data)
    {
        return $this->query->data($data);
    }
}
