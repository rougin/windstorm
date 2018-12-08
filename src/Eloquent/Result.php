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
     * @var integer
     */
    protected $affected = 0;

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
        return $this->affected;
    }

    /**
     * Returns a result from a query instance.
     *
     * @param  \Rougin\Windstorm\QueryInterface $query
     * @return \Rougin\Windstorm\ResultInterface
     */
    public function execute(QueryInterface $query)
    {
        $builder = $query->instance();

        if ($query->type() === QueryInterface::TYPE_SELECT)
        {
            $this->result = $builder->get();

            return $this;
        }

        $bindings = $query->bindings();

        switch ($query->type())
        {
            case QueryInterface::TYPE_INSERT:
                $this->affected = $builder->insert($bindings);

                break;
            case QueryInterface::TYPE_UPDATE:
                $this->affected = $builder->update($bindings);

                break;
            case QueryInterface::TYPE_DELETE:
                $this->affected = $builder->delete($bindings);

                break;
        }

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
