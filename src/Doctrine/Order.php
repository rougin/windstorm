<?php

namespace Rougin\Windstorm\Doctrine;

use Rougin\Windstorm\Doctrine\Builder\Builder;
use Rougin\Windstorm\OrderInterface;

class Order implements OrderInterface
{
    protected $builder;

    protected $key;

    protected $query;

    protected $type = '';

    public function __construct(Query $query, Builder $builder, $key, $type = '')
    {
        $this->builder = $builder;

        $type === 'AND' && $this->type = 'add';

        $this->key = (string) $key;

        $this->query = $query;

        $type = strtolower($this->type) . 'OrderBy';

        $this->builder->$type($this->key, 'ASC');
    }

    public function ascending()
    {
        $type = strtolower($this->type) . 'OrderBy';

        $this->builder->$type($this->key, 'ASC');

        return $this->query->builder($this->builder);
    }

    public function descending()
    {
        $type = strtolower($this->type) . 'OrderBy';

        $this->builder->$type($this->key, 'DESC');

        return $this->query->builder($this->builder);
    }

    public function __call($method, $parameters)
    {
        $this->query = $this->query->builder($this->builder);

        $instance = array($this->query, (string) $method);

        return call_user_func_array($instance, $parameters);
    }

    public function __toString()
    {
        $this->query = $this->query->builder($this->builder);

        return $this->query->__toString();
    }
}
