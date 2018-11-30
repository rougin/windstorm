<?php

namespace Rougin\Windstorm\Eloquent;

use Illuminate\Support\Collection;
use Rougin\Windstorm\QueryInterface;
use Rougin\Windstorm\ResultInterface;

/**
 * Result
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Result implements ResultInterface
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $result;

    /**
     * Returns a number of affected rows.
     *
     * @return integer
     */
    public function affected()
    {
        return $this->result->count();
    }

    /**
     * Returns a result from a query instance.
     *
     * @param  \Rougin\Windstorm\QueryInterface $query
     * @return \Rougin\Windstorm\ResultInterface
     */
    public function execute(QueryInterface $query)
    {
        $this->result = $query->instance()->get();

        return $this;
    }

    /**
     * Returns the first row from result.
     *
     * @return mixed
     */
    public function first()
    {
        return $this->result->first();
    }

    /**
     * Returns the first row from result.
     *
     * @return mixed
     */
    public function items()
    {
        return $this->result;
    }
}
