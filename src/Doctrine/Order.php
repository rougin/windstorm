<?php

namespace Rougin\Windstorm\Doctrine;

use Rougin\Windstorm\Doctrine\Builder;
use Rougin\Windstorm\OrderInterface;

/**
 * Order Query
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Order implements OrderInterface
{
    /**
     * @var \Rougin\Windstorm\Doctrine\Builder
     */
    protected $builder;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $order = 'ASC';

    /**
     * @var \Rougin\Windstorm\Doctrine\Query
     */
    protected $query;

    /**
     * @var string
     */
    protected $type = '';

    /**
     * Initializes the query instance.
     *
     * @param \Rougin\Windstorm\Doctrine\Query   $query
     * @param \Rougin\Windstorm\Doctrine\Builder $builder
     * @param string                             $key
     * @param string                             $initial
     * @param string                             $type
     */
    public function __construct(Query $query, Builder $builder, $key, $initial, $type = '')
    {
        if (strpos($key, '.') === false)
        {
            $key = $initial . '.' . $key;
        }

        $this->builder = $builder;

        $this->key = $key;

        $this->query = $query;

        $this->type = $type;
    }

    /**
     * Sets the order in ascending.
     *
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function ascending()
    {
        $this->order = 'ASC';

        return $this;
    }

    /**
     * Sets the order in descending.
     *
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function descending()
    {
        $this->order = 'DESC';

        return $this;
    }

    /**
     * Calls a method from a QueryInterface instance.
     *
     * @param  string $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        $instance = array($this->set(), (string) $method);

        return call_user_func_array($instance, $parameters);
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
     * Sets the order type and calls a method from QueryInstance.
     *
     * @return \Rougin\Windstorm\QueryInterface
     */
    protected function set()
    {
        $type = strtolower($this->type) . 'OrderBy';

        $this->builder->$type($this->key, $this->order);

        return $this->query->builder($this->builder);
    }
}
