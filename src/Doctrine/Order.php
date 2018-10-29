<?php

namespace Rougin\Windstorm\Doctrine;

use Rougin\Windstorm\Doctrine\Builder;
use Rougin\Windstorm\OrderInterface;

class Order implements OrderInterface
{
    protected $builder;

    protected $key;

    protected $order = 'ASC';

    protected $query;

    protected $type = '';

    public function __construct(Query $query, Builder $builder, $key, $type = '')
    {
        $this->builder = $builder;

        $this->key = $key;

        $this->query = $query;

        $this->type = $type;
    }

    public function ascending()
    {
        $this->order = 'ASC';

        return $this;
    }

    public function descending()
    {
        $this->order = 'DESC';

        return $this;
    }

    public function __call($method, $parameters)
    {
        $type = (string) strtolower($this->type) . 'OrderBy';

        $this->builder->$type($this->key, $this->order);

        $this->query = $this->query->builder($this->builder);

        $instance = array($this->query, (string) $method);

        return call_user_func_array($instance, $parameters);
    }

    public function __toString()
    {
        $type = (string) strtolower($this->type) . 'OrderBy';

        $this->builder->$type($this->key, $this->order);

        $this->query = $this->query->builder($this->builder);

        return (string) $this->query->__toString();
    }
}
