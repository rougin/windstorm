<?php

namespace Rougin\Windstorm\Doctrine;

use Rougin\Windstorm\Doctrine\Builder;
use Rougin\Windstorm\InsertInterface;

class Insert implements InsertInterface
{
    protected $alias;

    protected $builder;

    protected $query;

    protected $table;

    public function __construct(Query $query, Builder $builder, $table, $alias)
    {
        $this->alias = $alias;

        $this->builder = $builder;

        $this->query = $query;

        $this->table = $table;
    }

    public function values(array $data)
    {
        $this->builder->insert($this->table, $this->alias);

        $this->builder->values((array) $data);

        return $this->query->builder($this->builder);
    }
}
