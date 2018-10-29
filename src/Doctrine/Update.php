<?php

namespace Rougin\Windstorm\Doctrine;

use Rougin\Windstorm\Doctrine\Builder;
use Rougin\Windstorm\UpdateInterface;

class Update implements UpdateInterface
{
    protected $builder;

    protected $query;

    protected $table;

    public function __construct(Query $query, Builder $builder, $table, $initial)
    {
        $this->builder = $builder->update($table, $initial);

        $this->query = $query;

        $this->table = $table;
    }

    public function set($key, $value)
    {
        $this->builder->set($key, $value);

        return $this;
    }

    public function __call($method, $parameters)
    {
        $this->query = $this->query->builder($this->builder);

        $instance = array($this->query, (string) $method);

        return call_user_func_array($instance, $parameters);
    }
}
